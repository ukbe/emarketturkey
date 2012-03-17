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
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if (!$isValidationError)
        {
            $chunks = explode(' ', rtrim(ltrim($this->getRequestParameter('fkeyword'))));
            $c = new Criteria();
            $m = new Criteria();
            foreach ($chunks as $chunk)
            {
                $c1 = $c->getNewCriterion(UserPeer::NAME, "LOWER(NAME) LIKE LOWER('%$chunk%')", Criteria::CUSTOM);
                $c2 = $c->getNewCriterion(UserPeer::LASTNAME, "LOWER(LASTNAME) LIKE LOWER('%$chunk%')", Criteria::CUSTOM);
                $c1->addOr($c2);
                $c->addOr($c1);
                $c1 = $c2 = null;
                $m1 = $m->getNewCriterion(CompanyPeer::NAME, "LOWER(NAME) LIKE LOWER('%$chunk%')", Criteria::CUSTOM);
                $m->addOr($m1);
                $m1 = null;
            }

            $c->add(UserPeer::ID, $this->user->getId(), Criteria::NOT_EQUAL);
            $this->user_results = UserPeer::doSelect($c);
            $this->company_results = CompanyPeer::doSelect($m);
            
            $this->setTemplate("results");
            $this->getUser()->setSearchFlash(rtrim(ltrim($this->getRequestParameter('fkeyword'))));
        }
    }

    public function validate()
    {
        if ($this->getRequestParameter("fkeyword", "") == "")
            return false;
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}