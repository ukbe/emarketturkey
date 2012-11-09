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
        
        $this->featured_products = ProductPeer::getFeaturedProducts(12, true);
        
        $this->featured_companies = CompanyPeer::getFeaturedCompanies(12);
        
        $this->selling_leads = B2bLeadPeer::getFeaturedLeads(B2bLeadPeer::B2B_LEAD_SELLING, 12);
        $this->buying_leads = B2bLeadPeer::getFeaturedLeads(B2bLeadPeer::B2B_LEAD_BUYING, 12);

        $this->featured_shows = array(); //EventPeer::getFeaturedEvents(3, EventTypePeer::ECLS_TYP_BUSINESS);
        $this->featured_experts = array(); //TradeExpertPeer::getFeaturedTradeExperts(4);
    }
    
    public function handleError()
    {
    }
    
}
