<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class mediaItemsAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('pee'))
        {
            $meds = MediaItemPeer::doSelect(new Criteria());
            
            foreach ($meds as $med)
            {
                if(!file_exists($med->getPath()) && file_exists($med->getPath(false)))
                {
                    try {
                        $med->store($med->getPath(false));
                        unlink($med->getPath(false));
                        unlink($med->getMediumPath(false));
                        unlink($med->getThumbnailPath(false));
                    }
                    catch (Exception $e){
                        echo $e->getMessage();
                        break;
                    }
                }
            }
        }

        $table = new EmtAjaxTable('mediaitems');
        $table->init();

        $this->table = $table;
        
        if ($this->getRequestParameter('act') == 'ret')
        {
            $this->setTemplate('retrieveMediaItems');
            $this->setLayout(false);
        }
        
        return sfView::SUCCESS;
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