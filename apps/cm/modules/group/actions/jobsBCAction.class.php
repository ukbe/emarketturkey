<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class jobsBCAction extends EmtGroupAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect($this->group->getProfileActionUrl('jobs'), 301);
    }
    
}