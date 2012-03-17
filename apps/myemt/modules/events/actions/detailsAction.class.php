<?php

class detailsAction extends EmtManageEventAction
{
    protected $enforceEvent = true;
    
    public function handleAction($isValidationError)
    {
        // Prepare variables from original Product
        
        // Handle relevant actions
        if ($this->getRequestParameter('act')=='rmp' && $photo = $this->event->getPhotoByGuid($this->getRequestParameter('phid')))
        {
            $photo->delete();
        }
        
        $this->photos = $this->event->getPhotos();
        $this->user_photos = array();
        $this->i18ns = $this->event->getExistingI18ns();
        $this->place = $this->event->getPlace();
        $this->organiser = $this->event->getOrganiser();
        $this->time_scheme = $this->event->getTimeScheme() ? $this->event->getTimeScheme() : new TimeScheme();
        $this->attenders = $this->event->getAttenders(null, false, EventPeer::EVN_ATTYP_ATTENDING);

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Event Details: %1', array('%1' => $this->event->getName())));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $con = Propel::getConnection(EventPeer::DATABASE_NAME);
                
                try
                {
                    $con->beginTransaction();


                    $con->commit();
                    $this->redirect($this->route . "&action=manage");
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->owner->getId(), $this->own, $e->getMessage(). ';' . $e->getFile() . ';' . $e->getLine());
                }
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        $pr = $this->getRequestParameter('event_lang');
        $pr = is_array($pr)?$pr:array();
        
        foreach ($pr as $key => $lang)
        {
            if (mb_strlen($this->getRequestParameter("event_name_$key")) > 255)
                $this->getRequest()->setError("event_name_$key", sfContext::getInstance()->getI18N()->__('Event name for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 255)));
            if (mb_strlen($this->getRequestParameter("event_introduction_$key")) > 1800)
                $this->getRequest()->setError("event_introduction_$key", sfContext::getInstance()->getI18N()->__('Event description for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 1800)));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}