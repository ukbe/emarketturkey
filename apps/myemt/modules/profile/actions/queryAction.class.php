<?php

class queryAction extends EmtManageAction
{
    public function execute($request)
    {
        if ($this->hasRequestParameter('callback'))
        {
            $keyword = $this->getRequestParameter('keyword');
            $coverage = myTools::pick_from_list($this->getRequestParameter('coverage'), array('public', 'network'), 'network');

            $scope = null;
            
            $scp = $this->getRequestParameter('scope');
            $scp = explode('|', base64_decode($scp));

            if (count($scp)==2)
            {
                $scp[0] = myTools::fixInt($scp[0]);
                $scp[1] = myTools::fixInt(myTools::flipHash($scp[1], true, $scp[0]));
                if ($scp[0] && $scp[1] && $this->sesuser->isOwnerOf($scp[1], $scp[0]))
                {
                    $scope = PrivacyNodeTypePeer::retrieveObject($scp[1], $scp[0]);
                }
            }
            
            $maxRows = myTools::fixInt($this->getRequestParameter('maxRows', 20));
            $maxRows = $maxRows > 20 ? 20 : $maxRows;
            
            if ($coverage == 'network' && $scope)
            {
                $maxRows = is_numeric($this->getRequestParameter('maxRows')) ? $this->getRequestParameter('maxRows', '20') : 20;
                $maxRows = $maxRows > 20 ? 20 : $maxRows;

                $con = Propel::getConnection();

                switch  ($scp[0])
                {
                    case PrivacyNodeTypePeer::PR_NTYP_USER:
                        $filter = "(DEPTH=1 AND P_OBJECT_TYPE_ID=1)";
                        break;
                    case PrivacyNodeTypePeer::PR_NTYP_COMPANY:
                        $filter = "(CONNECT_OBJECT_TYPE_ID=2 AND CONNECT_OBJECT_ID={$scp[1]} AND CONNECT_ROLE_ID=8 AND DEPTH=2)";
                        break;
                    case PrivacyNodeTypePeer::PR_NTYP_GROUP:
                        $filter = "(CONNECT_OBJECT_TYPE_ID=3 AND CONNECT_OBJECT_ID={$scp[1]} AND CONNECT_ROLE_ID=13 AND DEPTH=2)";
                        break;
                        
                }
                $sql = "
            SELECT CONN.CONN_NAME LABEL, CONN.CONN_ID ID, CONN.CONN_TYPE_ID TYPE_ID FROM 
            (
                SELECT PLS.*, RANK() OVER (PARTITION BY P_OBJECT_ID, P_OBJECT_TYPE_ID ORDER BY DEPTH) REPEAT FROM 
                (
                    SELECT CONNECT_BY_ROOT P_OBJECT_ID CONNECT_OBJECT_ID, CONNECT_BY_ROOT P_OBJECT_TYPE_ID CONNECT_OBJECT_TYPE_ID , CONNECT_BY_ROOT P_ROLE_ID CONNECT_ROLE_ID , RELS.*, LEVEL DEPTH
                    FROM 
                    (
                        SELECT 
                            OBJECT_ID P_OBJECT_ID, 
                            1 P_OBJECT_TYPE_ID, 
                            SUBJECT_ID P_SUBJECT_ID, 
                            1 P_SUBJECT_TYPE_ID, 
                            ROLE_ID P_ROLE_ID
                        FROM 
                        (
                            SELECT USER_ID SUBJECT_ID, RELATED_USER_ID OBJECT_ID, ROLE_ID FROM
                            (
                              SELECT * FROM EMT_RELATION_VIEW WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE."
                              
                              UNION ALL
                              
                              SELECT ID, RELATED_USER_ID USER_ID, COMPANY_ID, USER_ID RELATED_USER_ID, RELATED_COMPANY_ID, ROLE_ID, STATUS, CREATED_AT, UPDATED_AT, SEQNUMBER FROM EMT_RELATION_VIEW WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE."
                            )
                        )
                    
                        UNION ALL 
                    
                        SELECT 
                            GROUP_ID P_OBJECT_ID, 
                            ".PrivacyNodeTypePeer::PR_NTYP_GROUP." P_OBJECT_TYPE_ID, 
                            OBJECT_ID P_SUBJECT_ID, 
                            OBJECT_TYPE_ID P_SUBJECT_TYPE_ID, 
                            ROLE_ID P_ROLE_ID
                        FROM EMT_GROUP_MEMBERSHIP_VIEW 
                        WHERE STATUS=1
                  
                        UNION ALL
                  
                        SELECT 
                            OBJECT_ID P_OBJECT_ID, 
                            OBJECT_TYPE_ID P_OBJECT_TYPE_ID, 
                            GROUP_ID P_SUBJECT_ID, 
                            ".PrivacyNodeTypePeer::PR_NTYP_GROUP." P_SUBJECT_TYPE_ID, 
                            CASE
                                WHEN ROLE_ID=".RolePeer::RL_GP_MEMBER." THEN ".RolePeer::RL_MEMBERED_GROUP."
                                WHEN ROLE_ID=".RolePeer::RL_GP_FOLLOWER." THEN ".RolePeer::RL_FOLLOWED_GROUP."
                                ELSE ROLE_ID
                            END P_ROLE_ID
                        FROM EMT_GROUP_MEMBERSHIP_VIEW
                        WHERE STATUS=".GroupMembershipPeer::STYP_ACTIVE."
            
                        UNION ALL 
                    
                        SELECT 
                            COMPANY_ID P_OBJECT_ID, 
                            ".PrivacyNodeTypePeer::PR_NTYP_COMPANY." P_OBJECT_TYPE_ID, 
                            OBJECT_ID P_SUBJECT_ID, 
                            OBJECT_TYPE_ID P_SUBJECT_TYPE_ID, 
                            ROLE_ID P_ROLE_ID
                        FROM EMT_COMPANY_USER_VIEW
                        WHERE STATUS=".CompanyUserPeer::CU_STAT_ACTIVE."
            
                        UNION ALL
            
                        SELECT 
                            OBJECT_ID P_OBJECT_ID, 
                            OBJECT_TYPE_ID P_OBJECT_TYPE_ID, 
                            COMPANY_ID P_SUBJECT_ID, 
                            ".PrivacyNodeTypePeer::PR_NTYP_COMPANY." P_SUBJECT_TYPE_ID, 
                            CASE
                            WHEN ROLE_ID=".RolePeer::RL_CM_PARENT_COMPANY." THEN ".RolePeer::RL_CM_SUBSIDIARY_COMPANY."
                            WHEN ROLE_ID=".RolePeer::RL_CM_SUBSIDIARY_COMPANY." THEN ".RolePeer::RL_CM_PARENT_COMPANY."
                            ELSE ROLE_ID
                            END P_ROLE_ID
                        FROM EMT_COMPANY_USER_VIEW
                        WHERE STATUS=".CompanyUserPeer::CU_STAT_ACTIVE."
            
                    ) RELS
                    START WITH P_SUBJECT_ID={$this->sesuser->getId()} AND P_SUBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."
                    CONNECT BY NOCYCLE (PRIOR P_OBJECT_ID=P_SUBJECT_ID AND PRIOR P_OBJECT_TYPE_ID=P_SUBJECT_TYPE_ID AND LEVEL < 3 AND (P_OBJECT_ID!={$this->sesuser->getId()} OR P_OBJECT_TYPE_ID!=".PrivacyNodeTypePeer::PR_NTYP_USER."))
                ) PLS
            ) RELL
            LEFT JOIN (
              SELECT ".PrivacyNodeTypePeer::PR_NTYP_USER." CONN_TYPE_ID, ID CONN_ID, DISPLAY_NAME || ' ' || DISPLAY_LASTNAME CONN_NAME FROM EMT_USER
              UNION
              SELECT ".PrivacyNodeTypePeer::PR_NTYP_COMPANY." CONN_TYPE_ID, ID CONN_ID, NAME CONN_NAME FROM EMT_COMPANY
              UNION
              SELECT ".PrivacyNodeTypePeer::PR_NTYP_GROUP." CONN_TYPE_ID, ID CONN_ID, NAME CONN_NAME FROM EMT_GROUP
            ) CONN ON RELL.P_OBJECT_ID=CONN.CONN_ID
              WHERE ($filter)
              AND (P_OBJECT_TYPE_ID=CONN.CONN_TYPE_ID) AND ROWNUM <= $maxRows
              AND UPPER(CONN.CONN_NAME) LIKE UPPER('%$keyword%')
              ORDER BY P_OBJECT_TYPE_ID, ".myTools::NLSFunc('LABEL', 'SORT')."
  
                ";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($items as $key => $item)
                {
                    $items[$key]['HASH'] = base64_encode($item['TYPE_ID'].'|'.myTools::flipHash($item['ID'], false, $item['TYPE_ID']));
                    unset($items[$key]['ID']);
                }
                $items = array('ITEMS' => $items);
            }
            elseif ($coverage == 'public' && ($types = $this->getRequestParameter('object_type')) && ($this->getUser()->hasCredential('admin') || $this->getUser()->hasCredential('editor')))
            {
                $con = Propel::getConnection();
                
                $sql = array();
                if (in_array(PrivacyNodeTypePeer::PR_NTYP_USER, $types))
                    $sql[] = "SELECT DISPLAY_NAME || ' ' || DISPLAY_LASTNAME LABEL, ID, ".PrivacyNodeTypePeer::PR_NTYP_USER." TYPE_ID FROM EMT_USER";
                if (in_array(PrivacyNodeTypePeer::PR_NTYP_COMPANY, $types))
                    $sql[] = "SELECT NAME LABEL, ID, ".PrivacyNodeTypePeer::PR_NTYP_COMPANY." TYPE_ID FROM EMT_COMPANY";
                if (in_array(PrivacyNodeTypePeer::PR_NTYP_GROUP, $types))
                    $sql[] = "SELECT NAME LABEL, ID, ".PrivacyNodeTypePeer::PR_NTYP_GROUP." TYPE_ID FROM EMT_GROUP";

                $sql = "
            SELECT CONN.LABEL, CONN.ID, CONN.TYPE_ID FROM 
            (
                ".implode(' UNION ALL ', $sql)."
            ) CONN 
            WHERE ".myTools::NLSFunc('CONN.LABEL', 'UPPER')." LIKE ".myTools::NLSFunc("'%$keyword%'", 'UPPER')." AND ROWNUM <= $maxRows
  
                ";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($items as $key => $item)
                {
                    $items[$key]['HASH'] = base64_encode($item['TYPE_ID'].'|'.myTools::flipHash($item['ID'], false, $item['TYPE_ID']));
                    unset($items[$key]['ID']);
                }
                $items = array('ITEMS' => $items);
            }
            else
            {
                $items = array('ITEMS' => array());
            }
            return $this->renderText($this->getRequestParameter('callback') . "(" . json_encode($items) . ");");
        }
        return $this->renderText('Not Applicable');
    }
    
    public function handleError()
    {
    }
    
}
