<?php

class addAction extends EmtManageEventAction
{
    protected $enforceEvent = false;
    
    public function handleAction($isValidationError)
    {
        // Prepare variables from original Product
        
        if ($this->event instanceof Event)
        {
            // Handle relevant actions
            if ($this->getRequestParameter('act')=='rmp' && ($photo = $this->event->getPhotoById($this->getRequestParameter('pid'))))
            {
                $photo->delete();
                if ($this->refUrl) $this->redirect($this->refUrl);
            }
            
            $this->photos = $this->event->getPhotos();
            $this->i18ns = $this->event->getExistingI18ns();
            $this->place = $this->event->getPlace();
            $this->organiser = $this->event->getOrganiser();
            $this->time_scheme = $this->event->getTimeScheme() ? $this->event->getTimeScheme() : new TimeScheme();
            
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Event: %1', array('%1' => $this->event->getName())));
        }
        else
        {
            $this->event = new Event();
            $this->photos = array();
            $this->i18ns = array();
            $this->place = null;
            $this->organiser = null;
            $this->time_scheme = new TimeScheme();
        }
        
        
        // Manipulate variables from form post

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->hasRequestParameter('event_place_id') && is_numeric($this->getRequestParameter('event_place_id')))
            {
                $this->place = PlacePeer::retrieveByPK($this->getRequestParameter('event_place_id'));
            }

            if (is_numeric($this->getRequestParameter('event_organiser_id')) && $this->getRequestParameter('event_organiser_id') > 0 &&
                is_numeric($this->getRequestParameter('event_organiser_type_id')) && $this->getRequestParameter('event_organiser_type_id') > 0)
            {
                $this->organiser = PrivacyNodeTypePeer::retrieveObject($this->getRequestParameter('event_organiser_id'), $this->getRequestParameter('event_organiser_type_id'));
            }

            if (!$isValidationError)
            {
                $con = Propel::getConnection(EventPeer::DATABASE_NAME);
                
                try
                {
                    $con->beginTransaction();

                    if (($exevent = EventPeer::retrieveByPK($this->getRequestParameter('event_selected'))) && ($this->event->isNew() || $this->event->getId() == $exevent->getId()))
                    {
                        $invite = $exevent->getInviteFor($this->owner->getId(), $this->otyp);
                        if (!$invite) 
                        {
                            $invite = new EventInvite();
                            if ($this->getRequestParameter('event_attending') == 1) 
                                ActionLogPeer::Log($this->owner, ActionPeer::ACT_EXPRESS_EVENT_ATTENDANCE, null, $exevent);
                        }

                        $invite->setEventId($exevent->getId());
                        $invite->setSubjectId($this->owner->getId());
                        $invite->setSubjectTypeId($this->otyp);
                        $invite->setRsvpStatus($this->getRequestParameter('event_attending'));
                        $invite->save();
                    }
                    else
                    {
                        $this->event->setOwnerId($this->owner->getId());
                        $this->event->setOwnerTypeId($this->otyp);
    
                        $this->event->setTypeId($this->getRequestParameter('event_type_id'));
    
    					$this->event->setOrganiserId($this->organiser ? $this->organiser->getId() : null);
    					$this->event->setOrganiserTypeId($this->organiser ? $this->getRequestParameter('event_organiser_type_id') : null);
    					$this->event->setOrganiserName($this->organiser ?  $this->organiser->getName() : $this->getRequestParameter('event_organiser_name'));
    
    					$this->event->setPlaceId($this->place ? $this->place->getId() : null);
    					$this->event->setLocationName($this->place ? $this->place->getName() : $this->getRequestParameter('event_location_name'));
    					$this->event->setLocationCountry($this->place ? $this->place->getCountry() : $this->getRequestParameter('event_location_country'));
    					$this->event->setLocationState($this->place ? $this->place->getState() : $this->getRequestParameter('event_location_state'));
    
                        // Set time scheme
                        $sdate = strtotime($this->getRequestParameter('event_start'));
                        $this->time_scheme->setStartDate(date('U', mktime($this->getRequestParameter('event_start_time_hour'), $this->getRequestParameter('event_start_time_min'), 0, date('m', $sdate), date('d', $sdate), date('Y', $sdate))));
                        $edate = strtotime($this->getRequestParameter('event_end'));
                        $this->time_scheme->setEndDate(date('U', mktime($this->getRequestParameter('event_end_time_hour'), $this->getRequestParameter('event_end_time_min'), 0, date('m', $edate), date('d', $edate), date('Y', $edate))));
                        $this->time_scheme->setRepeatTypeId($this->getRequestParameter('event_repeat') == 1 ? $this->getRequestParameter('event_repeat_type_id') : null);
                        $this->time_scheme->save();
    
    					$this->event->setTimeSchemeId($this->time_scheme->getId());
    
    					$isnew = $this->event->isNew();
                        
                        $pr = $this->getRequestParameter('event_lang');
                        $this->event->setDefaultLang($pr[0]);
    
                        $this->event->save();
    
                        if (is_array($pr))
                        {
                            foreach($pr as $key => $lang)
                            {
                                $pi18n = $this->event->getCurrentEventI18n($lang);
                                $pi18n->setName($this->getRequestParameter("event_name_$key"));
                                $pi18n->setIntroduction($this->getRequestParameter("event_introduction_$key"));
                                $pi18n->save();
                            }
                        }
                        if (!$this->event->isNew() && count($diff = array_diff($this->i18ns, $pr))) $this->event->removeI18n($diff);
                        $this->event->save();
                        
                        ActionLogPeer::Log($this->owner, ActionPeer::ACT_CREATE_EVENT, null, $this->event);
                        
                        $filename = $this->getRequest()->getFileName('event_photo');
    
                        if ($filename){
                            $file = MediaItemPeer::createMediaItem($this->event->getId(), PrivacyNodeTypePeer::PR_NTYP_EVENT, $this->event->getLogo() ? MediaItemPeer::MI_TYP_ALBUM_PHOTO : MediaItemPeer::MI_TYP_LOGO, $_FILES['event_photo'], false);
                        }
                    }

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
        
        sfLoader::loadHelpers('I18N');
        
        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $this->getRequest()->setError("event_lang_$key", __('Please select a language which you will provide event information in.'));
            if (!$this->getRequestParameter('event_selected') && trim($this->getRequestParameter("event_name_$key")) == '')
                $this->getRequest()->setError("event_name_$key", $lang ? __('Please enter the event name for %1 language.', array('%1' => format_language($lang))) : __('Please enter the event name.'));
            if (mb_strlen($this->getRequestParameter("event_name_$key")) > 255)
                $this->getRequest()->setError("event_name_$key", $lang ? __('Event name for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 255)) : __('Event name must be maximum %1 characters long.', array('%1' => 255)));
            if (mb_strlen($this->getRequestParameter("event_introduction_$key")) > 1800)
                $this->getRequest()->setError("event_introduction_$key", $lang ? __('Event description for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 1800)) : __('Event description must be maximum %1 characters long.', array('%1' => 1800)));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}