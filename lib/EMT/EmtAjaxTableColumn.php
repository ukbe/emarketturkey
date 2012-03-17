<?php

class EmtAjaxTableColumn
{
    protected $name;
    protected $displayName;
    protected $isSortable;
    protected $isActionColumn;
    protected $isSortColumn;
    protected $headerCssClass;
    protected $cssClass;
    protected $partial;
    protected $fieldName;
    protected $applyFilter;
    protected $joinWith;
    protected $tableObject;
    
    public function __construct($name, $config)
    {
        $this->setName($name);
        $this->setDisplayName(self::_getval($config, "displayName"));
        $this->setIsSortable(self::_getval($config, "isSortable"));
        $this->setIsActionColumn(self::_getval($config, "isActionColumn"));
        $this->isSortColumn = self::_getval($config, "isSortColumn");
        $this->setHeaderCssClass(self::_getval($config, "headerCssClass"));
        $this->setCssClass(self::_getval($config, "cssClass"));
        $this->setPartial(self::_getval($config, "partial"));
        $this->setFieldName(self::_getval($config, "fieldName"));
        $this->setApplyFilter(self::_getval($config, "applyFilter"));
        $this->setJoinWith(self::_getval($config, "joinWith"));
        
        return true;
    }
    
    protected function _getval($array, $key)
    {
        return array_key_exists($key, $array)?$array[$key]:null;
    }
    
    
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getDisplayName()
    {
        return $this->displayName;
    }
    
    public function getIsSortable()
    {
        return $this->isSortable;
    }
    
    public function getIsActionColumn()
    {
        return $this->isActionColumn;
    }
    
    public function getIsSortColumn()
    {
        return $this->isSortColumn;
    }
    
    public function getHeaderCssClass()
    {
        return $this->headerCssClass;
    }
    
    public function getCssClass()
    {
        return $this->cssClass;
    }
    
    public function getPartial()
    {
        return $this->partial;
    }
    
    public function getFieldName()
    {
        return $this->fieldName;
    }
    
    public function getApplyFilter()
    {
        return $this->applyFilter;
    }
    
    public function getJoinWith()
    {
        return $this->joinWith;
    }
    
    public function getTableObject()
    {
        return $this->tableObject;
    }
    
    public function setName($val)
    {
        $this->name = $val;
    }
    
    public function setDisplayName($val)
    {
        $this->displayName = $val;
    }
    
    public function setIsSortable($val)
    {
        if ($val!==null)
            $val = (bool)$val;
        else
            $val = null;
        $this->isSortable = $val;
    }
    
    public function setIsActionColumn($val)
    {
        if ($val!==null)
            $val = (bool)$val;
        else
            $val = null;
        $this->isActionColumn = $val;
    }
    
    public function setIsSortColumn($val=null)
    {
        if (($val===true || $val===null) && ($this->tableObject instanceof EmtAjaxTable))
        {
            if ($this->getTableObject()->setOrderColumn($this))
                $this->isSortColumn = true;
        }
        else
        {
            $this->isSortColumn = false;
        }
    }
    
    public function setHeaderCssClass($val)
    {
        $this->headerCssClass = $val;
    }
    
    public function setCssClass($val)
    {
        $this->cssClass = $val;
    }

    public function setPartial($val)
    {
        $this->partial = $val;
    }
    
    public function setFieldName($val)
    {
        $this->fieldName = $val;
    }
    
    public function setApplyFilter($val)
    {
        if ($val!==null)
            $val = (bool)$val;
        else
            $val = null;
        $this->applyFilter = $val;
    }
    
    public function setJoinWith($val)
    {
        $this->joinWith = $val;
    }
    
    public function setTableObject($val)
    {
        if ($val instanceof EmtAjaxTable)
        {
            $this->tableObject = $val;
        }
    }
    
    public function getRelatedTables()
    {
        preg_match("/\w+\.\w+/", $this->getFieldName(), $matches);
        $matches = preg_filter("/\.\w+$/", '', $matches);
        return array_unique($matches);
    }
    
}
?>