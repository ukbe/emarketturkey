<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.friendfinder", 301);

    }

}