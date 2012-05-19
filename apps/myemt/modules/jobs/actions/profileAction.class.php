<?php

class profileAction extends EmtManageJobAction
{
    protected $enforceJob = false;
    
    public function handleAction($isValidationError)
    {
        $this->profile = $this->owner->getHRProfile();

        if (!$this->profile) $this->profile = new HRProfile();
        
        if ($this->getRequestParameter('act') == 'edit') $this->setTemplate('profileEdit');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();

            try
            {
                $con->beginTransaction();
                
                $isnew = $this->profile->isNew();
                
                $this->profile->setDefaultTemplateId($this->getRequestParameter('template_id'));
                $this->profile->setOwnerId($this->owner->getId());
                $this->profile->setOwnerTypeId($this->otyp);
                $this->profile->setName($this->getRequestParameter('display_name'));
                $this->profile->save();
                
                $filename = $this->getRequest()->getFileName('hrlogo_file');
                if ($filename)
                {
                    $oldlogo = $this->profile->getHRLogo();
                    $this->logo = MediaItemPeer::createMediaItem($this->owner->getId(), $this->otyp, MediaItemPeer::MI_TYP_HR_LOGO, $_FILES['hrlogo_file'], false);
                    
                    $this->profile->setLogoId($this->logo->getId());
                    $this->profile->save();

                    ActionLogPeer::Log($this->owner, ActionPeer::ACT_UPLOAD_HR_LOGO, null, $this->logo);
                }

                if ($_FILES['hrlogo_spotbox_back']['name'])
                {
                    $oldimg = $this->profile->getSpotBoxBackground();
                    $newimg = MediaItemPeer::createMediaItem($this->owner->getId(), $this->otyp, MediaItemPeer::MI_TYP_JOB_SPOTBOX_BACK, $_FILES['hrlogo_spotbox_back'], false);
                    if (!$newimg->isNew() && $oldimg) $oldimg->delete();
                }
                
                if ($_FILES['hrlogo_platinum']['name'])
                {
                    $oldimg = $this->profile->getPlatinumImage();
                    $newimg = MediaItemPeer::createMediaItem($this->owner->getId(), $this->otyp, MediaItemPeer::MI_TYP_JOB_PLATINUM_IMAGE, $_FILES['hrlogo_platinum'], false);
                    if (!$newimg->isNew() && $oldimg) $oldimg->delete();
                }
                
                if ($_FILES['hrlogo_rectbox']['name'])
                {
                    $oldimg = $this->profile->getRectBoxImage();
                    $newimg = MediaItemPeer::createMediaItem($this->owner->getId(), $this->otyp, MediaItemPeer::MI_TYP_JOB_RECTBOX_IMAGE, $_FILES['hrlogo_rectbox'], false);
                    if (!$newimg->isNew() && $oldimg) $oldimg->delete();
                }
                
                if ($_FILES['hrlogo_cubebox']['name'])
                {
                    $oldimg = $this->profile->getCubeBoxImage();
                    $newimg = MediaItemPeer::createMediaItem($this->owner->getId(), $this->otyp, MediaItemPeer::MI_TYP_JOB_CUBEBOX_IMAGE, $_FILES['hrlogo_cubebox'], false);
                    if (!$newimg->isNew() && $oldimg) $oldimg->delete();
                }
                
                $con->commit();
                if ($oldlogo)
                {
                    $oldlogo->delete();
                }
                $i18n = $this->getContext()->getI18N();
                $this->redirect("{$this->route}&action=profile");
                
                if ($isnew)
                {
                    ActionLogPeer::Log($this->owner, ActionPeer::ACT_CREATE_HR_PROFILE);
                }
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $i18n = $this->getContext()->getI18N();
                $this->getUser()->setMessage($i18n->__('Error Occured!'), $i18n->__('Error occured while storing Human Resources Profile information. Please try again later.'), null, null, false);
                $this->setTemplate('profile');
            }

        }
        
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {   
            sfLoader::loadHelpers('I18N');
            if (trim($this->getRequestParameter("display_name"))=='')
                $this->getRequest()->setError("display_name", $this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? __('Please enter display name for your company.') : __('Please enter a display name for your group.'));
            if (mb_strlen($this->getRequestParameter("display_name")) > 255)
                $this->getRequest()->setError("display_name", __('Display name must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 255)));
        }
        return !$this->getRequest()->hasErrors();
    }
}