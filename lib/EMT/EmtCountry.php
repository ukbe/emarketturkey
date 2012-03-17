<?php
class EmtCountry
{
    protected $code;
    protected $name;
    
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->code = ($row[$startcol + 0] !== null) ? $row[$startcol + 0] : 'XX';
            $this->name = sfContext::getInstance()->getI18N()->getCountry($this->code);

            // FIXME - using NUM_COLUMNS may be clearer.
            return $startcol + 1; // 1 = CompanyPeer::NUM_COLUMNS - CompanyPeer::NUM_LAZY_LOAD_COLUMNS).

        } catch (Exception $e) {
            throw new PropelException("Error populating Country object", $e);
        }
    }
    
    public function getId()
    {
        return $this->code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function __toString()
    {
        return image_tag('layout/flag/'.($this->getCode()!='' ? strtoupper($this->getCode()).'.png' : 'XX.png'), 'height=12'). '&nbsp;' .($this->code!='XX' ? $this->name : sfContext::getInstance()->getI18N()->__('Unknown'));
    }
}
?>