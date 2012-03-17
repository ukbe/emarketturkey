<?php

class indexAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        if ($this->getRequestParameter('invite')!='')
        {
            $invite = InviteFriendPeer::retrieveByGuid($this->getRequestParameter('invite'));
        }
        else
        {
            $invite = null;
        }
        
        if ($invite)
        {
            $invite->setIsRead(1);
            $invite->save();
            
            $filename = SF_ROOT_DIR . '/web/images/layout/icon/bullet.png';
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT\n");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Content-type: image/png;\n"); //or yours?
            header("Content-Transfer-Encoding: binary");
            $len = filesize($filename);
            header("Content-Length: $len;\n");
            @readfile($filename);
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }
    
}