<?php

class postAction extends EmtManageAction
{
    
    public function execute($request)
    {
        $user = $this->sesuser;
        
        $type = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('type')), 
            array(PrivacyNodeTypePeer::PR_NTYP_STATUS_UPDATE,
                  PrivacyNodeTypePeer::PR_NTYP_POST_LOCATION,
                  PrivacyNodeTypePeer::PR_NTYP_POST_LINK,
                  PrivacyNodeTypePeer::PR_NTYP_POST_VIDEO,
                  PrivacyNodeTypePeer::PR_NTYP_POST_JOB,
                  PrivacyNodeTypePeer::PR_NTYP_POST_OPPORTUNITY,
                  ), null);

        switch ($type)
        {
            case PrivacyNodeTypePeer::PR_NTYP_STATUS_UPDATE :
                break;
            case PrivacyNodeTypePeer::PR_NTYP_POST_LOCATION :
                if ($this->hasRequestParameter('location_data'))
                {
                    $data = json_decode($this->getRequestParameter('location_data'));
                    $location = new PostLocation();
                    $location->setLatitude($data->result->latitude);
                    $location->setLongitude($data->result->longitude);
                    $location->setData($this->getRequestParameter('location_data'));
                    $result = array_values(myTools::executeSql("
                            select ext_geoname.geoname_id from ext_geoname_hierarchy
                            left join ext_geoname on ext_geoname_hierarchy.child_id=ext_geoname.geoname_id
                            left join ext_geoname_country on ext_geoname_hierarchy.parent_id=ext_geoname_country.geoname_id
                            where ext_geoname_country.country='".$data->result->country."' 
                                and (ext_geoname.feature_code='ADM1' or ext_geoname.feature_code='ADM2') 
                                and regexp_like (alternatenames, '(^".$data->result->town_city.",|,".$data->result->town_city.",|,".$data->result->town_city."$)')
                    ", null, true));
                    $location->setCity($result[0][0]);

                    $post = WallPostPeer::postItem($this->sesuser, null, $location, RolePeer::RL_ALL);

                    if ($post) $this->redirect($this->_ref ? $this->_ref : $this->_referer);
                    else $this->redirect($this->_referer);
                }
                break;
            case PrivacyNodeTypePeer::PR_NTYP_POST_LINK :
                // save url
                // display page title with message
                // no photo for beginning
                break;
            case PrivacyNodeTypePeer::PR_NTYP_POST_VIDEO :
                // save url
                // while printing parse url and use vieo id in embed code 
                $query = parse_url($url, PHP_URL_QUERY);
                parse_str($query, $vals);
                $youtube_id = $vals['v'];
                break;
            case PrivacyNodeTypePeer::PR_NTYP_POST_JOB :
                break;
            case PrivacyNodeTypePeer::PR_NTYP_POST_OPPORTUNITY :
                break;
        }

    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}