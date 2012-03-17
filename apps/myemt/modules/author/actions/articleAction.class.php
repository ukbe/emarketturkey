<?php

class articleAction extends EmtAuthorObjectAction
{
    protected $_object_type_id = PublicationPeer::PUB_TYP_ARTICLE;
    protected $_classname = "Publication";
    protected $_collectionUrl = "@author-action?action=articles";
    protected $_filter_author = true;

    public function initialize($context, $moduleName, $actionName)
    {
        $this->_filter_author = $context->getUser()->hasCredential('editor') ? false : true;
         
        parent::initialize($context, $moduleName, $actionName);
    }
    
    public function execute($request)
    {
        $this->getRequest()->setParameter('_filter_author', true);
        
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;

        switch ($this->act)
        {
            case 'new' : 
                $this->getResponse()->setTitle('New Article | eMarketTurkey');
                break;
            case 'edit' :
                $this->getResponse()->setTitle('Edit Article | eMarketTurkey');
                break;
            case 'view' :
                $this->getResponse()->setTitle('Review Article | eMarketTurkey');
                break;
            case 'rmp' :
                $file = $this->object->getMediaItems($this->getRequestParameter('pid'));
                if (count($file))
                {
                    $file[0]->delete();
                }
                $this->redirect($this->object->getEditUrl('view'));
                break;
            case 'ftr' :
                $typ = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('typ')), array(PublicationPeer::PUB_FEATURED_BANNER, PublicationPeer::PUB_FEATURED_COLUMN, null), null);
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
