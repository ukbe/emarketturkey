<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class uploadAction extends EmtCompanyAction
{
    public function execute($request)
    {
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->own_company)
        {
            $this->albums = $this->company->getAlbums();
            $this->album_id = myTools::fixInt($this->getRequestParameter('album'));
            $this->album = $this->album_id ? $this->company->getPhotoAlbumById($this->album_id) : null;
            
            if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
            {
                $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
                try
                {
                    $con->beginTransaction();
    
                    $this->photo = MediaItemPeer::createMediaItem($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, MediaItemPeer::MI_TYP_ALBUM_PHOTO, $_FILES['photo'], false);
    
                    $con->commit();
                    
                    if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 1, 'message' => '', 'uri' => $this->photo->getOriginalFileUri())));
                    $this->redirect(myTools::injectParameter($this->company->getProfileActionUrl('photos'), "pid={$this->photo->getId()}"));
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->company, PrivacyNodeTypePeer::PR_NTYP_COMPANY, "Error Occured During album photo upload", $e);
                    if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 0, 'message' => $this->getContext()->getI18N()->__('Error Occured'), 'uri' => $this->photo->getOriginalFileUri())));
                    else $this->getRequest()->setError('custom', 'An error occured while uploading new photo. Please try again later');
                }
            }
            return sfView::SUCCESS;
        }
        else
        {
            $this->redirect($this->company->getProfileActionUrl('photos'));
        }

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('%1 Photos', array('%1' => $this->company->getName())) . ' | eMarketTurkey');

        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

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