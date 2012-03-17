<?php

class rightsAction extends EmtManageGroupAction
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

        $actfilter = array(ActionPeer::ACT_START_DISCUSSION,
                           ActionPeer::ACT_PARTICIPATE_DISCUSSION,
                           ActionPeer::ACT_UPLOAD_PHOTO,
                           ActionPeer::ACT_COMMENT_ASSET,
                           ActionPeer::ACT_BROWSE_MEMBERS
                        );
        $this->prefs = PrivacyPreferencePeer::retrieveByRelation($this->member->getId(), $this->member->getObjectTypeId(), $this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, $actfilter, true);

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            foreach ($this->prefs as $pref)
            switch ($this->getRequestParameter("pa_opt_{$pref->getActionId()}"))
            {
                case 1: if ($pref->getSubjectId() == $this->member->getId() && $pref->getSubjectTypeId() == $this->member->getObjectTypeId()) 
                            $pref->delete();
                    break;
                case 2: if ($pref->getSubjectId() == $this->member->getId() && $pref->getSubjectTypeId() == $this->member->getObjectTypeId())
                        {
                            $pref->setAllowed(1);
                            $pref->save();
                        }
                        else
                        {
                            $np = new PrivacyPreference();
                            $np->setSubjectId($this->member->getId());
                            $np->setSubjectTypeId($this->member->getObjectTypeId());
                            $np->setAllowed(1);
                            $np->setActionId($pref->getActionId());
                            $np->setObjectId($this->group->getId());
                            $np->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                            $np->save();
                        }
                    break;
                case 3: if ($pref->getSubjectId() == $this->member->getId() && $pref->getSubjectTypeId() == $this->member->getObjectTypeId())
                        {
                            $pref->setAllowed(0);
                            $pref->save();
                        }
                        else
                        {
                            $np = new PrivacyPreference();
                            $np->setSubjectId($this->member->getId());
                            $np->setSubjectTypeId($this->member->getObjectTypeId());
                            $np->setAllowed(0);
                            $np->setActionId($pref->getActionId());
                            $np->setObjectId($this->group->getId());
                            $np->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                            $np->save();
                        }
                    break;
            }
            
            $this->redirect($this->getRequest()->getUri());
        }
    }
    
    public function handleError()
    {
    }
    
}
