<?php

class indexBCAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->hasRequestParameter('stripped_title'))
        {
            $article = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'));
            
            if ($article && $article->getTypeId() == PublicationPeer::PUB_TYP_ARTICLE)
            {
                $this->redirect($article->getUrl(), 301);
            }
        }
        $this->redirect404();
    }
    
    public function handleError()
    {
    }
    
}