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
                         'groups'       => "@company-profile-action?hash=$hash&action=connections&relation=group",
                         'companies'    => "@company-profile-action?hash=$hash&action=connections&relation=partner",
                         'network'      => "@company-profile-action?hash=$hash&action=connections",
                         'people'       => "@company-profile-action?hash=$hash&action=connections&relation=follower",
                         'photos'       => "@company-profile-action?hash=$hash&action=photos",
                         'products'     => "@company-profile-action?hash=$hash&action=products"
                    );
            
            $this->redirect($action ? $arr[$action] : "@company-profile?hash=$hash", 301);
        }
        $this->redirect404();
    }

}