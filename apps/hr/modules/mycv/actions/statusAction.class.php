<?php

class statusAction extends EmtCVAction
{
    protected $enforceResume = true;
     
    public function execute($request)
    {
        $act = myTools::pick_from_list($this->getRequestParameter('act'), array('activate', 'deactivate'), null);
        
        if ($act)
        {
            if ($act == 'activate') $this->resume->setActive(true);
            if ($act == 'deactivate') $this->resume->setActive(false);
            $this->resume->save();
        }
        $this->redirect($this->_ref ? $this->_ref : ($this->_referer ? $this->_referer : '@mycv'));
    }
    
}
