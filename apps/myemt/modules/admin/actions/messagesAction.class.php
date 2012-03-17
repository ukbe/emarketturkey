<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class messagesAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        if (!$isValidationError)
        {
            if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
            {
                $this->message = CustomerMessagePeer::retrieveByPK($this->getRequestParameter('id'));
            }
        }
        
        $c = new Criteria();
        $c->addAscendingOrderByColumn(CustomerMessagePeer::CREATED_AT);
        $this->messages = CustomerMessagePeer::doSelect($c);
        
        $this->topic = CustomerMessagePeer::$topics;
        $this->topic[''] = 'No Topic';
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