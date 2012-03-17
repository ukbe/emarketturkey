<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class eventsAction extends EmtCompanyAction
{
    public function execute($request)
    {
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

        $c = new Criteria();
        $c->addJoin(EventPeer::TYPE_ID, EventTypePeer::ID, Criteria::LEFT_JOIN);
        $c->add(EventTypePeer::TYPE_CLASS, EventTypePeer::ECLS_TYP_BUSINESS);
        $c1 = $c->getNewCriterion(EventPeer::OWNER_ID, $this->company->getId());
        $c2 = $c->getNewCriterion(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c1->addAnd($c2);
        $c3 = $c->getNewCriterion(EventPeer::ORGANISER_ID, $this->company->getId());
        $c4 = $c->getNewCriterion(EventPeer::ORGANISER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c3->addAnd($c4);
        $c->addJoin(EventPeer::ID, EventInvitePeer::EVENT_ID, Criteria::LEFT_JOIN);
        $c5 = $c->getNewCriterion(EventInvitePeer::SUBJECT_ID, $this->company->getId());
        $c6 = $c->getNewCriterion(EventInvitePeer::SUBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c5->addAnd($c6);

        $c1->addOr($c3); $c1->addOr($c5);

        $c->add($c1);
        
        $c->addJoin(EventPeer::TIME_SCHEME_ID, TimeSchemePeer::ID, Criteria::LEFT_JOIN);
        $c->add(TimeSchemePeer::START_DATE, "TRUNC(EMT_TIME_SCHEME.START_DATE) >= TRUNC(SYSDATE)", Criteria::CUSTOM);
        
        $c->addAscendingOrderByColumn(TimeSchemePeer::START_DATE);

        $this->events = EventPeer::doSelect($c);

    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}