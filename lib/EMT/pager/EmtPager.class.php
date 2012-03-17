<?php

class EmtPager extends sfPager
{
  protected
    $sql               = null,
    $bindColumns       = null;

  public function __construct($class, $maxPerPage = 10, $freePageNum = false)
  {
    parent::__construct($class, $maxPerPage);

    $this->bindColumns = array();
    $this->setSql("");
    $this->tableName = constant($this->getClassPeer().'::TABLE_NAME');
  }

  public function init()
  {
    $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
    $maxRecordLimit = $this->getMaxRecordLimit();

    $sqlForCount = "SELECT COUNT(*) FROM (".$this->getSql().")";

    $stmt = myTools::executeSql($sqlForCount);

    $count = $stmt->fetch(PDO::FETCH_COLUMN, 0);

    $this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

      $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
    }
  }

  protected function retrieveObject($offset)
  {
    $cForRetrieve = clone $this->getCriteria();
    $cForRetrieve->setOffset($offset - 1);
    $cForRetrieve->setLimit(1);

    $results = call_user_func(array($this->getClassPeer(), $this->getPeerMethod()), $cForRetrieve);

    return is_array($results) && isset($results[0]) ? $results[0] : null;
  }

  public function getResults()
  {
    $sql = $this->getSql();

    $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
    $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
    $maxRecordLimit = $this->getMaxRecordLimit();
    
    if ($hasMaxRecordLimit)
    {
      $maxRecordLimit = $maxRecordLimit - $offset;
      if ($maxRecordLimit > $this->getMaxPerPage())
      {
        $maxPerPage = $this->getMaxPerPage();
      }
      else
      {
        $maxPerPage = $maxRecordLimit;
      }
    }
    else
    {
      $maxPerPage = $this->getMaxPerPage();
    }
    
    
    $sqlForResults = "SELECT * FROM (SELECT PPP.*, ROWNUM PPPRNUM FROM ($sql) PPP) WHERE PPPRNUM BETWEEN $offset AND ".($offset + $maxPerPage);

    $stmt = myTools::executeSql($sqlForResults);
        
    if ($this->getClass())
    {
        $class = $this->getClass();
        $objects = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM))
        {
            $obj = new $class();
            $obj->hydrate($row, 0);

            foreach ($this->bindColumns as $key => $indice)
            {
                $obj->{$key} = $row[$indice];
            }
            $objects[] = $obj;
        }
        return $objects;
    }
    else
    {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
  }

  public function getClassPeer()
  {
    return constant($this->class.'::PEER');
  }

  public function getSql()
  {
    return $this->sql;
  }

  public function setSql($sql)
  {
    $this->sql = $sql;
  }

  public function getBindColumns()
  {
    return $this->bindColumns;
  }

  public function setBindColumns($columns)
  {
    $this->bindColumns = $columns;
  }
}
