<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect('@camp.homepage', 301);

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
        
        $this->featured_products = ProductPeer::getFeaturedProducts(20, true);
        
        $this->featured_companies = CompanyPeer::getFeaturedCompanies(20);
        
        $this->selling_leads = B2bLeadPeer::getFeaturedLeads(B2bLeadPeer::B2B_LEAD_SELLING, 20);
        $this->buying_leads = B2bLeadPeer::getFeaturedLeads(B2bLeadPeer::B2B_LEAD_BUYING, 20);

        $this->featured_shows = EventPeer::getFeaturedEvents(3, EventTypePeer::ECLS_TYP_BUSINESS);
        $this->featured_experts = TradeExpertPeer::getFeaturedTradeExperts(4);
    }
    
    public function handleError()
    {
    }
    
}
