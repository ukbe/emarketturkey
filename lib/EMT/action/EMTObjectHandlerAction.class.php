<?php

class EmtObjectHandlerAction extends EmtAction
{
    protected $_classname;
    protected $_collectionUrl;
    protected $_object_type_id;
    protected $_allowed_acts = array('view', 'edit', 'new', 'rem', 'pub', 'unpub');
    protected $_defaultAct = 'view';
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

    }
    
    public function initObjectInterface()
    {
        $this->act = myTools::pick_from_list($this->getRequestParameter('act'), $this->_allowed_acts, $this->_defaultAct);
        if ($this->_classname)
        {
            $this->objhandler = new EmtObjectHandler($this->_classname, $this->_object_type_id);
            $this->object = $this->objhandler->getInstance($this->getRequest()->getParameterHolder(), $this->objowner, $this->act == 'new');
        }
        else
        {
            $this->objhandler = null;
        }
    }
    
    protected function handleObjectActions($request)
    {
        if (!$this->objhandler) return;
        
        if ($this->getRequest()->isXmlHttpRequest())
        {
            header('Content-type: text/html');
            if (($this->act == 'edit' || $this->act == 'new') && $this->getRequest()->getMethod() == sfRequest::POST && $this->objhandler->validate($this->getRequest()->getParameterHolder(), $this->objowner, $this->getRequest()))
            {
                $this->obj = $this->objhandler->saveInstance($this->object, $this->getRequest()->getParameterHolder(), $this->objowner, $this->getRequest());
                return $this->renderPartial('global/ajaxSuccess', array('message' => $this->objhandler->getSaveSuccessMessage() . '<br />' . $this->getContext()->getI18n()->__('Please wait while refreshing!'), 'redir' => $this->_collectionUrl));
            }
            elseif ($this->act == 'rem')
            {
                if ($this->getRequestParameter('do') == 'commit')
                {
                    $this->object->delete();
                    return $this->renderPartial('global/ajaxSuccess', array(
                                    'message' => $this->objhandler->getRemovalSuccessMessage() . '<br />' . $this->getContext()->getI18n()->__('Please wait while refreshing!'),
                                    'redir' => $this->_collectionUrl
                            ));
                }
                else
                {
                    return $this->renderPartial('confirmItemRemoval', array('object' => $this->object, 'message' => $this->objhandler->getRemovalConfirmMessage(), 'postUrl' => $this->_collectionUrl));
                }
            }
            elseif ($this->act == 'pub')
            {
                $this->object->activate();
                return $this->renderPartial('global/ajaxSuccess', array(
                                'message' => $this->objhandler->getActivateSuccessMessage() . '<br />' . $this->getContext()->getI18n()->__('Please wait while refreshing!')
                            ));
            }
            elseif ($this->act == 'unpub')
            {
                $this->object->deActivate();
                return $this->renderPartial('global/ajaxSuccess', array(
                                'message' => $this->objhandler->getDeActivateSuccessMessage() . '<br />' . $this->getContext()->getI18n()->__('Please wait while refreshing!')
                            ));
            }
            else
            {
                return $this->renderText($this->objhandler->render($this->object, $this->act, $this->getRequest()->getParameterHolder(), true));
            }
        }
        else
        {
            switch ($this->act){
                case 'new': 
                case 'edit':
                    if ($this->object && $this->getRequest()->getMethod() == sfRequest::POST && (($this->act == 'new' && $this->object->isNew()) || ($this->act == 'edit' && !$this->object->isNew())) && $this->objhandler->validate($this->getRequest()->getParameterHolder(), $this->objowner, $this->getRequest()))
                    {
                        $this->object = $this->objhandler->saveInstance($this->object, $this->getRequest()->getParameterHolder(), $this->objowner, $this->getRequest());
                        if (is_object($this->object) && get_class($this->object) == $this->objhandler->getClassName() && !$this->object->isNew())
                        {
                            $this->getUser()->setFlash('message', $this->objhandler->getSaveSuccessMessage());
                            $this->redirect($this->object->getEditUrl('view'));
                        }
                    }
                    break;
                case 'rem':
                    if ($this->object && !$this->object->isNew())
                    {
                        if ($this->getRequestParameter('do') == 'commit')
                        {
                            $this->object->delete();
                            $this->getUser()->setFlash('message', $this->objhandler->getRemovalSuccessMessage());
                        }
                    }
                    break;
                case 'pub':
                    if ($this->object && !$this->object->isNew())
                    {
                        $this->object->activate();
                        $this->getUser()->setFlash('message', $this->objhandler->getActivateSuccessMessage());
                    }
                    break;
                case 'unpub':
                    if ($this->object && !$this->object->isNew())
                    {
                        $this->object->deActivate();
                        $this->getUser()->setFlash('message', $this->objhandler->getDeActivateSuccessMessage());
                    }
                    break;
            }
        }
        return 'keep';
    }
    
}
