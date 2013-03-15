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
        sfLoader::loadHelpers('I18N');

        $this->subject_list = array();
        
        foreach (CustomerMessagePeer::$topics as $key => $topic)
        {
            $this->subject_list[$key] = __($topic);
        }
        sort($this->subject_list);

        $this->topic = myTools::pick_from_list($this->getRequestParameter('topic'), array_keys($this->subject_list), null);

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
                ErrorLogPeer::Log(0, 0, null, $e);
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