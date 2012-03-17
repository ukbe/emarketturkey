<?php

class resultsAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->getRequestParameter('act') == 'ret' && !$this->getRequest()->isXmlHttpRequest() )
        {
            $this->redirect(str_ireplace('act=ret', '', $this->getRequest()->getUri()));
        }
        
        $withintypes = array(PrivacyNodeTypePeer::PR_NTYP_GROUP => 'Groups',
                             PrivacyNodeTypePeer::PR_NTYP_USER => 'People'
                        );
        $this->withintypes = $withintypes;
        $this->keyword = str_replace(array("'", '"'), "", rtrim(ltrim($this->getRequestParameter('keyword'))));
        $this->within = $this->getRequestParameter('within');
        
        $this->redirectIf($this->within == null, '@homepage');
        
        $this->getResponse()->setTitle($this->getContext()->getI18n()->__($withintypes[$this->getRequestParameter('within')] . ' | eMarketTurkey'));
        
        $criterias['keyword'] = rtrim(ltrim($this->getRequestParameter('keyword')));
        $criterias['within'] = (array_key_exists($this->getRequestParameter('within'), $withintypes)?$this->getRequestParameter('within'):null);
        
        $this->getUser()->addSearchTerm($criterias['keyword'], 'search/'.$criterias['within']);
        
        $c = new Criteria();
        switch ($this->within)
        {
            case PrivacyNodeTypePeer::PR_NTYP_USER :
                $criterias['location'] = strtoupper($this->getRequestParameter('location'));

                if ($criterias['location']!='')
                {
                    $c->addJoin(UserPeer::PROFILE_ID, UserProfilePeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(UserProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
                    if ($criterias['location']=='XX')
                        $c->add(ContactAddressPeer::COUNTRY, null, Criteria::ISNULL);
                    else
                        $c->add(ContactAddressPeer::COUNTRY, $criterias['location']);
                }
                
                if ($this->keyword != '')
                {
                    $c->add(UserPeer::NAME, "NLS_LOWER(".UserPeer::NAME." || ' ' || ".UserPeer::LASTNAME.") LIKE NLS_LOWER('%".$this->keyword."%') AND NLS_LOWER(".UserPeer::NAME.") != 'demo'", Criteria::CUSTOM);
                }
                else
                {
                    $c->add(UserPeer::NAME, "NLS_LOWER(".UserPeer::NAME.") != 'demo'", Criteria::CUSTOM);
                }

                $c->addJoin(UserPeer::LOGIN_ID, BlocklistPeer::LOGIN_ID, Criteria::LEFT_JOIN);
                $c->add(BlocklistPeer::ID, NULL, Criteria::ISNULL);

                $table = new EmtAjaxTable('users');
                $table->setStaticParams(array('within' => PrivacyNodeTypePeer::PR_NTYP_USER));
                $table->init($c);
        
                $this->table = $table;
        
                if ($this->getRequestParameter('act') == 'ret')
                {
                    $this->setTemplate('retrieveUsers');
                    $this->setLayout(false);
                }
                
                $filtercats = array(
                    'Location' => array(
                        'sql' => "SELECT DISTINCT COUNTRY, COUNT(*) AS RNUM
                                  FROM (
                                  SELECT DISTINCT EMT_USER.*, COUNTRY FROM EMT_USER
                                  LEFT JOIN EMT_BLOCKLIST ON EMT_USER.LOGIN_ID=EMT_BLOCKLIST.LOGIN_ID
                                  LEFT JOIN EMT_USER_PROFILE ON EMT_USER.PROFILE_ID=EMT_USER_PROFILE.ID
                                  LEFT JOIN EMT_CONTACT ON EMT_USER_PROFILE.CONTACT_ID=EMT_CONTACT.ID
                                  LEFT JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID
                                  WHERE (EMT_BLOCKLIST.ACTIVE!=1 OR EMT_BLOCKLIST.ID IS NULL)
                                  AND NLS_LOWER(EMT_USER.NAME) != 'demo'
                                  ".($this->keyword!='' ? "AND NLS_LOWER(EMT_USER.NAME || ' ' || EMT_USER.LASTNAME) LIKE NLS_LOWER('%".$this->keyword."%')" : "")."
                                  )
                                  GROUP BY COUNTRY
                                  ORDER BY RNUM DESC",
                        'class' => new EmtCountry(),
                        'criteria' => 'location')
                );
                
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                $criterias['type'] = is_numeric($this->getRequestParameter('type'))?$this->getRequestParameter('type'):'';
                $criterias['location'] = strtoupper($this->getRequestParameter('location'));

                if ($criterias['location']!='')
                {
                    $c->addJoin(GroupPeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
                    if ($criterias['location']=='XX')
                        $c->add(ContactAddressPeer::COUNTRY, null, Criteria::ISNULL);
                    else
                        $c->add(ContactAddressPeer::COUNTRY, $criterias['location']);
                }
                
                if ($criterias['type']!='')
                {
                    $c->add(GroupPeer::TYPE_ID, $criterias['type']);
                }
                
                
                if ($this->keyword != '')
                {
                    $c->addJoin(GroupI18nPeer::ID, GroupPeer::ID);
                    $c1 = $c->getNewCriterion(GroupPeer::NAME, "NLS_LOWER(".GroupPeer::NAME.") LIKE NLS_LOWER('%".$this->keyword."%')", Criteria::CUSTOM);
                    $c2 = $c->getNewCriterion(GroupI18nPeer::DISPLAY_NAME, "NLS_LOWER(".GroupI18nPeer::DISPLAY_NAME.") LIKE NLS_LOWER('%".$this->keyword."%')", Criteria::CUSTOM);
                    $c3 = $c->getNewCriterion(GroupI18nPeer::ABBREVIATION, "NLS_LOWER(".GroupI18nPeer::ABBREVIATION.") LIKE NLS_LOWER('%".$this->keyword."%')", Criteria::CUSTOM);
                    $c1->addOr($c2);
                    $c2->addOr($c3);

                    // In order to bypass missing I18n Record problem, we should add the criterias below: $c11, $c22, $c33
                    $c11 = $c->getNewCriterion(GroupPeer::NAME, "NLS_LOWER(".GroupPeer::NAME.") LIKE NLS_LOWER('%".$this->keyword."%')", Criteria::CUSTOM);
                    $c22 = $c->getNewCriterion(GroupI18nPeer::DISPLAY_NAME, NULL, Criteria::ISNULL);
                    $c33 = $c->getNewCriterion(GroupI18nPeer::ABBREVIATION, NULL, Criteria::ISNULL);
                    $c11->addAnd($c22);
                    $c22->addAnd($c33);

                    $c1->addOr($c11);
                    $c->add($c1);
                }
                
                $c->addJoin(GroupPeer::ID, GroupMembershipPeer::GROUP_ID);
                $c->addJoin(GroupMembershipPeer::OBJECT_ID, UserPeer::ID);
                $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
                $c->add(GroupMembershipPeer::ROLE_ID, RolePeer::RL_GP_OWNER);
                $c->addJoin(UserPeer::LOGIN_ID, BlocklistPeer::LOGIN_ID, Criteria::LEFT_JOIN);
                $c->add(BlocklistPeer::ID, NULL, Criteria::ISNULL);
                
                $table = new EmtAjaxTable('groups');
                $table->setStaticParams(array('within' => PrivacyNodeTypePeer::PR_NTYP_GROUP));
                $table->init($c);
        
                $this->table = $table;
        
                if ($this->getRequestParameter('act') == 'ret')
                {
                    $this->setTemplate('retrieveGroups');
                    $this->setLayout(false);
                }
                 
            
                $filtercats = array(
                    'Type' => array(
                        'sql' => "SELECT DISTINCT GROUP_TYPE_ID, COUNT(*) AS RNUM
                                  FROM 
                                  (
                                      SELECT DISTINCT EMT_GROUP.ID GROUP_ID, EMT_GROUP_TYPE.ID GROUP_TYPE_ID FROM EMT_GROUP
                                      LEFT JOIN EMT_GROUP_TYPE ON EMT_GROUP.TYPE_ID=EMT_GROUP_TYPE.ID
                                      LEFT JOIN EMT_GROUP_I18N ON EMT_GROUP.ID=EMT_GROUP_I18N.ID
                                      LEFT JOIN EMT_GROUP_MEMBERSHIP ON EMT_GROUP.ID=EMT_GROUP_MEMBERSHIP.GROUP_ID
                                      LEFT JOIN EMT_USER ON EMT_GROUP_MEMBERSHIP.OBJECT_ID=EMT_USER.ID
                                      LEFT JOIN EMT_BLOCKLIST ON EMT_USER.LOGIN_ID=EMT_BLOCKLIST.LOGIN_ID
                                      WHERE EMT_GROUP.BLOCKED!=1 AND EMT_GROUP_MEMBERSHIP.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_GROUP_MEMBERSHIP.ROLE_ID=". RolePeer::RL_GP_OWNER ." AND EMT_BLOCKLIST.ID IS NULL  
                                      ".($this->keyword!='' ? "AND 
                                      (
                                        NLS_LOWER(EMT_GROUP.NAME) LIKE NLS_LOWER('%{$this->keyword}%') OR
                                        NLS_LOWER(EMT_GROUP_I18N.DISPLAY_NAME) LIKE NLS_LOWER('%{$this->keyword}%') OR
                                        NLS_LOWER(EMT_GROUP_I18N.ABBREVIATION) LIKE NLS_LOWER('%{$this->keyword}%') OR
                                        (
                                            NLS_LOWER(EMT_GROUP.NAME) LIKE NLS_LOWER('%{$this->keyword}%') AND
                                            EMT_GROUP_I18N.DISPLAY_NAME IS NULL AND
                                            EMT_GROUP_I18N.ABBREVIATION IS NULL
                                        ) 
                                      )  
                                      ": "")."
                                  )
                                  GROUP BY GROUP_TYPE_ID
                                  ORDER BY RNUM DESC",
                        'class' => new GroupType(),
                        'criteria' => 'type'),
                    'Location' => array(
                        'sql' => "SELECT DISTINCT COUNTRY, COUNT(*) AS RNUM
                                  FROM 
                                  (
                                      SELECT DISTINCT EMT_GROUP.ID GROUP_ID, EMT_CONTACT_ADDRESS.COUNTRY COUNTRY FROM EMT_GROUP
                                      LEFT JOIN EMT_CONTACT ON EMT_GROUP.CONTACT_ID=EMT_CONTACT.ID
                                      LEFT JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID
                                      LEFT JOIN EMT_GROUP_I18N ON EMT_GROUP.ID=EMT_GROUP_I18N.ID
                                      LEFT JOIN EMT_GROUP_MEMBERSHIP ON EMT_GROUP.ID=EMT_GROUP_MEMBERSHIP.GROUP_ID
                                      LEFT JOIN EMT_USER ON EMT_GROUP_MEMBERSHIP.OBJECT_ID=EMT_USER.ID
                                      LEFT JOIN EMT_BLOCKLIST ON EMT_USER.LOGIN_ID=EMT_BLOCKLIST.LOGIN_ID
                                      WHERE EMT_GROUP.BLOCKED!=1 AND EMT_GROUP_MEMBERSHIP.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_GROUP_MEMBERSHIP.ROLE_ID=". RolePeer::RL_GP_OWNER ." AND EMT_BLOCKLIST.ID IS NULL  
                                      AND (EMT_CONTACT_ADDRESS.TYPE=".ContactPeer::WORK." OR EMT_CONTACT_ADDRESS.ID IS NULL)
                                      ".($this->keyword!='' ? "AND 
                                      (
                                        NLS_LOWER(EMT_GROUP.NAME) LIKE NLS_LOWER('%{$this->keyword}%') OR
                                        NLS_LOWER(EMT_GROUP_I18N.DISPLAY_NAME) LIKE NLS_LOWER('%{$this->keyword}%') OR
                                        NLS_LOWER(EMT_GROUP_I18N.ABBREVIATION) LIKE NLS_LOWER('%{$this->keyword}%') OR
                                        (
                                            NLS_LOWER(EMT_GROUP.NAME) LIKE NLS_LOWER('%{$this->keyword}%') AND
                                            EMT_GROUP_I18N.DISPLAY_NAME IS NULL AND
                                            EMT_GROUP_I18N.ABBREVIATION IS NULL
                                        ) 
                                      )  
                                      ": "")."
                                  )
                                  GROUP BY COUNTRY
                                  ORDER BY RNUM DESC",
                        'class' => new EmtCountry(),
                        'criteria' => 'location')
                );
                break; 
        }
        
        $con = Propel::getConnection();
        foreach ($filtercats as $cat => $data)
        {
            $stmt = $con->prepare($data['sql']);
            $stmt->execute();
            $results = array();
            $partcount = 0;
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) 
            {
                $obj = clone $data['class'];
                $obj->hydrate($row);
                $results[] = array('object' => $obj,
                                   'count' => $row[count($row)-1]);
                $partcount += $row[count($row)-1];
            }
            $filtercats[$cat]['results'] = $results;
            $filtercats[$cat]['total'] = $partcount;
        }
        $this->filtercats = $filtercats;
        $this->criterias = $criterias;
        
        $this->getUser()->setAttribute('srctype', $this->criterias['within']);

        return sfView::SUCCESS;
    }
    
    public function handleError()
    {
    }
    
}
