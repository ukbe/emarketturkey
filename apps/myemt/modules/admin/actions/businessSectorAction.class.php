<?php

class businessSectorAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->sector = BusinessSectorPeer::retrieveByPK($this->getRequestParameter('id'));
            if (!$this->sector || md5($this->sector->getName().$this->sector->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Sector: %1', array('%1' => $this->sector->getName())));
        }
        else
        {
            $this->sector = new BusinessSector();
            
            if ($this->getRequestParameter('act') == 'rem' ||
                $this->getRequestParameter('act') == 'tog')
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Business Sector'));
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->sector->delete();
            $this->redirect('admin/businessSectors');
        }
        elseif ($this->getRequestParameter('act') == 'tog')
        {
            $this->sector->setActive(!$this->sector->getActive());
            $this->sector->save();
            $this->setTemplate('toggleBusinessSector');
            return sfView::SUCCESS;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(BusinessSectorPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                if ($this->sector->isNew())
                {
                    $this->sector->setActive(0);
                    $this->sector->save();
                }
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $pi18n = $this->sector->getCurrentBusinessSectorI18n($lang);
                    $pi18n->setName($this->getRequestParameter('name_'.$lang));
                    $pi18n->save();
                }

                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Sector information has been saved successfully.', null, null, true);
                
                $this->redirect('admin/businessSectors');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new sector information. Please try again later.', null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
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