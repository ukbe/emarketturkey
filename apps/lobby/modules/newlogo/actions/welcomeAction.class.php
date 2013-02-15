<?php

class welcomeAction extends EmtAction
{
    public function execute($request)
    {
        $lng = $this->getUser()->getCulture();
        
        if (!$this->getUser()->getAttribute('culture_selected') && $_SERVER["REQUEST_URI"]="/")
        {
            foreach ($this->getRequest()->getLanguages() as $lang)
            {
                if (array_search($lang, sfConfig::get('app_i18n_cultures')) !== false)
                {
                    $this->getUser()->setAttribute('culture_selected', true);
                    $lng = $lang;
                    break;
                }
            }
        }
        $this->redirect('@newlogo2?sf_culture='.$lng);
    }
    
    public function handleError()
    {
    }
    
}
