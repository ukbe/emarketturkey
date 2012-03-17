<?php

class EmtAjaxTable
{
    protected $name;
    protected $modelClass;
    protected $orderColumn;
    protected $sortOrder = 'ASC';
    protected $sql;
    protected $url;  // url for refreshing table content
    protected $firstIndice;
    protected $itemsPerPage;
    protected $keyword = '';
    protected $cssClass;
    protected $selectable;
    protected $columns = array();
    protected $pager;
    protected $customCriterias = array();
    protected $rowPartial;
    protected $editAction;
    protected $deleteAction;
    protected $activateAction;
    protected $itemUrl;
    protected $staticparams = array();
    protected $rowCountLabel = '%1 items total';
    protected $showItemsPerPage = true;
    protected $showHeader = true;
    
    public function __construct($configuration)
    {
        if (is_array($configuration))
        {
            $config =  $configuration;
        }
        else
        {
            $tables = sfConfig::get('app_main_emt_tables');
            $config = $tables[$configuration];
        }
        
        if (!class_exists(self::_getval($config, "modelClass")))
            return null;

        $req = sfContext::getInstance()->getRequest();
        $this->setName($configuration);
        $this->setModelClass(self::_getval($config, "modelClass"));
        $this->setSortOrder($req->hasParameter('dir') ? $req->getParameter('dir') : self::_getval($config, "sortOrder"));
        $this->setSql(self::_getval($config, "sql"));
        $this->setUrl(self::_getval($config, "url"));
        $this->setFirstIndice($req->hasParameter('start') ? $req->getParameter('start') : self::_getval($config, "firstIndice"));
        $this->setItemsPerPage($req->hasParameter('max') ? $req->getParameter('max') : self::_getval($config, "itemsPerPage"));
        $this->setCssClass(self::_getval($config, "cssClass"));
        $this->setSelectable(self::_getval($config, "selectable"));
        $this->setRowPartial(self::_getval($config, "rowPartial"));
        $this->setEditAction(self::_getval($config, "editAction"));
        $this->setDeleteAction(self::_getval($config, "deleteAction"));
        $this->setActivateAction(self::_getval($config, "activateAction"));
        $this->setStaticParams(self::_getval($config, "staticParams"));
        $this->setRowCountLabel(self::_getval($config, "rowCountLabel"));
        $this->setShowItemsPerPage(self::_getval($config, "showItemsPerPage"));
        $this->setShowHeader(self::_getval($config, "showHeader"));
        $this->setItemUrl(self::_getval($config, "itemUrl"));
        $this->pager = new sfPropelPager($this->modelClass, $this->itemsPerPage);
        $this->setKeyword($req->hasParameter('keyword') ? $req->getParameter('keyword') : '');
        
        $columns = self::_getval($config, "columns");
        
        foreach ($columns as $colname => $column)
        {
            if ($col = new EmtAjaxTableColumn($colname, $column))
                $this->addColumn($col);
            else return false;
        }
        $this->setOrderColumn($req->hasParameter('sort') ? $req->getParameter('sort') : self::_getval($config, "orderColumn"));
    }
    
