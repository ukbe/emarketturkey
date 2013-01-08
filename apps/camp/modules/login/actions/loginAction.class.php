<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class loginAction extends EmtAction
{
    public function execute($request)
    {
        $this->redirect("@myemt.login?_ref={$this->_here}");
    }
}