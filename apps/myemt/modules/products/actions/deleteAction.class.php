<?php

class deleteAction extends EmtManageProductAction
{
    public function execute($request)
    {
        if ($this->getRequestParameter('do')=='commit')
        {
            $this->product->setDeletedAt(time());
            $this->product->save();

            if ($this->getRequest()->isXmlHttpRequest())
                return $this->renderPartial('global/ajaxSuccess', array(
                                'message' => $this->getContext()->getI18N()->__('Your product has been deleted!'),
                                'redir' => "@list-products?hash={$this->company->getHash()}"
                            ));
            else
                $this->redirect("@list-products?hash={$this->company->getHash()}");
        }
        else
        {
            if ($this->getRequest()->isXmlHttpRequest())
                return $this->renderPartial('confirmItemRemoval', array('message' => 'Are you sure to delete your product?', 'postUrl' => "@delete-product?hash={$this->company->getHash()}&id={$this->product->getId()}", 'object' => $this->product, 'sf_params' => $this->getRequest()->getParameterHolder(), 'sf_request' => $this->getRequest()));
        }

        $this->photos = $this->product->getPhotos();
        $this->category = $this->product->getProductCategory();
        $this->i18ns = $this->product->getExistingI18ns();
        $this->attrmatrix = $this->product->getAttributeMatrix();
        $this->payment_terms = unserialize($this->product->getPaymentTerms());

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Confirm Product Removal: %1', array('%1' => $this->product->__toString())));
        
/*        if (md5($this->product->getName().$this->product->getId().session_id())==$this->getRequestParameter('do'))
        {
            $this->product->delete();
        }
        $this->redirect("@manage-products?hash={$this->company->getId()}");
        */
    }
    
    public function handleError()
    {
    }
    
}