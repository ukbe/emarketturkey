<?php

class profileBCAction extends EmtAction
{

    public function execute($request)
    {
        if ($this->getRequestParameter('id') < 458)
        {
            $action = $this->getRequestParameter('paction');
            
            $hash = myTools::flipHash($this->getRequestParameter('id'), false, PrivacyNodeTypePeer::PR_NTYP_COMPANY);

            $arr = array('profile'      => "@camp.company-profile?hash=$hash",
                         'groups'       => "@camp.company-profile-action?hash=$hash&action=connections&relation=group",
                         'companies'    => "@camp.company-profile-action?hash=$hash&action=connections&relation=partner",
                         'network'      => "@camp.company-profile-action?hash=$hash&action=connections",
                         'people'       => "@camp.company-profile-action?hash=$hash&action=connections&relation=follower",
                         'photos'       => "@camp.company-profile-action?hash=$hash&action=photos",
                         'products'     => "@camp.company-profile-action?hash=$hash&action=products"
                    );
            
            $this->redirect($action ? $arr[$action] : "@camp.company-profile?hash=$hash", 301);
        }
        $this->redirect404();
    }

}