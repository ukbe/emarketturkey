<?php

class profileBCAction extends EmtAction
{

    public function execute($request)
    {
        if ($this->getRequestParameter('id') < 458)
        {
            $action = $this->getRequestParameter('paction');
            
            $hash = myTools::flipHash($this->getRequestParameter('id'), false, PrivacyNodeTypePeer::PR_NTYP_COMPANY);

            $arr = array('profile'      => "@company-profile?hash=$hash",
                         'event'        => "@company-profile-action?hash=$hash&action=connections&relation=friend",
                         'partners'     => "@company-profile-action?hash=$hash&action=connections&relation=friend",
                         'network'      => "@company-profile-action?hash=$hash&action=connections&relation=friend",
                         'people'       => "@company-profile-action?hash=$hash&action=connections&relation=friend",
                         'photos'       => "@company-profile-action?hash=$hash&action=connections&relation=friend",
                         'products'     => "@company-profile-action?hash=$hash&action=connections&relation=friend"
                    );

            $this->redirect($action ? $arr[$action] : "@user-profile?hash=$hash", 301);
        }
    }

}