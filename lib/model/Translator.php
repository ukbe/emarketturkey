<?php

class Translator extends BaseTranslator
{
    protected $o_holder = null;
    private $hash = null;
    
    public function __toString()
    {
        return $this->getName() ? $this->getName() : $this->getDefaultName();
    }

    public function setName($value, $culture = null)
    {
        parent::setName($value, $culture);
        
        $this->setStrippedName(myTools::stripText($value), $culture);
    }

    public function getDefaultName()
    {
        return $this->getName($this->getDefaultLang());
    }

    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_TRANSLATOR;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_TRANSLATOR) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getClob($field, $culture = null)
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_TRANSLATOR_I18N 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
    public function getHolder()
    {
        return isset($this->o_holder) ? $this->o_holder : ($this->o_holder = PrivacyNodeTypePeer::retrieveObject($this->getHolderId(), $this->getHolderTypeId()));
    }
    
    public function getProfilePictureUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        return $this->getHolder()->getProfilePictureUri($size);
    }
    
    public function getProfileUrl()
    {
        return (sfContext::getInstance()->getConfiguration()->getApplication() == "tx" ? "@" : "@tx.") . "translator-profile?hash=".$this->getHash();
    }

    public function getContact()
    {
        return $this->getHolder()->getContact();
    }
    
    public function getLanguages()
    {
        $c = new Criteria();
        $c->addJoin(TranslatorPeer::ID, TranslatorLanguagePeer::TRANSLATOR_ID, Criteria::LEFT_JOIN);
        $c->add(TranslatorPeer::ID, $this->getId());
        $c->addAscendingOrderByColumn(myTools::NLSFunc(TranslatorLanguagePeer::LANGUAGE, 'SORT'));
        return TranslatorLanguagePeer::doSelect($c);
    }
    
    public function getLanguagesText()
    {
        use_helper('I18n');
        return format_number_choice('[0]No languages.|[1]1 language.|(1,+Inf]%1 language.', 
                 array('%1' => $this->countTranslatorLanguages()), $this->countTranslatorLanguages());
    }

}
