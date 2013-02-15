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
                    $this->getUser()->setCulture($lang);
                    $this->forward('default', 'index');
                }
            }
        }
    }
    
    public function handleError()
    {
    }
    
}
