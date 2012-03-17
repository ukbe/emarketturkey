<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class emailTransactionAction extends EmtManageAction
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
                $this->transaction = EmailTransactionPeer::retrieveByPK($this->getRequestParameter('id'));
                if (!$this->transaction) $this->redirect404();
                $this->getUser()->setAttribute('emltr', $this->transaction->getId());
                if ($this->getRequestParameter('act')=='deliver')
                {
                    try
                    {
                        $this->transaction->deliver();
                    }
                    catch (Exception $e)
                    {
                        $err = $e->getMessage();
                    }
                    if ($this->transaction->getStatus()==EmailTransactionPeer::EML_TR_STAT_DELIVERED)
                    {
                        $this->getUser()->setFlash('message', 'Email Sent Successfully!', true);
                    }
                    else
                    {
                        $this->getUser()->setFlash('message', "Email COULD NOT be sent to recipient Successfully!<br /><br />Please try again later.<br />$err", true);
                    }
                }
            }
        }
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