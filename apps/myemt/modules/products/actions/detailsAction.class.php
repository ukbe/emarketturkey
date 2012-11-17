<?php

class detailsAction extends EmtManageProductAction
{
    protected $enforceProduct = true;
    
    public function handleAction($isValidationError)
    {
         
        // Prepare variables from original Product
        
        // Handle relevant actions
        if ($this->getRequestParameter('act')=='rmp' && $photo = $this->product->getPhotoByGuid($this->getRequestParameter('phid')))
        {
            $photo->delete();
        }
        
        $this->photos = $this->product->getPhotos();
        $this->category = $this->product->getProductCategory();
        $this->i18ns = $this->product->getExistingI18ns();
        $this->attrmatrix = $this->product->getAttributeMatrix();
        $this->payment_terms = unserialize($this->product->getPaymentTerms());

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Product Details: %1', array('%1' => $this->product->__toString())));
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}