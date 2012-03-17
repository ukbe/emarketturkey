<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class composeAction extends EmtAction
{
    
    public function execute($request)
    {
        return $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->recipients = array();
        $this->recdata = array();

        $ssplit = explode('|', $this->getRequestParameter('_s') ? base64_decode($this->getRequestParameter('_s')) : null);
        if (is_array($ssplit) && ($ssplit[0] = intval($ssplit[0])) && in_array($ssplit[0], array(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_GROUP)))
        {
            $this->sender = $this->sesuser->isOwnerOf($id=myTools::flipHash($ssplit[1], true, $ssplit[0]), $ssplit[0]) ? PrivacyNodeTypePeer::retrieveObject($id, $ssplit[0]) : null;
        }
        else
        {
            $this->sender = null;
        }
        
        if ($this->sender)
        {
            $recs = $this->getRequestParameter('_r');
            if ($recs && !is_array($recs)) $recs = array($recs);
            else if (!$recs)
            {
                $recs = array();
            }

            foreach ($recs as $rec)
            {
                $rsplit = explode('|', $rec ? base64_decode($rec) : null);

                if (is_array($rsplit) && ($rsplit[0] = intval($rsplit[0])) && in_array($rsplit[0], array(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_GROUP)))
                {
                    $robj = PrivacyNodeTypePeer::retrieveObject(myTools::flipHash($rsplit[1], true, $rsplit[0]), $rsplit[0]);
                    if ($robj && $this->sender->can(ActionPeer::ACT_SEND_MESSAGE, $robj))
                    {
                        $this->recdata[] = array('LABEL' => $robj->__toString(), 'HASH' => $rec);
                        $this->recipients[] = $robj;
                    } 
                }
            }
        }
        $this->recdata = json_encode($this->recdata);
        
        $this->object = myTools::unplug($this->getRequestParameter('_o'), true);

        if ($this->getRequest()->isXmlHttpRequest()) header('Content-type: text/html');

        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();
            
            try
            {
                $con->beginTransaction();
                
                $message = new Message();
                $message->setSenderId($this->sender->getId());
                $message->setSenderTypeId($this->sender->getObjectTypeId());
                $message->setSubject($this->getRequestParameter('_subject'));
                $message->setBody($this->getRequestParameter('_message'));
                if ($this->object)
                {
                    $message->setRelatedObjectId($this->object->getId());
                    $message->setRelatedObjectTypeId($this->object->getObjectTypeId());
                }
                $message->save();
                
                $trs = array();
                
                foreach ($this->recipients as $recipient)
                {
                    $delivery = new MessageRecipient();
                    $delivery->setRecipientId($recipient->getId());
                    $delivery->setRecipientTypeId($recipient->getObjectTypeId());
                    $delivery->setMessageId($message->getId());
                    $delivery->save();
                    
                    $data = new sfParameterHolder();
                    $data->set('rname', $recipient->__toString());
                    $data->set('sname', $this->sender->__toString());
                    $data->set('oname', ($recipient->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_USER ? null : $recipient->getOwner()->__toString()));
                    $data->set('subject', $message->getSubject());
                    $data->set('message', $message->getBody());
                    $data->set('message_id', $message->getId());
                    
                    $vars = array();
                    $vars['email'] = ($recipient->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_USER ? $recipient->getLogin()->getEmail() : $recipient->getOwner()->getLogin()->getEmail());
                    $vars['user_id'] = ($recipient->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_USER ? $recipient->getId() : $recipient->getOwner()->getId());
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NEW_MESSAGE;
    
                    $trs[] = EmailTransactionPeer::CreateTransaction($vars, false);
                    //ActionLogPeer::Log($this->sender, ActionPeer::ACT_SEND_MESSAGE, $recipient);
                }
                
                $con->commit();
                
                foreach ($trs as $tr)
                {
                    $tr->reload();
                    $tr->deliver();
                }

                if ($this->getRequest()->isXmlHttpRequest())
                    return $this->renderPartial('global/ajaxSuccess', array('message' => 'Message successfully sent!'));
                
                else
                    $this->setTemplate('composed');
            }
            catch (Exception $e)
            {
                $con->rollBack();
                ErrorLogPeer::Log($this->sender->getId(), $this->sender->getObjectTypeId(), 'Message:' . $e->getMessage() . "\nFile:" . $e->getFile() . "\nLine:" . $e->getLine());
                $this->getRequest()->setError('_generic', 'Error occured while sending message');
            }
        }
        
        sfLoader::loadHelpers('Partial');

        if ($this->getRequest()->isXmlHttpRequest())
            return $this->renderPartial('sendMessage', array('sf_params' => $this->getRequest()->getParameterHolder(), 'sender' => $this->sender, 'recdata' => $this->recdata, 'header' => implode(', ', $this->recipients), 'sf_request' => $this->getRequest(), '_ref' => $this->_ref));
        else if ($this->hasRequestParameter('callback'))
            return $this->renderText($this->getRequestParameter('callback') . "(" . json_encode(array('content' => get_partial('sendMessage', array('sf_params' => $this->getRequest()->getParameterHolder(), 'sender' => $this->sender, 'recdata' => $this->recdata, 'header' => implode(', ', $this->recipients), 'sf_request' => $this->getRequest(), '_ref' => $this->_ref)))) . ");");
    }

    public function validate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$this->getRequestParameter('_r') || !count($this->getRequestParameter('_r')))
            {
                $this->getRequest()->setError('_r', 'Please specify a recipient');
            }
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        return $this->handleAction(true);
        return sfView::SUCCESS;
    }
}