    protected function _getval($array, $key)
    {
        return array_key_exists($key, $array)?$array[$key]:null;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getModelClass()
    {
        return $this->modelClass;
    }
    
    public function getOrderColumn()
    {
        return $this->orderColumn;
    }
    
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    
    public function getSql()
    {
        return $this->sql;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function getFirstIndice()
    {
        return $this->firstIndice;
    }
    
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    
    public function getKeyword()
    {
        return $this->keyword;
    }
    
    public function getCssClass()
    {
        return $this->cssClass;
    }
    
    public function getSelectable()
    {
        return $this->selectable;
    }
    
    public function getColumns()
    {
        return $this->columns;
    }
    
    public function getPager()
    {
        return $this->pager;
    }
    
    public function getRowPartial()
    {
        return $this->rowPartial;
    }
    
    public function getEditAction()
    {
        return $this->editAction;
    }
    
    public function getDeleteAction()
    {
        return $this->deleteAction;
    }
    
    public function getActivateAction()
    {
        return $this->activateAction;
    }
    
    public function getStaticParams()
    {
        return $this->staticParams;
    }
    
    public function getRowCountLabel()
    {
        return $this->rowCountLabel;
    }
    
    public function getShowItemsPerPage()
    {
        return $this->showItemsPerPage;
    }
    
    public function getShowHeader()
    {
        return $this->showHeader;
    }
    
    public function getItemUrl()
    {
        return $this->itemUrl;
    }
    
    public function setModelClass($val)
    {
        $this->modelClass = $val;
    }
    
    public function setName($val)
    {
        $this->name = $val;
    }
    
    public function setOrderColumn($val)
    {
        if ($val instanceof EmtAjaxTableColumn)
        {
            $key = $val->getName();
        }
        else
        {
            $key = $val;
        }
        if ($this->columnExists($key) &&  $this->orderColumn!==$key)
        {
            $this->orderColumn = $key;
            $this->getColumnByName($this->orderColumn)->setIsSortColumn(false);
        }
    }
    
    public function setSortOrder($val)
    {
        if (in_array(strtoupper($val), array('ASC', 'DESC')))
        {
            $this->sortOrder = strtoupper($val);
        }
        else
        {
            return false;
        }
    }
    
    public function setSql($val)
    {
        $this->sql = $val;
    }
    
    public function setUrl($val)
    {
        $this->url = $val;
    }
    
    public function setFirstIndice($val)
    {
        $this->firstIndice = $val;
    }
    
    public function setItemsPerPage($val)
    {
        $this->itemsPerPage = $val;
    }
    
    public function setKeyword($val)
    {
        $this->keyword = $val;
    }
    
    public function setCssClass($val)
    {
        $this->cssClass = $val;
    }
    
    public function setSelectable($val)
    {
        if (array_search(strtoupper($val), array('0', '1', 'N'))!==false)
        {
            $this->selectable = strtoupper($val);
        }
        else
        {
            return false;
        }
    }
    
    public function setRowPartial($val)
    {
        $this->rowPartial = $val;
    }
    
    public function setEditAction($val)
    {
        if ($val!==null)
            $val = (bool)$val;
        else
            $val = null;
        $this->editAction = $val;
    }
    
    public function setDeleteAction($val)
    {
        if ($val!==null)
            $val = (bool)$val;
        else
            $val = null;
        $this->deleteAction = $val;
    }
    
    public function setActivateAction($val)
    {
        if ($val!==null)
            $val = (bool)$val;
        else
            $val = null;
        $this->activateAction = $val;
    }
    
    public function setStaticParams($val)
    {
        $this->staticParams = $val;
    }
    
    public function setRowCountLabel($val)
    {
        $this->rowCountLabel = $val;
    }
    
    public function setShowItemsPerPage($val)
    {
        $this->showItemsPerPage = $val;
    }
    
    public function setShowHeader($val)
    {
        $this->showHeader = $val;
    }
    
    public function setItemUrl($val)
    {
        $this->itemUrl = $val;
    }
    
    public function addColumn(EmtAjaxTableColumn $val)
    {
        if (!in_array($val, $this->columns, true))
        {
            array_push($this->columns, $val);
            $val->setTableObject($this);
        }
    }
    
    public function addColumns($val)
    {
        $l = array();
        foreach ($val as $v)
        {
            if (!($v instanceof EmtAjaxTableColumn)) return false;
            if (!in_array($this->columns, $v, true)) array_push($l, $v);
        }
        foreach ($v as $vx)
        {
            $vx->setTableObject($this);
        }
        $this->columns = array_merge($this->columns, $l);
    }
    
    public function addCustomCriteria($key, $val)
    {
        $this->customCriterias[$key] = $val;
    }
    
    public function getColumnByName($val)
    {
        foreach ($this->columns as $col)
            if ($col->getName()===$val) return $col;
        
        return null;
    }
    
    public function columnExists($name)
    {
        foreach ($this->columns as $col)
            if ($col->getName()===$name) return true;
        
        return false;
    }
    
    public function init(Criteria $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        call_user_func($this->modelClass."Peer::addSelectColumns", $c);
        $joined = array();
        
        foreach ($this->columns as $column)
        {
            if (($column->getApplyFilter() && $this->keyword!='') || (count($column->getRelatedTables()) && $column->getName()==$this->getOrderColumn()))
            {
                $tables = $column->getRelatedTables();
                $table = $tables[0];

                if ($table !== $this->getTable())
                {
                    if (stripos($table, '_I18N')>-1)
                    {
                        $t = str_ireplace('_I18N', '', $table);
                        if ($t !== $this->getTable() && !in_array($t, $joined)) $c->addJoin($column->getJoinWith(), $t.'.ID', Criteria::LEFT_JOIN);
                        $joined[] = $t;
                        $c->addJoin($t.'.ID', $table.".ID", Criteria::LEFT_JOIN);
                    }
                    else
                    {
                        $c->addJoin($column->getJoinWith(), $table.".ID", Criteria::LEFT_JOIN);
                    }
                    $joined[] = $table;
                }
                if ($column->getApplyFilter() && $this->keyword!='')
                    $c->add($table.'.ID', "UPPER(".$column->getFieldName().") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            }
        }
        
        preg_match('/\w+\.\w+/', $this->getColumnByName($this->getOrderColumn())->getFieldName(), $cols);
        $cols = preg_filter('/^EMT_/', '', $cols);
        
        foreach ($cols as $col)
        {
            $coll = preg_replace('/^[\w ]+\./', '', strtoupper($col));
            $col = preg_replace(array('/\.[\w ]+$/', '/_/'), array('', ' '), $col);
            $class = str_replace(' ', '', ucwords(strtolower($col)));

            if ($class!=$this->getModelClass())
            {
                $c->addSelectColumn(constant($class.'Peer::'.$coll));
            }
            if ($this->sortOrder === 'ASC')
                $c->addAscendingOrderByColumn(constant($class.'Peer::'.$coll));
            elseif ($this->sortOrder === 'DESC')
                $c->addDescendingOrderByColumn(constant($class.'Peer::'.$coll));
        }

        $c->setDistinct();
        
        if (count($this->customCriterias))
        {
            foreach ($this->customCriterias as $key => $val)
            {
                $c->add($key, $val);
            }
        }
        $this->pager->setCriteria($c);
        $this->pager->setMaxPerPage($this->itemsPerPage);
        $this->pager->setPage(ceil($this->firstIndice/$this->itemsPerPage));
        //echo $c->toString();
        //die;
        $this->pager->init();
    }
    
    public function getTable()
    {
        return constant($this->modelClass.'Peer::TABLE_NAME');
    }
}
?>