<?php

class listAddAction extends EmtManageAction
{
    public function execute($request)
    {
        return $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->isXmlHttpRequest()) header('Content-type: text/html');
        
        $this->typ = myTools::pick_from_list($this->getRequestParameter('_t'), array('friend', 'company', 'group', 'email'));

        $this->scope = null;
        $scp = myTools::unplug($this->getRequestParameter('_g'), true);
        if ($scp && $this->sesuser->isOwnerOf($scp))
        {
            $this->scope = $scp;
        }
        
        if ($this->scope && in_array($this->typ, array('friend', 'company', 'group')))
        {
            $maxRows = is_numeric($this->getRequestParameter('maxRows')) ? $this->getRequestParameter('maxRows', '20') : 20;
            $maxRows = $maxRows > 20 ? 20 : $maxRows;

            $con = Propel::getConnection();

            switch  ($this->typ)
            {
                case 'friend':
                    $filter = "P_OBJECT_TYPE_ID=1";
                    $join = "LEFT JOIN EMT_USER ECON ON RELL.P_OBJECT_ID=ECON.ID";
                    $peer = 'UserPeer';
                    $this->getResponse()->setTitle(($title = 'Select Friends') . ' | eMarketTurkey');
                    break;
                case 'company':
                    $filter = "P_OBJECT_TYPE_ID=2";
                    $join = "LEFT JOIN EMT_COMPANY ECON ON RELL.P_OBJECT_ID=ECON.ID";
                    $peer = 'CompanyPeer';
                    $this->getResponse()->setTitle(($title = 'Select Companies') . ' | eMarketTurkey');
                    break;
                case 'group':
                    $filter = "P_OBJECT_TYPE_ID=3";
                    $join = "LEFT JOIN EMT_GROUP ECON ON RELL.P_OBJECT_ID=ECON.ID";
                    $peer = 'GroupPeer';
                    $this->getResponse()->setTitle(($title = 'Select Groups') . ' | eMarketTurkey');
                    break;
                    
            }
            $sql = "
        SELECT ECON.* FROM 
        (
            SELECT PLS.*, RANK() OVER (PARTITION BY P_OBJECT_ID, P_OBJECT_TYPE_ID ORDER BY DEPTH) REPEAT FROM 
            (
                SELECT CONNECT_BY_ROOT P_OBJECT_ID CONN_OBJECT_ID, CONNECT_BY_ROOT P_OBJECT_TYPE_ID CONN_OBJECT_TYPE_ID , CONNECT_BY_ROOT P_ROLE_ID CONN_ROLE_ID , RELS.*, LEVEL DEPTH
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
                CONNECT BY NOCYCLE 
                    (
                        PRIOR P_OBJECT_ID=P_SUBJECT_ID AND PRIOR P_OBJECT_TYPE_ID=P_SUBJECT_TYPE_ID AND LEVEL < 3 
                        AND (
                                P_OBJECT_ID!={$this->sesuser->getId()} OR P_OBJECT_TYPE_ID!=".PrivacyNodeTypePeer::PR_NTYP_USER."
                            )
                        AND (
                                (CONNECT_BY_ROOT  P_OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND LEVEL=1)
                                 OR (CONNECT_BY_ROOT P_OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY." AND LEVEL=2 AND CONNECT_BY_ROOT P_ROLE_ID=".RolePeer::RL_CM_OWNER.") 
                                 OR (CONNECT_BY_ROOT P_OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_GROUP." AND LEVEL=2 AND CONNECT_BY_ROOT P_ROLE_ID=".RolePeer::RL_GP_OWNER.")
                            )
                    )
            ) PLS
        ) RELL
        $join
          WHERE ($filter)
          AND (P_OBJECT_TYPE_ID=CONN.CONN_TYPE_ID)
          ORDER BY DEPTH, P_OBJECT_TYPE_ID
            ";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $this->items = $peer::populateObjects($stmt);
        }
        else
        {
            $this->items = array();
        }

        if ($this->getRequest()->isXmlHttpRequest())
            return $this->renderPartial('listAdd', array('sf_params' => $this->getRequest()->getParameterHolder(), 'items' => $this->items, 'title' => $title, 'sf_request' => $this->getRequest()));
    }
    
    public function handleError()
    {
    }
    
}
