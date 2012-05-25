<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class contactAction extends EmtGroupAction
{
    public function execute($request)
    {
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->group->getTypeId() == GroupTypePeer::GRTYP_ONLINE) $this->redirect($this->group->getProfileUrl());

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Contact %1', array('%1' => $this->group->getName())) . ' | eMarketTurkey');

        $this->getResponse()->setTitle($this->group . ' | eMarketTurkey');
        
        $this->related = $this->getRequestParameter('rel') ? myTools::unplug($this->getRequestParameter('rel')) : null;

        if ($this->related)
        {
            $owner = $this->related->getOwner();
            if ($owner->getId() != $this->group->getId() || $owner->getObjectTypeId() != $this->group->getObjectTypeId())
            {
                $this->related = null;
            }
        }
        
        $this->composed = false;
        
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
                if (is_object($this->related))
                {
                    $message->setRelatedObjectId($this->related->getId());
                    $message->setRelatedObjectTypeId($this->related->getObjectTypeId());
                }
                $message->save();

                $trs = array();

                $delivery = new MessageRecipient();
                $delivery->setRecipientId($this->group->getId());
                $delivery->setRecipientTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                $delivery->setMessageId($message->getId());
                $delivery->save();
                
                $data = new sfParameterHolder();
                $data->set('rname', $this->group->__toString());
                $data->set('sname', $this->sender->__toString());
                $data->set('oname', $this->group->getOwner()->__toString());
                $data->set('subject', $message->getSubject());
                $data->set('message', $message->getBody());
                $data->set('message_link', $message->getUrl());
                
                $vars = array();
                $vars['email'] = $this->group->getOwner()->getLogin()->getEmail();
                $vars['user_id'] = $this->group->getOwner()->getId();
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NEW_MESSAGE;

                $trs[] = EmailTransactionPeer::CreateTransaction($vars, false);
                ActionLogPeer::Log($this->sender, ActionPeer::ACT_SEND_MESSAGE, $this->group);
                
                $con->commit();
                
                foreach ($trs as $tr)
                {
                    $tr->reload();
                    $tr->deliver();
                }

                $this->composed = true;
            }
            catch (Exception $e)
            {
                $con->rollBack();
                ErrorLogPeer::Log($this->sender->getId(), $this->sender->getObjectTypeId(), 'Message:' . $e->getMessage() . "\nFile:" . $e->getFile() . "\nLine:" . $e->getLine());
                $this->getRequest()->setError('_generic', 'Error occured while sending message');
            }
        }
        
        $this->contact = $this->group->getContact();
        $this->address = $this->contact->getWorkAddress();
        $this->phone = $this->contact->getWorkPhone();

    }

    public function validate()
    {
        $ssplit = explode('|', $this->getRequestParameter('_s') ? base64_decode($this->getRequestParameter('_s')) : null);
        if (is_array($ssplit) && ($ssplit[0] = intval($ssplit[0])) && in_array($ssplit[0], array(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_GROUP)))
        {
            $this->sender = $this->sesuser->isOwnerOf($id=myTools::flipHash($ssplit[1], true, $ssplit[0]), $ssplit[0]) ? PrivacyNodeTypePeer::retrieveObject($id, $ssplit[0]) : null;
        }
        else
        {
            $this->sender = null;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->sender) $this->getRequest()->setError('_s', 'Please select a sender.');
        
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}