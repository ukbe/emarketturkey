<?php

class productAction extends EmtProductAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1 from %2", array('%1' => $this->product, '%2' => $this->company)) . ' | eMarketTurkey');

        $this->products = $this->company->getProductsOfCategory($this->product->getCategoryId());

        $this->groups = $this->company->getOrderedGroups(false);
        $this->categories = $this->company->getOrderedCategories(false);
        
        $this->attr = $this->product->getAttributeMatrix();
        $this->payment_terms = $this->product->getPaymentTermList();
        if (!is_array($this->payment_terms)) $this->payment_terms = array();
        $this->photos = $this->product->getPhotos();
        
        if (!$this->own_company) RatingPeer::logNewVisit($this->product->getId(), PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
    }
    
    public function handleError()
    {
    }
    
}