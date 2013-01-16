<?php

class moved301Action extends EmtAction
{
    public function execute($request)
    {
        switch ($this->getContext()->getRouting()->getCurrentRouteName())
        {
            case 'article-by-moved':
                 $this->redirect('@article-source?stripped_display_name='.$this->getRequestParameter('stripped_display_name'), 301);
        }
		return $this->renderText('HTTP 400 - Bad Request.', 400);
    }

}
