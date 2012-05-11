<?php

class resultsAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->hasRequestParameter('within') && is_numeric($this->getRequestParameter('within')))
        {
            $within = array(PrivacyNodeTypePeer::PR_NTYP_COMPANY => 'Companies',
                            PrivacyNodeTypePeer::PR_NTYP_PRODUCT => 'Products',
                            3                                    => 'Selling Leads',
                            4                                    => 'Buying Leads',
                            );
            $this->getResponse()->setTitle($this->getContext()->getI18N()->__($within[$this->getRequestParameter('within')] . ' | eMarketTurkey'));
            
            $this->keyword = str_replace(array("'", '"'), "", rtrim(ltrim($this->getRequestParameter('keyword'))));
            $this->within = $this->getRequestParameter('within');
            $criterias['keyword'] = rtrim(ltrim($this->getRequestParameter('keyword')));
            $criterias['within'] = (array_key_exists($this->getRequestParameter('within'), $within)?$this->getRequestParameter('within'):null);
            
            //$this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("Search Results:") . " " . sfContext::getInstance()->getI18N()->__($within[$this->within]) . ' | eMarketTurkey');
                        
            $this->getUser()->addSearchTerm($criterias['keyword'], 'search/'.$criterias['within']);
            
            $c = new Criteria();
            
            switch ($this->within){
                
            case PrivacyNodeTypePeer::PR_NTYP_COMPANY :
                $this->searchroute = '@companies';
                $criterias['sector'] = is_numeric($this->getRequestParameter('sector'))?$this->getRequestParameter('sector'):'';
                $criterias['location'] = strtoupper($this->getRequestParameter('location'));
                
                if ($this->keyword != '')
                {
                    $c->add(CompanyPeer::NAME, "UPPER(".CompanyPeer::NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
                }

                if ($criterias['location'] != '')
                {
                    $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
                    $c->add(ContactAddressPeer::TYPE, ContactPeer::WORK);
                    $c->add(ContactAddressPeer::COUNTRY, $criterias['location']);
                }
                
                if ($criterias['sector'] != '' & is_numeric($criterias['sector']))
                {
                    $c->add(CompanyPeer::SECTOR_ID, $criterias['sector']);
                } 
                
                $c->add(CompanyPeer::BLOCKED, 1, Criteria::NOT_EQUAL);
                $c->addJoin(CompanyPeer::ID, CompanyUserPeer::COMPANY_ID);
                $c->addJoin(CompanyUserPeer::OBJECT_ID, UserPeer::ID);
                $c->add(CompanyUserPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
                $c->add(CompanyUserPeer::ROLE_ID, RolePeer::RL_CM_OWNER);
                $c->addJoin(UserPeer::LOGIN_ID, BlocklistPeer::LOGIN_ID, Criteria::LEFT_JOIN);
                $c->add(BlocklistPeer::ID, NULL, Criteria::ISNULL);

                $this->results = CompanyPeer::doSelect($c);
                $filtercats = array(
                    'Sector' => array(
                        'sql' => "SELECT DISTINCT EMT_BUSINESS_SECTOR.ID, COUNT(*) AS RNUM
                                  FROM EMT_COMPANY
                                  LEFT JOIN EMT_BUSINESS_SECTOR ON EMT_COMPANY.SECTOR_ID=EMT_BUSINESS_SECTOR.ID
                                  LEFT JOIN EMT_COMPANY_USER ON EMT_COMPANY.ID=EMT_COMPANY_USER.COMPANY_ID
                                  LEFT JOIN EMT_USER ON EMT_COMPANY_USER.OBJECT_ID=EMT_USER.ID
                                  LEFT JOIN EMT_BLOCKLIST ON EMT_USER.LOGIN_ID=EMT_BLOCKLIST.LOGIN_ID
                                  WHERE EMT_COMPANY.BLOCKED!=1 AND EMT_COMPANY_USER.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_COMPANY_USER.ROLE_ID=".RolePeer::RL_CM_OWNER." AND EMT_BLOCKLIST.ID IS NULL
                                  ".($this->keyword!='' ? "AND UPPER(EMT_COMPANY.NAME) LIKE UPPER('%".$this->keyword."%')": "")."
                                  GROUP BY EMT_BUSINESS_SECTOR.ID
                                  ORDER BY RNUM DESC",
                        'class' => new BusinessSector(),
                        'criteria' => 'sector'),
                    'Location' => array(
                        'sql' => "SELECT DISTINCT EMT_CONTACT_ADDRESS.COUNTRY, COUNT(*) AS RNUM
                                  FROM EMT_COMPANY
                                  LEFT JOIN EMT_COMPANY_PROFILE ON EMT_COMPANY.PROFILE_ID=EMT_COMPANY_PROFILE.ID
                                  LEFT JOIN EMT_CONTACT ON EMT_COMPANY_PROFILE.CONTACT_ID=EMT_CONTACT.ID
                                  LEFT JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID
                                  LEFT JOIN EMT_COMPANY_USER ON EMT_COMPANY.ID=EMT_COMPANY_USER.COMPANY_ID
                                  LEFT JOIN EMT_USER ON EMT_COMPANY_USER.OBJECT_ID=EMT_USER.ID
                                  LEFT JOIN EMT_BLOCKLIST ON EMT_USER.LOGIN_ID=EMT_BLOCKLIST.LOGIN_ID
                                  WHERE EMT_COMPANY.BLOCKED!=1 AND EMT_COMPANY_USER.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_COMPANY_USER.ROLE_ID=".RolePeer::RL_CM_OWNER." AND EMT_BLOCKLIST.ID IS NULL
                                  AND COUNTRY IS NOT NULL AND EMT_CONTACT_ADDRESS.TYPE=".ContactPeer::WORK."
                                  ".($this->keyword!=''?"AND UPPER(EMT_COMPANY.NAME) LIKE UPPER('%".$this->keyword."%')":"")."
                                  GROUP BY EMT_CONTACT_ADDRESS.COUNTRY
                                  ORDER BY RNUM DESC",
                        'class' => new EmtCountry(),
                        'criteria' => 'location')
                );
                break;
            case PrivacyNodeTypePeer::PR_NTYP_PRODUCT :
                $this->searchroute = '@products';
                $criterias['category'] = is_numeric($this->getRequestParameter('category'))?$this->getRequestParameter('category'):'';
                $criterias['location'] = strtoupper($this->getRequestParameter('location'));
                
                if ($criterias['category']!='')
                {
                    $c->addJoin(ProductPeer::CATEGORY_ID, ProductCategoryPeer::ID, Criteria::LEFT_JOIN);
                    $c->add(ProductCategoryPeer::ID, $criterias['category']);
                }
                if ($criterias['location']!='')
                {
                    $c->addJoin(ProductPeer::COMPANY_ID, CompanyPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
                    $c->add(ContactAddressPeer::COUNTRY, $criterias['location']);
                }
                
                if ($this->keyword != '')
                {
                    $c->addJoin(ProductPeer::ID, ProductI18nPeer::ID, Criteria::LEFT_JOIN);
                    $c->add(ProductI18nPeer::DISPLAY_NAME, "UPPER(".ProductI18nPeer::DISPLAY_NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
                }
                
                $c->add(ProductPeer::ACTIVE, 1);
                $c->setLimit(20);
                
                $this->results = ProductPeer::doSelect($c);

                $filtercats = array(
                    'Category' => array(
                        'sql' => "SELECT DISTINCT CATEGORY, COUNT(*) AS RNUM
                                  FROM (
                                  SELECT DISTINCT EMT_PRODUCT.*, EMT_PRODUCT_CATEGORY.ID AS CATEGORY FROM EMT_PRODUCT
                                  LEFT JOIN EMT_PRODUCT_I18N ON EMT_PRODUCT.ID=EMT_PRODUCT_I18N.ID
                                  LEFT JOIN EMT_PRODUCT_CATEGORY ON EMT_PRODUCT.CATEGORY_ID=EMT_PRODUCT_CATEGORY.ID
                                  WHERE EMT_PRODUCT.ACTIVE=1
                                  ".($this->keyword!='' ? "AND UPPER(EMT_PRODUCT_I18N.DISPLAY_NAME) LIKE UPPER('%".$this->keyword."%')" : "") . " 
                                  )
                                  GROUP BY CATEGORY
                                  ORDER BY RNUM DESC",
                        'class' => new ProductCategory(),
                        'criteria' => 'category'),
                    'Location' => array(
                        'sql' => "SELECT DISTINCT COUNTRY, COUNT(*) AS RNUM
                                  FROM (
                                  SELECT DISTINCT EMT_PRODUCT.*, COUNTRY FROM EMT_PRODUCT
                                  LEFT JOIN EMT_PRODUCT_I18N ON EMT_PRODUCT.ID=EMT_PRODUCT_I18N.ID
                                  LEFT JOIN EMT_PRODUCT_CATEGORY ON EMT_PRODUCT.CATEGORY_ID=EMT_PRODUCT_CATEGORY.ID
                                  LEFT JOIN EMT_COMPANY ON EMT_PRODUCT.COMPANY_ID=EMT_COMPANY.ID
                                  LEFT JOIN EMT_COMPANY_PROFILE ON EMT_COMPANY.PROFILE_ID=EMT_COMPANY_PROFILE.ID
                                  LEFT JOIN EMT_CONTACT ON EMT_COMPANY_PROFILE.CONTACT_ID=EMT_CONTACT.ID
                                  LEFT JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID
                                  WHERE EMT_PRODUCT.ACTIVE=1 AND EMT_CONTACT_ADDRESS.TYPE=".ContactPeer::WORK." AND COUNTRY IS NOT NULL
                                  ".($this->keyword!='' ? "AND UPPER(EMT_PRODUCT_I18N.DISPLAY_NAME) LIKE UPPER('%".$this->keyword."%')" : "")."
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
        }
        else
        {
            $this->redirect('@homepage');
        }
    }
    
    public function handleError()
    {
    }
    
}
