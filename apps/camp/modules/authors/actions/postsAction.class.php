<?php

class postsAction extends EmtAction
{
    protected $i18n_object_depended = true;

    public function execute($request)
    {
        $xcult = myTools::pick_from_list($this->getRequestParameter('x-cult'), sfConfig::get('app_i18n_cultures'), null);

        $this->author = AuthorPeer::retrieveByStrippedName($this->getRequestParameter('stripped_display_name'), $xcult);

        if (!$this->author || !$this->author->getActive()) $this->redirect404();

        $urls = array();
        foreach (sfConfig::get('app_i18n_cultures') as $culture)
        {
            $urls[$culture] = $this->author->getUrl('posts', $culture);
            if (!isset($urls[$culture]) || is_null($urls[$culture])) $urls[$culture] = "@academy?sf_culture=$culture";
        }

        if ($xcult)
        {
            $this->redirect($urls[$xcult]);
            
        }

        $this->getUser()->setCultureLinks($urls);

        $c = new Criteria();
        $c->add(PublicationPeer::ACTIVE, 1);
        $c->addDescendingOrderByColumn(PublicationPeer::CREATED_AT);
        $this->articles = $this->author->getPublications($c);

        $this->banner_articles = array_splice($this->articles, 0, 5);
        $this->top_posts = PublicationPeer::getMostReadPublications(null, 5, $this->getUser()->getCulture(), null, $this->author->getId());
        $this->colarticles = PublicationPeer::getColumnArticles();
    }

    public function handleError()
    {
    }

}
