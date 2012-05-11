<?php

class memberAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_MANAGE_MEMBERS;
    
    public function execute($request)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->membership = $this->member = null;
        
        $p = myTools::unplug($this->getRequestParameter('mid'), false);
        if ($p)
        {
            $this->type_id = $p[0];
            $this->membership = $this->group->getMembership($p[1], $p[0], null, GroupMembershipPeer::STYP_ACTIVE);
            if ($this->membership) $this->member = $this->membership->getMember();
        }
        if (!$this->member) $this->redirect404();
        
        $urltype = array(PrivacyNodeTypePeer::PR_NTYP_USER => 'user', PrivacyNodeTypePeer::PR_NTYP_COMPANY => 'company');
        if ($this->getRequest()->isXmlHttpRequest()) header('Content-type: text/html');
        
        switch ($this->getRequestParameter('act'))
        {
            case "rm" :
                
                if ($this->getRequestParameter('do')=='commit')
                {
                    $this->membership->setStatus(GroupMembershipPeer::STYP_ENDED_BY_TARGET_USER);
                    $this->membership->save();
                    $c = new Criteria();
                    $c->add(PrivacyPreferencePeer::SUBJECT_ID, $this->member->getId());
                    $c->add(PrivacyPreferencePeer::SUBJECT_TYPE_ID, $this->member->getObjectTypeId());
                    $c->add(PrivacyPreferencePeer::OBJECT_ID, $this->group->getId());
                    $c->add(PrivacyPreferencePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
                    PrivacyPreferencePeer::doDelete($c);
                    
                    if ($this->getRequest()->isXmlHttpRequest())
                        return $this->renderPartial('global/ajaxSuccess', array(
                                        'message' => $this->getContext()->getI18N()->__('Member %1 has been successfully removed from group!', array('%1' => $this->member)),
                                        'redir' => "@group-members?action=list&hash={$this->group->getHash()}&typ=".$urltype[$this->member->getObjectTypeId()]
                                    ));
                    else
                        $this->redirect("@group-members?action=list&hash={$this->group->getHash()}");
                }
                else
                {
                    if ($this->getRequest()->isXmlHttpRequest())
                        return $this->renderPartial('confirmMemberRemoval', array('sf_params' => $this->getRequest()->getParameterHolder(), 'group' => $this->group, 'member' => $this->member, 'sf_request' => $this->getRequest()));
                    else
                        $this->setTemplate('confirmMemberRemoval');
                }
                    
                break;
            case "ban" : 
                if ($this->getRequestParameter('do')=='commit')
                {
                    $this->membership->setStatus(GroupMembershipPeer::STYP_BANNED);
                    $this->membership->save();
                    $c = new Criteria();
                    $c->add(PrivacyPreferencePeer::SUBJECT_ID, $this->member->getId());
                    $c->add(PrivacyPreferencePeer::SUBJECT_TYPE_ID, $this->member->getObjectTypeId());
                    $c->add(PrivacyPreferencePeer::OBJECT_ID, $this->group->getId());
                    $c->add(PrivacyPreferencePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
                    PrivacyPreferencePeer::doDelete($c);
                    $np = new PrivacyPreference();
                    $np->setObjectId($this->group->getId());
                    $np->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                    $np->setSubjectId($this->member->getId());
                    $np->setSubjectTypeId($this->member->getObjectTypeId());
                    $np->setActionId(ActionPeer::ACT_JOIN_GROUP);
                    $np->setAllowed(0);
                    $np->save();
                    if ($this->getRequest()->isXmlHttpRequest())
                        return $this->renderPartial('global/ajaxSuccess', array(
                                        'message' => $this->getContext()->getI18N()->__('Member %1 has been successfully banned from group!', array('%1' => $this->member)),
                                        'redir' => "@group-members?action=list&hash={$this->group->getHash()}&typ=".$urltype[$this->member->getObjectTypeId()]
                                    ));
                    else
                        $this->redirect("@group-members?action=list&hash={$this->group->getHash()}&typ=".$urltype[$this->member->getObjectTypeId()]);
                }
                else
                {
                    if ($this->getRequest()->isXmlHttpRequest())
                        return $this->renderPartial('confirmMemberBan', array('sf_params' => $this->getRequest()->getParameterHolder(), 'group' => $this->group, 'member' => $this->member, 'sf_request' => $this->getRequest()));
                    else
                        $this->setTemplate('confirmMemberBan');
                }
                    
                $this->redirect("@group-members?action=list&hash={$this->group->getHash()}");
                break;
        }
    }
    
    public function handleError()
    {
    }
    
}
