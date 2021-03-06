<?php

class productAction extends EmtProductAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1 from %2", array('%1' => $this->product->__toString(), '%2' => $this->company->__toString())) . ' | eMarketTurkey');

        $this->products = $this->company->getProductsOfCategory($this->product->getCategoryId());

        $this->groups = $this->company->getOrderedGroups(false);
        $this->categories = $this->company->getOrderedCategories(false);
        
        $this->attr = $this->product->getAttributeMatrix();
        $this->payment_terms = $this->product->getPaymentTermList();
        if (!is_array($this->payment_terms)) $this->payment_terms = array();
        $this->photos = $this->product->getPhotos();

        $this->getResponse()->setItemType('http://schema.org/Product');

        $this->introduction = $this->product->getClob(ProductI18nPeer::INTRODUCTION);
        $this->getResponse()->addObjectMeta(array('name' => 'description', 'itemprop' => 'description'), $this->introduction ? myTools::trim_text($this->introduction, 250, true) : sfContext::getInstance()->getI18N()->__("%1 from %2", array('%1' => $this->product->__toString(), '%2' => $this->company->__toString())));
        $this->getResponse()->addObjectMeta(array('itemprop' => 'name'), $this->product->__toString());
        if ($brand = $this->product->getAbsBrandName()) $this->getResponse()->addObjectMeta(array('itemprop' => 'brand'), $brand);
        $this->getResponse()->addObjectMeta(array('itemprop' => 'manufacturer'), $this->company->__toString());
        sfLoader::loadHelpers('Url');
        if (count($this->photos)) $this->getResponse()->addObjectMeta(array('itemprop' => 'image'), url_for($this->photos[0]->getOriginalFileUri(), true));
        $this->getResponse()->addObjectMeta(array('itemprop' => 'url'), url_for($this->product->getUrl(), true));
        $this->getResponse()->addObjectMeta(array('http-equiv' => 'last-modified'), $this->product->getUpdatedAt('Y-m-d\TH:i:s\Z'));
        
        if (!$this->own_company) RatingPeer::logNewVisit($this->product->getId(), PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
    }
    
    public function handleError()
    {
    }
    
}