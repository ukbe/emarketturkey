<?php

class profileBCAction extends EmtGroupAction
{

    public function execute($request)
    {
        $action = $this->getRequestParameter('paction');
        
        $arr = array('info'         => $this->group->getProfileUrl(),
                     'people'       => $this->group->getProfileActionUrl('connections')."&relation=people",
                     'companies'    => $this->group->getProfileActionUrl('connections')."&relation=companies",
                     'groups'       => $this->group->getProfileActionUrl('connections')."&relation=linked",
                );

        $this->redirect($action ? $arr[$action] : $this->group->getProfileUrl(), 301);
    }

}