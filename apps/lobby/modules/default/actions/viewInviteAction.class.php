<?php

class viewInviteAction extends EmtAction
{
    public function execute($request)
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
            $tr = $invite->getEmailTransaction();
            if ($tr)
            {
                sfLoader::loadHelpers('Partial');
                $params = unserialize($tr->getData());
                if ($this->getRequestParameter('ln') == 'tr' || $this->getRequestParameter('ln') == 'en')
                {
                    $params['culture'] = $this->getRequestParameter('ln');
                }
                return $this->renderText(get_partial($tr->getEmailTransactionNamespace()->getTemplate(), $params));
            }
        }
        $this->redirect404();
    }
    
    public function handleError()
    {
    }
    
}
