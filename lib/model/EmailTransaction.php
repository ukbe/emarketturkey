<?php

class EmailTransaction extends BaseEmailTransaction
{
    public function deliver()
    {
        // skip delivery if environment is not prod(uction)
        if (sfContext::getInstance()->getConfiguration()->getEnvironment() !== 'prod') return;
        
        try
        {
            $namespace = $this->getEmailTransactionNamespace();

            if (in_array($namespace->getId(), array(EmailTransactionNamespacePeer::EML_TR_NS_INVITE_FRIEND, 
                                           EmailTransactionNamespacePeer::EML_TR_NS_INVITE_TO_GROUP
                                       )
                        )
                ){
                // Check if recipient has opted out
                $c = new Criteria();
                $c->add(OptedOutEmailPeer::EMAIL, "UPPER(".OptedOutEmailPeer::EMAIL.") LIKE UPPER('".$this->getEmail()."')", Criteria::CUSTOM);
                $opt = OptedOutEmailPeer::doSelectOne($c);
                
                if ($opt) throw new EmailPrivacyException('Recipient in opted-out email list', 8001);
            }
            
            //Start Swift
            $body = myTools::renderPartial($namespace->getTemplate(), unserialize($this->getClob(EmailTransactionPeer::DATA)));

            $mcon = new Swift_Connection_SMTP($namespace->getSenderSmtpHost(), $namespace->getSenderSmtpPort());
            $mcon->setUsername($namespace->getSenderAccount());
            $mcon->setPassword($namespace->getSenderPassword());
            
            $mailer = new Swift($mcon);
            $message = new Swift_Message();
            $message->setFrom(array($namespace->getSenderEmail() => $namespace->getSenderTitle($this->getPreferredLang())));
            $headers = new Swift_Message_Headers();
            $headers->setCharset('utf-8');
            $headers->setLanguage($this->getPreferredLang());
            $headers->set('X-Mailer', 'PHP');
            $headers->set('X-Priority', '3');
            $headers->set('X-Sender', $namespace->getSenderEmail());
            $headers->set('MIME-Version', '1.0');
            //$headers->set('List-Unsubscribe', '<mailto:unsubscribe@emarketturkey.com>')
            $message->setHeaders($headers);
            $message->setBody($body);
            $message->setContentType($namespace->getContentType());
    
            $message->setSubject($namespace->getSubject($this->getPreferredLang()));
            $mailer->send($message, new Swift_Address($this->getEmail()), new Swift_Address($namespace->getSenderEmail(), $namespace->getSenderTitle($this->getPreferredLang())));
            $this->setStatus(EmailTransactionPeer::EML_TR_STAT_DELIVERED);
        }
        catch(Swift_Exception $e)
        {
            $this->setErrorMessage($e->getMessage());
            $this->setStatus(EmailTransactionPeer::EML_TR_STAT_FAILED);
            $this->save();
            return false;
        }
        catch(EmailPrivacyException $e)
        {
            $this->setErrorMessage($e->getMessage());
            $this->setStatus(EmailTransactionPeer::EML_TR_STAT_FAILED);
            $this->save();
            return false;
        }
        
        $this->save();
    }

    public function getClob($field, $culture = null)
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_EMAIL_TRANSACTION 
                WHERE ID={$this->getId()}";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
}
