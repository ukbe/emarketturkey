<?php

class goneAction extends EmtAction
{
    public function execute($request)
    {
        $this->getResponse()->setStatusCode(410);
        return $this->renderText('HTTP 410 - Content has been permanently removed.<br /><br /><a href="http://www.emarketturkey.com">eMarketTurkey Home</a>');
    }

}
