<?php

class userAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->usr = UserPeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->usr)
            {
                $this->redirect404();
            }
            $this->manages = $this->usr->getCompanyRelations();
            
            
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('User Details: %1', array('%1' => $this->usr)));
        }
        else
        {
            $this->redirect404();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->redirect('admin/users');
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(BusinessTypePeer::DATABASE_NAME);

            if ($this->getRequestParameter('act') == 'kill')
            {
                try
                {
                    $con->beginTransaction();
                    $sql = "
                        delete from emt_blocklist
                        where exists (
                            select 1 from emt_user 
                            where emt_user.login_id=emt_blocklist.login_id and emt_user.id={$this->usr->getId()}
                        )
                    ";
                    $con->query($sql);

                    $sql = "
                        insert into emt_blocklist
                        select emt_blocklist_seq.nextval, login_id, null, 3, sysdate, sysdate, 1 from emt_user 
                        where emt_user.id={$this->usr->getId()}
                    ";
                    $con->query($sql);

                    $sql = "
                        update emt_message_recipient set deleted_at=sysdate
                        where exists (
                            select 1 from emt_message 
                            where emt_message.id=emt_message_recipient.message_id 
                            and emt_message.sender_id={$this->usr->getId()}
                        )
                    ";
                    $con->query($sql);

                    $sql = "
                        update emt_relation set status=6 where user_id={$this->usr->getId()}
                    ";
                    $con->query($sql);

                    $con->commit();
                }
                catch(Exception $e)
                {
                    $this->killError = 'Error occured during kill user.';
                    $con->rollBack();
                }
            }

            if ($this->getRequestParameter('act') == 'block')
            {
                try
                {
                    $con->beginTransaction();
                    $sql = "
                        insert into emt_blocklist
                        select emt_blocklist_seq.nextval, login_id, null, 3, sysdate, sysdate, 1 from emt_user 
                        where emt_user.id={$this->usr->getId()}
                    ";
                    $stmt = $con->prepare($sql);
                    $stmt->execute();

                    $con->commit();
                }
                catch(Exception $e)
                {
                    $this->blockError = 'Error occured during block user.';
                    $con->rollBack();
                }
            }

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
