<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class emailTransactionContentAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        if (!$isValidationError)
        {
            if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')) && $this->getUser()->getAttribute('emltr') == $this->getRequestParameter('id'))
            {
                $this->transaction = EmailTransactionPeer::retrieveByPK($this->getRequestParameter('id'));
                if (!$this->transaction) $this->redirect404();

                if ($this->getRequestParameter('act') == 'template')
                {
                    sfLoader::loadHelpers('Partial');
                    $cult = $this->getUser()->getCulture();
                    $this->getUser()->setCulture($this->transaction->getPreferredLang());
                    try
                    {
                        echo get_partial($this->transaction->getEmailTransactionNamespace()->getTemplate(), unserialize($this->transaction->getData()));
                    }
                    catch (Exception $e)
                    {
                        echo $e->getMessage();
                    }
                    $this->getUser()->setCulture($cult);
                }
            }
            else
            {
                $this->redirect404();
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