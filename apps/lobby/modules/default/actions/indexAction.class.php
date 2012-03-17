<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getUser()->getAttribute('culture_selected') && $_SERVER["REQUEST_URI"]="/")
        {
            foreach ($this->getRequest()->getLanguages() as $lang)
            {
                if (array_search($lang, array('tr', 'en')) !== false)
                {
                    $this->getUser()->setAttribute('culture_selected', true);
                    $this->redirect(myTools::localizedUrl($lang));
                }
            }
        }
        $startup = base64_decode($request->getCookie('EMT_STARTUP'));
        if (in_array($startup, array('b2b', 'hr', 'cm', 'tx', 'ac')) && $request->getReferer()=='')
        {
            $this->redirect('@'.$startup.'.homepage');
        }
        else
        {
            $cookieparams = session_get_cookie_params();
            $cook = base64_encode('lobby');
            sfContext::getInstance()->getResponse()->setCookie('EMT_STARTUP', $cook, time()+60*60*24*15, '/', $cookieparams['domain']);
        }
    }
    
    public function handleError()
    {
    }
    
}
