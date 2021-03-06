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

        $cookieparams = session_get_cookie_params();
        $cook = base64_encode('ac');
        sfContext::getInstance()->getResponse()->setCookie('EMT_STARTUP', $cook, time()+60*60*24*15, '/', $cookieparams['domain']);
        
        $this->banner_pubs = PublicationPeer::doSelectByTypeId(null, false, null, 5, PublicationPeer::PUB_FEATURED_BANNER);

        $columnsTypes = sfConfig::get('app_homepagePlacements_newsColumns');
        $this->sectnews = PublicationPeer::doSelectNewsByCategory(false, $columnsTypes, PublicationPeer::PUB_FEATURED_COLUMN, 4, 4);

        $this->colarticles = PublicationPeer::getColumnArticles();
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture());
        $this->top_news = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_NEWS, 5, $this->getUser()->getCulture());

    }
    
    public function handleError()
    {
    }
    
}
