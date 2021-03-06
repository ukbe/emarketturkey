<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getUser()->getAttribute('culture_selected') && $_SERVER["REQUEST_URI"]="/")
        {
            foreach ($this->getRequest()->getLanguages() as $lang)
            {
                if (array_search($lang, sfConfig::get('app_i18n_cultures')) !== false)
                {
                    $this->getUser()->setAttribute('culture_selected', true);
                    $this->redirect(myTools::localizedUrl($lang));
                }
            }
        }

        $this->getResponse()->addMeta('application-name', 'eMarketTurkey');
        $this->getResponse()->addLinkMeta(array('rel' => 'canonical'), myTools::localizedUrl($this->getUser()->getCulture(), true, 'homepage'));

        $alternates = array();
        foreach (sfConfig::get('app_i18n_cultures') as $culture)
            if ($culture != $this->getUser()->getCulture()) 
                $alternates[$culture] = myTools::localizedUrl($culture, true, 'homepage');

        $titles = array('en' => 'eMarketTurkey', 'tr' => 'eMarketTurkey Turkish', 'ru' => 'eMarketTurkey Russian');
        foreach ($alternates as $lang => $link)
            $this->getResponse()->addLinkMeta(array('rel' => 'alternate', 'hreflang' => $lang, 'title' => $titles[$lang], 'type' => 'text/html'), $link);
        
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
