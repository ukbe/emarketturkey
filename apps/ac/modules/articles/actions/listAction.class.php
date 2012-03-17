<?php

class listAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->getRequestParameter('stripped_display_name') != '')
        {
            $this->author = AuthorPeer::retrieveByStrippedName($this->getRequestParameter('stripped_display_name'));
            if ($this->author) $this->articles = $this->author->getArticle();
            else $this->articles = array();
        }
        else
        {
            $this->redirect404();
        }
    }
    
    public function handleError()
    {
    }
    
}
