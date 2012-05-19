<?php

class sourceAction extends EmtAuthorObjectAction
{
    protected $_classname = "PublicationSource";
    protected $_collectionUrl = "@author-action?action=sources";

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
    }
    
    public function execute($request)
    {
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;

        switch ($this->act)
        {
            case 'new' : 
                $this->getResponse()->setTitle('New Publication Source | eMarketTurkey');
                if ($this->object && !$this->object->isNew()) $this->redirect($this->object->getEditUrl('view'));
                break;
            case 'edit' :
                $this->getResponse()->setTitle('Edit Publication Source | eMarketTurkey');
                break;
            case 'view' :
                $this->getResponse()->setTitle('Review Publication Source | eMarketTurkey');
                break;
            case 'rmp' :
                $file = $this->object->getPhotos($this->getRequestParameter('pid'));
                if (count($file))
                {
                    $file[0]->delete();
                }
                $this->redirect($this->object->getEditUrl('view'));
                break;
            case 'ftr' :
                $typ = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('typ')), array(PublicationSourcePeer::PSRC_FEATURED, null), null);
                $this->object->setFeaturedType($typ);
                $this->object->save();
                $this->redirect($this->object->getEditUrl('view'));
                break;
        }
        
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {   
        return !$this->getRequest()->hasErrors();
    }
}
