<?php

class connectAction extends EmtAction
{

    public function execute($request)
    {
        $this->user = myTools::unplug($this->getRequestParameter('user'), true);

        if ($this->getRequest()->isXmlHttpRequest()) header('Content-type: text/html');

        if (!$this->user && ($this->getRequest()->isXmlHttpRequest() || $this->hasRequestParameter('callback'))) return $this->renderText($this->getContext()->getI18N()->__('ACTION DISALLOWED'));
        if (!$this->user) $this->redirect('@myemt.homepage');

        if ($this->getRequestParameter('mod') == 'commit' && !$this->sesuser->isFriendsWith($this->user->getId()))
        {
            if ($this->sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $this->user))
            {
                $this->relation = $this->sesuser->setupRelationWith($this->user->getId());

                if ($this->relation)
                {
                    $data = new sfParameterHolder();
                    $data->set('cname', $this->user->getName());
                    $data->set('clname', $this->user->getLastname());
                    $data->set('uname', $this->sesuser->getName());
                    $data->set('ulname', $this->sesuser->getLastname());
                    $data->set('ugender', $this->sesuser->getGender());
                    $data->set('message', $this->getRequestParameter('invite_message'));

                    $vars = array();
                    $vars['email'] = $this->user->getLogin()->getEmail();
                    $vars['user_id'] = $this->user->getId();
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NETWORK_REQUEST;

                    EmailTransactionPeer::CreateTransaction($vars);

                    if ($this->getRequest()->isXmlHttpRequest())
                    {
                        return $this->renderPartial('global/ajaxSuccess', array('message' => $this->getContext()->getI18N()->__('Your connection request was submitted.'), 'redir' => $this->_ref ? $this->_ref : $this->_referer));
                    }
                    elseif ($this->hasRequestParameter('callback'))
                    {
                        return $this->renderText($this->getRequestParameter('callback')."(".json_encode(array('content' => $this->getPartial('global/ajaxSuccess', array('message' => $this->getContext()->getI18N()->__('Your connection request was submitted.'), 'redir' => $this->_ref ? $this->_ref : $this->_referer)))).");");
                    }
                    else
                    {
                        $this->getUser()->setMessage('Friendship Request Sent!', 'A friendship request has been sent to %1', 
                                                  null, array('%1' => $this->user));

                        $this->redirect($this->_ref);
                    }
                }
            }
            if ($this->getRequest()->isXmlHttpRequest() || $this->hasRequestParameter('callback'))
                return $this->renderPartial('global/ajaxSuccess', array('message' => $this->getContext()->getI18N()->__('ACTION DISALLOWED')));
        }
        elseif ($this->sesuser->isFriendsWith($this->user))
        {
            if ($this->getRequest()->isXmlHttpRequest() || $this->hasRequestParameter('callback'))
                return $this->renderPartial('global/ajaxSuccess', array('message' => $this->getContext()->getI18N()->__('You are already connected.')));
        }
        elseif (!$this->sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $this->user))
        {
            if ($this->getRequest()->isXmlHttpRequest() || $this->hasRequestParameter('callback'))
                return $this->renderPartial('global/ajaxSuccess', array('message' => $this->getContext()->getI18N()->__('ACTION DISALLOWED')));
        }

        if ($this->getRequest()->isXmlHttpRequest())
            return $this->renderPartial('connect', array('sesuser' => $this->sesuser, 'user' => $this->user, '_ref' => $this->_ref));
        if ($this->hasRequestParameter('callback'))
            return $this->renderText($this->getRequestParameter('callback').'('.json_encode(array('content' => $this->getPartial('connect', array('sesuser' => $this->sesuser, 'user' => $this->user, '_ref' => $this->_ref)))).');');

    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}