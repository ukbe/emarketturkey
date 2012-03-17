<?php

class authorAction extends EmtAuthorObjectAction
{
    protected $_owner_is_sesuser = true;
    protected $_classname = "Author";
    protected $_collectionUrl = "@author-action?action=authors";

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
                $this->getResponse()->setTitle('New Author | eMarketTurkey');
                break;
            case 'edit' :
                $this->getResponse()->setTitle('Edit Author | eMarketTurkey');
                break;
            case 'view' :
                $this->getResponse()->setTitle('Review Author | eMarketTurkey');
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
                $typ = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('typ')), array(AuthorPeer::AUTH_FEATURED_COLUMN, null), null);
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
