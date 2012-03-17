<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class emailTransactionsAction extends EmtManageAction
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
                $tr = EmailTransactionPeer::retrieveByPK($this->getRequestParameter('id'));
                if ($tr)
                {
                    try
                    {
                        $tr->deliver();
                    }
                    catch (Exception $e)
                    {
                        $err = $e->getMessage();
                    }
                    if ($tr->getStatus()==EmailTransactionPeer::EML_TR_STAT_DELIVERED)
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
        
        $table = new EmtAjaxTable('emailtransactions');
        $table->init();

        $this->table = $table;
        
        if ($this->getRequestParameter('act') == 'ret')
        {
            $this->setTemplate('retrieveEmailTransactions');
            $this->setLayout(false);
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