<?php

class profileBCAction extends EmtAction
{

    public function execute($request)
    {
        if ($this->getRequestParameter('id') < 4739)
        {
            $action = $this->getRequestParameter('paction');
            
            $hash = myTools::flipHash($this->getRequestParameter('id'), false, PrivacyNodeTypePeer::PR_NTYP_USER);

            $arr = array('info'         => "@user-profile?hash=$hash",
                         'friends'      => "@user-profile-action?hash=$hash&action=connections&relation=friend",
                         'companies'    => "@user-profile-action?hash=$hash&action=connections&relation=following",
                         'groups'       => "@user-profile-action?hash=$hash&action=connections&relation=group",
                         'photos'       => "@user-profile-action?hash=$hash&action=photos",
                         'career'       => "@user-profile-action?hash=$hash&action=career");

            $this->redirect($action ? $arr[$action] : "@user-profile?hash=$hash", 301);
        }
    }

}