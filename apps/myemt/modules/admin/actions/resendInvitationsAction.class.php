<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class resendInvitationsAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $c = new Criteria();
        $c->add(InviteFriendPeer::IS_READ, 1, Criteria::NOT_EQUAL);
        $invites = InviteFriendPeer::doSelect($c);
        $resenttrs = array();
        
        $sql = "select distinct emt_email_transaction.* from emt_invite_friend
inner join emt_email_transaction on emt_invite_friend.email=emt_email_transaction.email
where instr(emt_email_transaction.data, emt_invite_friend.guid)>0
and emt_email_transaction.namespace_id=6 
and emt_invite_friend.is_read != 1";
        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $trs = EmailTransactionPeer::populateObjects($stmt);
        foreach ($trs as $tr)
        {
            $tr->deliver();
            $resenttrs[] = $tr;
        }
        $this->resenttrs = $resenttrs;
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