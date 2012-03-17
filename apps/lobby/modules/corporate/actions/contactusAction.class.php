<?php

class contactusAction extends EmtAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->user = $this->getUser()->getUser();
    }    
    
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $i18n = $this->getContext()->getI18N();
        $this->subject_list = array(
            '' => $i18n->__('Please select a topic'),
            '1' => $i18n->__('Technical Support'),
            '2' => $i18n->__('Feature Request'),
            '3' => $i18n->__('Bug Report'),
            '4' => $i18n->__('Financial Inquiry'),
            '5' => $i18n->__('Other')
        );
                
        if (!$isValidationError && $this->getRequest()->getMethod()==sfRequest::POST)
        {
            try
            {
                $message = new CustomerMessage();
                if ($this->user) $message->setUserId($this->user->getId());
                $message->setSenderNamelastname($this->getRequestParameter('sender_name'));
                $message->setSenderEmail($this->getRequestParameter('sender_email'));
                $message->setSenderIp($_SERVER['REMOTE_ADDR']);
                $message->setMessage($this->getRequestParameter('message_text'));
                $message->setTopicId($this->getRequestParameter('topic_id'));
                $message->save();
                $this->successtext = "We have succesfully stored your message. Thank you for contacting us!";
                sfLoader::loadHelpers('Url');
                $textbody = "<html><body>Hi,<br />Please see the message below:<br /><br />";
                $textbody .= "<b>Name&Lastname</b> {$message->getSenderNamelastname()}<br />";
                $textbody .= "<b>Email:</b> {$message->getSenderEmail()}<br />";
                $textbody .= "<b>Sender IP:</b> {$message->getSenderIp()}<br />";
                $textbody .= "<b>Subject:</b> " . $this->subject_list[$message->getTopicId()] . "<br />";
                $textbody .= "<b>Message:</b> {$message->getMessage()}<br />";
                $textbody .= "<b>Session User:</b> ". ($message->getUser() ? "<a href=\"".url_for($message->getUser()->getProfileUrl())."\">{$message->getUser()}</a>" : "");
                $textbody .= "</body></html>";

                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\r\n";

                mail('ukbe.akdogan@emarketturkey.com', 'New Contact Message', $textbody, $headers);
            }
            catch (Exception $e)
            {
                ErrorLogPeer::Log(0, 0, $e->getMessage());
                $this->errortext = "An error occured while while storing your message. Please try again.<br />We're sorry for inconvenience..";
            }
        }
    }

    public function validate()
    {
        if ($this->user) $this->getRequest()->removeError('verify_code');
        
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}