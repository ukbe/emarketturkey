<?php

class postAction extends EmtManageAction
{
    
    public function execute($request)
    {
        $user = $this->sesuser;
        
        $type = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('type')), 
            array(PrivacyNodeTypePeer::PR_NTYP_POST_STATUS,
                  PrivacyNodeTypePeer::PR_NTYP_POST_LOCATION,
                  PrivacyNodeTypePeer::PR_NTYP_POST_LINK,
                  PrivacyNodeTypePeer::PR_NTYP_POST_VIDEO,
                  PrivacyNodeTypePeer::PR_NTYP_POST_JOB,
                  PrivacyNodeTypePeer::PR_NTYP_POST_OPPORTUNITY,
                  ), null);

        switch ($type)
        {
            case PrivacyNodeTypePeer::PR_NTYP_POST_STATUS :
                if ($this->hasRequestParameter('status-message'))
                {
                    $status = new PostStatus();
                    $status->setMessage($this->getRequestParameter('status-message'));

                    $post = WallPostPeer::postItem($this->sesuser, null, $status, RolePeer::RL_ALL);

                    if ($post) $this->redirect($this->_ref ? $this->_ref : $this->_referer);
                    else $this->redirect($this->_referer);
                }
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
                if ($this->hasRequestParameter('pvideo'))
                {
                    $videodata = PostVideoPeer::parseVideoUrl($this->getRequestParameter('pvideo'));

                    $video = new PostVideo();
                    $video->setTitle($videodata['title']);
                    $video->setUrl($this->getRequestParameter('pvideo'));
                    $video->setMessage($this->getRequestParameter('video-comment'));
                    $video->setVideoId($videodata['video_id']);
                    $video->setServiceId($videodata['service_id']);
                    $video->save();

                    MediaItemPeer::createMediaItemFromRemoteFile($video->getId(), $video->getObjectTypeId(), MediaItemPeer::MI_TYP_VIDEO_PREVIEW, $video->getRemoteThumbUrl());

                    $post = WallPostPeer::postItem($this->sesuser, null, $video, RolePeer::RL_ALL);

                    if ($post) $this->redirect($this->_ref ? $this->_ref : $this->_referer);
                    else $this->redirect($this->_referer);
                    // Embed DailyMotion Video: <object width="425" height="335"><param name="movie" value="http://www.dailymotion.com/swf/xpul0b"><param name="allowfullscreen" value="true"><embed src="http://www.dailymotion.com/swf/xpul0b" type="application/x-shockwave-flash" width="425" height="335" allowfullscreen="true"></object>
                }
                break;
            case PrivacyNodeTypePeer::PR_NTYP_POST_JOB :
                break;
            case PrivacyNodeTypePeer::PR_NTYP_POST_OPPORTUNITY :
                break;
        }

        $this->redirect($this->_referer);
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