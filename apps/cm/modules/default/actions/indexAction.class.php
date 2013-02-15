<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect('@camp.community', 301);

        if (!$this->getUser()->getAttribute('culture_selected') && $_SERVER["REQUEST_URI"]="/")
        {
            foreach ($this->getRequest()->getLanguages() as $lang)
            {
                if (array_search($lang, sfConfig::get('app_i18n_cultures')) !== false)
                {
                    $this->getUser()->setAttribute('culture_selected', true);
                    $this->redirect(myTools::localizedUrl($lang));
                }
            }
        }
        
        $cookieparams = session_get_cookie_params();
        $cook = base64_encode('cm');
        sfContext::getInstance()->getResponse()->setCookie('EMT_STARTUP', $cook, time()+60*60*24*15, '/', $cookieparams['domain']);

    }
    
    public function handleError()
    {
    }
    
}
