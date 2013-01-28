<?php

class hashedBCAction extends EmtUserAction
{

    public function execute($request)
    {
        $action = $this->getRequestParameter('paction');

        $arr = array('groups'       => $this->user->getProfileActionUrl('connections')."&relation=groups",
               );

        $this->redirect($action ? $arr[$action] : $this->user->getProfileUrl(), 301);
    }

}