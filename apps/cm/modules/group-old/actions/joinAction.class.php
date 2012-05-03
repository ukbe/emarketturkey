<?php

class joinAction extends EmtGroupAction
{
    
    protected $actionID = ActionPeer::ACT_JOIN_GROUP;
    
    public function execute($request)
    {
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->redirect404();
        }
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if (!$this->group || $this->getRequestParameter('token') != sha1(base64_encode($this->group.session_id()))) $this->redirect404();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('mod') == 'commit' && is_numeric($this->getRequestParameter('item')) && is_numeric($this->getRequestParameter('itemtyp')) && (($this->getRequestParameter('itemtyp')!=PrivacyNodeTypePeer::PR_NTYP_USER && $this->sesuser->isOwnerOf($this->getRequestParameter('item'), $this->getRequestParameter('itemtyp'))) || $this->getRequestParameter('itemtyp')==PrivacyNodeTypePeer::PR_NTYP_USER))
            {
                $item = PrivacyNodeTypePeer::retrieveObject($this->getRequestParameter('item'), $this->getRequestParameter('itemtyp'));
                if ($item->can(ActionPeer::ACT_JOIN_GROUP, $this->group))
                {
                    $membership = $item->isMemberOf($this->group->getId());
                    if (!$membership)
                    {
                        $membership = $this->group->addMember($this->getRequestParameter('item'), $this->getRequestParameter('itemtyp'));
                    }
                    $this->membership = $membership;

                    return $this->renderPartial('joined_group', array('group' => $this->group, 'row' => $this->getRequestParameter('row'), 'membership' => $membership, 'item' => $item, 'sesuser' => $this->sesuser));
                }
                return $this->renderText($this->getContext()->getI18N()->__('ACTION DISALLOWED'));
            }
            elseif ($this->getRequestParameter('mod') == 'leave' && is_numeric($this->getRequestParameter('member')))
            {
                $membership = GroupMembershipPeer::retrieveByPK($this->getRequestParameter('member'));
                if ($membership)
                {
                    $item = PrivacyNodeTypePeer::retrieveObject($membership->getObjectId(), $membership->getObjectTypeId());
                    $type_id = $membership->getObjectTypeId();
                    if ($item && $item->can(ActionPeer::ACT_LEAVE_GROUP, $this->group) &&  
                            (
                                ($type_id != PrivacyNodeTypePeer::PR_NTYP_USER && $this->sesuser->isOwnerOf($item->getId()))
                                ||
                                $type_id == PrivacyNodeTypePeer::PR_NTYP_USER
                            )
                        )
                    {
                        $membership->setStatus(GroupMembershipPeer::STYP_USER_LEFT);
                        $membership->save();
                        $this->membership = $membership;
                        
                        ActionLogPeer::Log($item, ActionPeer::ACT_LEAVE_GROUP, $this->group);
                        
                        return $this->renderPartial('left_group', array('group' => $this->group, 'row' => $this->getRequestParameter('row'), 'membership' => $membership));
                    }
                }
            }
            elseif ($this->getRequestParameter('mod') == 'chanrel' && is_numeric($this->getRequestParameter('member')) && is_numeric($this->getRequestParameter('relation')))
            {
                $membership = GroupMembershipPeer::retrieveByPK($this->getRequestParameter('member'));
                if ($membership)
                {
                    $item = PrivacyNodeTypePeer::retrieveObject($membership->getObjectId(), $membership->getObjectTypeId());
                    $type_id = $membership->getObjectTypeId();
                    $allowedrelations = RoleMatrixPeer::getRelationsAvailableTo($type_id, PrivacyNodeTypePeer::PR_NTYP_GROUP);
                    if ($item && array_search($this->getRequestParameter('relation'), $allowedrelations)!==null)
                    {
                        $rel = new RelationUpdate();
                        $rel->setObjectId($this->group->getId());
                        $rel->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                        $rel->setSubjectId($item->getId());
                        $rel->setSubjectTypeId($type_id);
                        $rel->setRoleId($this->getRequestParameter('relation'));
                        $rel->save();
                        
                        return $this->renderPartial('updated_relation', array('group' => $this->group, 'relation' => $rel, 'membership' => $membership));
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