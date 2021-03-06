<?php

class postsAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.author?".http_build_query($params), 301);

        $this->author = AuthorPeer::retrieveByStrippedName($this->getRequestParameter('stripped_display_name'));

        if (!$this->author || !$this->author->getActive()) $this->redirect404();

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
