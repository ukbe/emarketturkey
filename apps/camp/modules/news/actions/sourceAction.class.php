<?php

class sourceAction extends EmtAction
{
    protected $i18n_object_depended = true;

    public function execute($request)
    {
        $xcult = myTools::pick_from_list($this->getRequestParameter('x-cult'), sfConfig::get('app_i18n_cultures'), null);

        $this->source = PublicationSourcePeer::retrieveByStrippedName($this->getRequestParameter('stripped_display_name'), $xcult);

        if (!$this->source || !$this->source->getActive()) $this->redirect404();

        $urls = array();
        foreach (sfConfig::get('app_i18n_cultures') as $culture)
        {
            $urls[$culture] = $this->source->getUrl(PublicationPeer::PUB_TYP_NEWS, $culture);
            if (!isset($urls[$culture]) || is_null($urls[$culture])) $urls[$culture] = "@news-home?sf_culture=$culture";
        }

        if ($xcult)
        {
            $this->redirect($urls[$xcult]);
        }

        $this->getUser()->setCultureLinks($urls);

        $c = new Criteria();
        $c->add(PublicationPeer::TYPE_ID, PublicationPeer::PUB_TYP_NEWS);
        $c->add(PublicationPeer::ACTIVE, 1);
        $c->addDescendingOrderByColumn(PublicationPeer::CREATED_AT);
        $this->news = $this->source->getPublications($c);

        $this->banner_news = array_splice($this->news, 0, 5);
        $this->top_posts = PublicationPeer::getMostReadPublications(null, 5, $this->getUser()->getCulture(), $this->source->getId(), null);
        $this->colarticles = PublicationPeer::getColumnArticles();
    }

    public function handleError()
    {
    }

}
