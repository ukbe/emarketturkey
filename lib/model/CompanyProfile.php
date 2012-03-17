<?php

class CompanyProfile extends BaseCompanyProfile
{
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentCompanyProfileI18n($culture);
        return $lsi->isNew()?false:true;
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
            
            $sql = "SELECT CULTURE FROM EMT_COMPANY_PROFILE_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(CompanyProfileI18nPeer::ID, $this->getId());
        $c->add(CompanyProfileI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return CompanyProfileI18nPeer::doDelete($c);
    }
    
}
