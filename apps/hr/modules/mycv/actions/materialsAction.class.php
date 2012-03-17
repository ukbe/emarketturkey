<?php

class materialsAction extends EmtCVAction
{
    public function __construct($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->portfolio = $this->resume->getPortfolio();
    }

    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->isXmlHttpRequest()) header('Content-type: text/html');
        
        $act = myTools::pick_from_list($this->getRequestParameter('act'), array('rmhcv', 'rmpht', 'rmpit'), null);

        switch ($act)
        {
            case "rmpht" :
                if ($this->resume->getPhoto())
                {
                    if ($this->getRequestParameter('do')=='commit')
                    {
                        $this->resume->getPhoto()->delete();

                        if ($this->getRequest()->isXmlHttpRequest())
                            return $this->renderPartial('global/ajaxSuccess', array(
                                            'message' => $this->getContext()->getI18n()->__('Your photo has been deleted!'),
                                            'redir' => "@mycv-action?action=materials"
                                        ));
                        else
                            $this->redirect("@mycv-action?action=materials");
                    }
                    else
                    {
                        if ($this->getRequest()->isXmlHttpRequest())
                            return $this->renderPartial('confirmItemRemoval', array('message' => 'Are you sure to delete your resume photo?', 'postUrl' => '@mycv-action?action=materials', 'act' => 'rmpht', 'object' => $this->resume->getPhoto(), 'sf_params' => $this->getRequest()->getParameterHolder(), 'sf_request' => $this->getRequest()));
                    }
                }
                break;
            case "rmhcv" :
                if ($this->resume->getHardcopyCV())
                {
                    if ($this->getRequestParameter('do')=='commit')
                    {
                        $this->resume->getHardcopyCV()->delete();

                        if ($this->getRequest()->isXmlHttpRequest())
                            return $this->renderPartial('global/ajaxSuccess', array(
                                            'message' => $this->getContext()->getI18n()->__('Your Hardcopy CV has been deleted!'),
                                            'redir' => "@mycv-action?action=materials"
                                        ));
                        else
                            $this->redirect("@mycv-action?action=materials");
                    }
                    else
                    {
                        if ($this->getRequest()->isXmlHttpRequest())
                            return $this->renderPartial('confirmItemRemoval', array('message' => 'Are you sure to delete your Hardcopy CV?', 'postUrl' => '@mycv-action?action=materials', 'act' => 'rmhcv', 'object' => $this->resume->getHardcopyCV(), 'sf_params' => $this->getRequest()->getParameterHolder(), 'sf_request' => $this->getRequest()));
                    }
                }
                break;
            case "rmpit" :
                $it = (($itid = myTools::fixInt($this->getRequestParameter('id'))) ? $this->resume->getPortfolio($itid) : null);

                if ($it)
                {
                    if ($this->getRequestParameter('do')=='commit')
                    {
                        $it->delete();

                        if ($this->getRequest()->isXmlHttpRequest())
                            return $this->renderPartial('global/ajaxSuccess', array(
                                            'message' => $this->getContext()->getI18n()->__('Your portfolio item has been deleted!'),
                                            'redir' => "@mycv-action?action=materials"
                                        ));
                        else
                            $this->redirect("@mycv-action?action=materials");
                    }
                    else
                    {
                        if ($this->getRequest()->isXmlHttpRequest())
                            return $this->renderPartial('confirmItemRemoval', array('message' => 'Are you sure to delete your portfolio item?', 'postUrl' => '@mycv-action?action=materials', 'act' => 'rmpit', 'object' => $it, 'sf_params' => $this->getRequest()->getParameterHolder(), 'sf_request' => $this->getRequest()));
                    }
                }
                break;
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $con = Propel::getConnection(ContactPeer::DATABASE_NAME);
                
                try
                {
                    $con->beginTransaction();

                    if ($this->getRequest()->getFileName('resume-photo'))
                    {
                        $old = $this->resume->getPhoto();
                        $this->resume_photo = MediaItemPeer::createMediaItem($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, MediaItemPeer::MI_TYP_RESUME_PHOTO, $_FILES['resume-photo'], false);
                        if ($old) $old->delete();
                    }
                    elseif ($this->getRequest()->getFileName('resume-hccv'))
                    {
                        $old = $this->resume->getHardcopyCV();
                        $this->resume_hccv = MediaItemPeer::createMediaItem($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, MediaItemPeer::MI_TYP_HARDCOPY_CV, $_FILES['resume-hccv'], false);
                        if ($old) $old->delete();
                    }
                    elseif ($this->getRequest()->getFileName('resume-portfolio'))
                        $this->resume_portfolio = MediaItemPeer::createMediaItem($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, MediaItemPeer::MI_TYP_RESUME_PORTFOLIO_ITEM, $_FILES['resume-portfolio'], false);
                    
                    $con->commit();
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    $this->redirect404();
                }
                
                if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
                {
                    $this->redirect('@mycv-action?action=materials');
                }
                elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
                {
                    $this->redirect('@mycv-action?action=review');
                }
            }
            else
            {
                // error, so display form again
                return sfView::SUCCESS;
            }
        }
    }
    
    public function execute($request)
    {
        return $this->handleAction(false);
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
            if (!isset($files['resume-portfolio']) && count($this->portfolio) > 4) $this->getRequest()->setError('resume-portfolio', 'You have already uploaded 5 items.');
        }
        return !$this->getRequest()->hasErrors();
    }
    
}
