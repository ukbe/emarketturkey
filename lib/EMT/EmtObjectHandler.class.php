<?php

class EmtObjectHandler
{
    protected $_classname;
    protected $_object_type_id;
    protected $_editor;
    protected $_viewer;
    protected $_msgRemovalConfirm;
    protected $_msgRemovalSuccess;
    protected $_msgSaveSuccess;
    protected $_msgActivateSuccess;
    protected $_msgDeActivateSuccess;
    
    CONST OHLR_RENDER_VIEW      = 'view';
    CONST OHLR_RENDER_EDIT      = 'edit';

    public function __construct($classname = '', $object_type_id = null)
    {
        if ($classname)
        {
            $config = sfConfig::get("app_objectHandler_$classname");
            if (is_array($config))
            {
                $this->_object_type_id = $object_type_id;

                if (isset($config['typed']) && $config['typed'])
                {
                    $config = $config['types'][$this->_object_type_id];
                }
                $this->_classname = $classname;
                $this->_editor = $config['editor'];
                $this->_viewer = $config['viewer'];
                $this->_msgRemovalConfirm = isset($config['msgRemovalConfirm']) ? $config['msgRemovalConfirm'] : '';
                $this->_msgRemovalSuccess = isset($config['msgRemovalSuccess']) ? $config['msgRemovalSuccess'] : '';
                $this->_msgSaveSuccess = isset($config['msgSaveSuccess']) ? $config['msgSaveSuccess'] : '';
                $this->_msgActivateSuccess = isset($config['msgActivateSuccess']) ? $config['msgActivateSuccess'] : '';
                $this->_msgDeActivateSuccess = isset($config['msgDeActivateSuccess']) ? $config['msgDeActivateSuccess'] : '';
            }
        }
    }

    public function validate($params, $owner = null, $request)
    {
        return call_user_func($this->_classname . 'Peer::validate', $params, $owner, $request);
    }
    
    public function saveInstance($obj, $params, $owner = null, $request)
    {
        return call_user_func($this->_classname . 'Peer::saveInstance', $obj, $params, $owner, $request);
    }
    
    public function getInstance($params, $owner = null, $new = false)
    {
        $params->set('_object_type_id', $this->_object_type_id);
        return call_user_func($this->_classname . 'Peer::getInstance', $params, $owner, $new);
    }
    
    public function render($obj, $render_type = self::OHLR_RENDER_VIEW, $params = null, $is_ajax = false)
    {
        sfLoader::loadHelpers('Partial');
        $params = is_array($params) ? $params : array();
        $params['object'] = $obj;
        $params['act'] = $render_type;
        return get_partial(($render_type=='edit' || $render_type == 'new' ? $this->_editor : $this->_viewer) . ($is_ajax ? '-ajax' : ''), $params);
    }
    
    public function getRemovalConfirmMessage()
    {
        return $this->_msgRemovalConfirm;
    }
    
    public function getRemovalSuccessMessage()
    {
        return $this->_msgRemovalSuccess;
    }
    
    public function getSaveSuccessMessage()
    {
        return $this->_msgSaveSuccess;
    }
    
    public function getActivateSuccessMessage()
    {
        return $this->_msgActivateSuccess;
    }
    
    public function getDeActivateSuccessMessage()
    {
        return $this->_msgDeActivateSuccess;
    }
    
    public function getClassName()
    {
        return $this->_classname;
    }
    
}
