<?php

class listAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->hasRequestParameter('within') && is_numeric($this->getRequestParameter('within')))
        {
            $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Jobs | eMarketTurkey'));
            
            $this->keyword = str_replace(array("'", '"'), "", rtrim(ltrim($this->getRequestParameter('keyword'))));
            $this->within = PrivacyNodeTypePeer::PR_NTYP_JOB;
            $criterias['keyword'] = rtrim(ltrim($this->getRequestParameter('keyword')));
            $criterias['within'] = (array_key_exists($this->getRequestParameter('within'), $within)?$this->getRequestParameter('within'):null);
            
            //$this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("Search Results:") . " " . sfContext::getInstance()->getI18N()->__($within[$this->within]) . ' | eMarketTurkey');
                        
            $this->getUser()->addSearchTerm($criterias['keyword'], 'search/'.$criterias['within']);
            
            $c = new Criteria();
            
            $this->searchroute = '@jobs';
            $criterias['sector'] = is_numeric($this->getRequestParameter('sector'))?$this->getRequestParameter('sector'):'';
            $criterias['location'] = strtoupper($this->getRequestParameter('location'));
            
            if ($this->keyword != '')
            {
                $c1 = $c->getNewCriterion(JobPeer::JOB_POSITION_TITLE, "UPPER(".JobPeer::JOB_POSITION_TITLE.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
                $c1 = $c->getNewCriterion(JobI18nPeer::TITLE_DISPLAY_NAME, "UPPER(".JobI18nPeer::TITLE_DISPLAY_NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
                $c2 = $c->getNewCriterion(JobI18nPeer::DESCRIPTION, "dbms_lob.instr(".JobI18nPeer::DESCRIPTION.", '$this->keyword',1,1) > 0", Criteria::CUSTOM);
                $c3 = $c->getNewCriterion(JobI18nPeer::REQUIREMENTS, "UPPER(".JobI18nPeer::REQUIREMENTS.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
                $c4 = $c->getNewCriterion(JobI18nPeer::REQUIREMENTS, "UPPER(".JobI18nPeer::REQUIREMENTS.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
                $c1->addOr($c2);
                $c1->addOr($c3);
                $c1->addOr($c4);
                $c->addAnd($c1);
            }

            if ($criterias['location'] != '')
            {
                $c->addJoin(JobPeer::LOCATION_ID, GeonameCityPeer::GEONAME_ID, Criteria::LEFT_JOIN);
                $c->add(ContactAddressPeer::COUNTRY, $criterias['location']);
            }
            
            if ($criterias['sector'] != '' & is_numeric($criterias['sector']))
            {
                $c->add(CompanyPeer::SECTOR_ID, $criterias['sector']);
            } 
            
            $c->add(CompanyPeer::BLOCKED, 1, Criteria::NOT_EQUAL);
            
            $this->results = CompanyPeer::doSelect($c);
            $filtercats = array(
                'Sector' => array(
                    'sql' => "SELECT DISTINCT EMT_BUSINESS_SECTOR.ID, COUNT(*) AS RNUM
                              FROM EMT_COMPANY
                              LEFT JOIN EMT_BUSINESS_SECTOR ON EMT_COMPANY.SECTOR_ID=EMT_BUSINESS_SECTOR.ID
                              WHERE EMT_COMPANY.BLOCKED!=1
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
                              WHERE EMT_COMPANY.BLOCKED!=1 AND COUNTRY IS NOT NULL AND EMT_CONTACT_ADDRESS.TYPE=".ContactPeer::WORK."
                              ".($this->keyword!=''?"AND UPPER(EMT_COMPANY.NAME) LIKE UPPER('%".$this->keyword."%')":"")."
                              GROUP BY EMT_CONTACT_ADDRESS.COUNTRY
                              ORDER BY RNUM DESC",
                    'class' => new EmtCountry(),
                    'criteria' => 'location')
            );

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
