<?php

class sourceAction extends EmtAction
{
    public function execute($request)
    {
        $this->source = PublicationSourcePeer::retrieveByStrippedName($this->getRequestParameter('stripped_display_name'), true);

        if (!$this->source) $this->redirect404();

        $this->redirect($this->source->getUrl(PublicationPeer::PUB_TYP_NEWS), 301);
    }

    public function handleError()
    {
    }

}
