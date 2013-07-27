<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class addAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->setTemplate('nonAjaxAdd');
        }

        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->getRequest()->hasParameter('cid') && is_numeric($this->getRequestParameter('cid')))
        {
            $this->contact = UserPeer::retrieveByPK($this->getRequestParameter('cid'));
            if ($this->contact)
            {
                if ($this->user->isFriendsWith($this->contact->getId()) || $this->contact->getId() == $this->user->getId())
                    $this->contact = null;
            }
        }
        if (!$this->contact)
        {
            $this->redirect('@camp.network');
        }
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $this->relation = $this->getUser()->getUser()->setupRelationWith($this->contact->getId());
                
                if ($this->relation)
                {
                    $data = new sfParameterHolder();
                    $data->set('cname', $this->contact->getName());
                    $data->set('clname', $this->contact->getLastname());
                    $data->set('uname', $this->getUser()->getUser()->getName());
                    $data->set('ulname', $this->getUser()->getUser()->getLastname());
                    $data->set('ugender', $this->getUser()->getUser()->getGender());
                    $data->set('message', $this->getRequestParameter('invite_message'));
                    
                    $vars = array();
                    $vars['email'] = $this->contact->getLogin()->getEmail();
                    $vars['user_id'] = $this->contact->getId();
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NETWORK_REQUEST;
                    
                    EmailTransactionPeer::CreateTransaction($vars);
                    $this->getUser()->setMessage('Friendship Request Sent!', 'A friendship request has been sent to %1', null, array('%1' => $this->user));
                    
                    if ($this->getRequest()->isXmlHttpRequest())
                    {
                        return $this->renderText(javascript_tag("window.location = '{$this->getRequestParameter('ref')}';"));
                    }
                    elseif ($this->getRequestParameter('ref') != '')
                    {
                        $this->redirect($this->getRequestParameter('ref'));
                    }
                    else
                    {
                        $this->setTemplate('added');
                    }
                }
            }
        }
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