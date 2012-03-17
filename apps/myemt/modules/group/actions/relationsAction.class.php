<?php

class relationsAction extends EmtManageGroupAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->act = myTools::pick_from_list($this->getRequestParameter('act'), array('add', 'remove'), null);
        switch ($this->act)
        {
            case 'add':
                $this->typ = myTools::pick_from_list($this->getRequestParameter('typ'), array('parent', 'subsidiary'), null);
                if ($this->typ)
                {
                    $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__($this->typ=='parent' ? 'Add Parent Group | eMarketTurkey' : 'Add Subsidiary Group | eMarketTurkey'));
                }
                $this->group_id = myTools::fixInt($this->getRequestParameter('group_id'));
                
                $this->rlgroup = $this->group_id && !$this->group->getMembership($this->group_id, PrivacyNodeTypePeer::PR_NTYP_GROUP, null, array(GroupMembershipPeer::STYP_PENDING, GroupMembershipPeer::STYP_ACTIVE)) ? GroupPeer::retrieveByPK($this->group_id) : null;

                if ($this->group_id && !$this->rlgroup) $this->group_id = null;
                
                $this->keyword = $this->getRequestParameter('relation_keyword');
                
                $this->setTemplate('addRelation');
                break;
            case 'remove':
                $rarr = array('parent' => RolePeer::RL_GP_PARENT_GROUP, 'subsidiary' => RolePeer::RL_GP_SUBSIDIARY_GROUP);
                $role = myTools::pick_from_list($this->getRequestParameter('rel'), array_keys($rarr));
                $cid = myTools::fixInt($this->getRequestParameter('cid'));
                if ($role || $cid)
                {
                    $relation = $this->group->getMembership($cid, PrivacyNodeTypePeer::PR_NTYP_GROUP, $rarr[$role], array(GroupMembershipPeer::STYP_ACTIVE, GroupMembershipPeer::STYP_PENDING));
                    if ($relation)
                    {

                        $relation->setStatus($this->group->getId() == $relation->getGroupId() ? GroupMembershipPeer::STYP_ENDED_BY_STARTER_USER : GroupMembershipPeer::STYP_ENDED_BY_TARGET_USER);
                        $relation->save();
                    }
                }
                $this->redirect("@group-account?action=relations&hash={$this->group->getHash()}");
                break;
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            if (!$this->group_id && $this->keyword)
            {
                $c = new Criteria();
                $c->add(GroupPeer::NAME, "UPPER(EMT_GROUP.NAME) LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
                $c->setLimit(20);
                $this->groups = GroupPeer::doSelect($c);
                $this->setTemplate('selectRelationGroup');
            }

            $rm = array('parent' => RolePeer::RL_GP_SUBSIDIARY_GROUP,
                        'subsidiary' => RolePeer::RL_GP_PARENT_GROUP);

            if ($this->rlgroup && !$this->group->getMembership($this->rlgroup->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, null, array(GroupMembershipPeer::STYP_PENDING, GroupMembershipPeer::STYP_ACTIVE)))
            {
                $new = new GroupMembership();
                $new->setGroupId($this->group->getId());
                $new->setObjectId($this->rlgroup->getId());
                $new->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                $new->setRoleId($rm[$this->getRequestParameter('typ')]);
                $new->setStatus(GroupMembershipPeer::STYP_PENDING);
                $new->save();
                $this->redirect("@group-account?action=relations&hash={$this->group->getHash()}");
            }
            
        }

        $this->parents = $this->group->getLinkedGroups(null, RolePeer::RL_GP_PARENT_GROUP, array(GroupMembershipPeer::STYP_ACTIVE, GroupMembershipPeer::STYP_PENDING));
        $this->subsidiaries = $this->group->getLinkedGroups(null, RolePeer::RL_GP_SUBSIDIARY_GROUP, array(GroupMembershipPeer::STYP_ACTIVE, GroupMembershipPeer::STYP_PENDING));
    }
    
    public function validate()
    {
        if ($this->getRequestParameter('search_email') == $this->sesuser->getLogin()->getEmail())
            $this->getRequest()->setError('search_email', 'E-mail address is invalid.');
        
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}