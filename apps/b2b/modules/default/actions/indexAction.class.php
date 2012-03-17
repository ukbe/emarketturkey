<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getUser()->getAttribute('culture_selected') && $_SERVER["REQUEST_URI"]="/")
        {
            foreach ($this->getRequest()->getLanguages() as $lang)
            {
                if (array_search($lang, array('tr', 'en')) !== false)
                {
                    $this->getUser()->setAttribute('culture_selected', true);
                    $this->redirect(myTools::localizedUrl($lang));
                }
            }
        }
        
        $this->categories = ProductCategoryPeer::getBaseCategories();
        
        $this->featured_products = ProductPeer::getFeaturedProducts(8);
        
        $this->featured_companies = CompanyPeer::getFeaturedCompanies(8);
        
        $this->selling_leads = B2bLeadPeer::getFeaturedLeads(B2bLeadPeer::B2B_LEAD_SELLING, 5);
        $this->buying_leads = B2bLeadPeer::getFeaturedLeads(B2bLeadPeer::B2B_LEAD_BUYING, 5);
    }
    
    public function handleError()
    {
    }
    
}
