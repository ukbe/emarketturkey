<?php

class profileGroupBCAction extends EmtUserAction
{

    public function execute($request)
    {
        $this->redirect($this->user->getProfileActionUrl('connections')."&relation=groups", 301);
    }

}