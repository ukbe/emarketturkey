<?php

class ProductGroup extends BaseProductGroup
{
    public function __toString()
    {
        return $this->getName() ? $this->getName() : $this->getName($this->getDefaultLang()); 
    }
    
    public function setName($name, $culture = null)
    {
        parent::setName($name, $culture);
        
        $this->setStrippedName(myTools::url_slug($name));
    }
    
    public function getNameByPriority()
    {
        return $this->getName() ? $this->getName() : $this->getName($this->getDefaultLang());
    }
    
    public function getEditUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "edit-product-group?hash={$this->getCompany()->getHash()}&id={$this->getId()}";  
    }

    public function getUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'camp' ? "@" : "@camp.") . "company-product-substitute?hash={$this->getCompany()->getHash()}&substitute={$this->getSafeStrippedName()}";  
    }

    public function getExistingI18ns()
    {
        if ($this->isNew())
        {
            return array();
        }
        else
        {
            $con = Propel::getConnection();
            
            $sql = "SELECT CULTURE FROM EMT_PRODUCT_GROUP_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(ProductGroupI18nPeer::ID, $this->getId());
        $c->add(ProductGroupI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return ProductGroupI18nPeer::doDelete($c);
    }
    
    public function getSafeStrippedName()
    {
        return $this->getStrippedName() ? $this->getStrippedName() : $this->getStrippedName($this->getDefaultLang());
    }
}
