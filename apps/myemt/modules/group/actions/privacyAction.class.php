<?php

class privacyAction extends EmtManageGroupAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        $this->view_filter = array(
            ActionPeer::ACT_VIEW_PERSONAL_INFO,
            ActionPeer::ACT_VIEW_CONTACT_INFO,
            ActionPeer::ACT_VIEW_PHOTOS,
            ActionPeer::ACT_VIEW_FRIENDS,
            ActionPeer::ACT_VIEW_GROUPS,
            ActionPeer::ACT_VIEW_COMPANIES,
            ActionPeer::ACT_VIEW_CAREER
        );
        
        $this->intr_filter = array(
            ActionPeer::ACT_ADD_TO_NETWORK,
            ActionPeer::ACT_COMMENT_ASSET,
            ActionPeer::ACT_INVITE_TO_EVENT,
            ActionPeer::ACT_INVITE_TO_GROUP,
            ActionPeer::ACT_POST_WALL,
            ActionPeer::ACT_SEND_MESSAGE
        );
        
        $this->nodes = array(
            RolePeer::RL_ALL            => array(RolePeer::RL_ALL, RolePeer::RL_NETWORK_MEMBER, RolePeer::RL_SELF),
            RolePeer::RL_NETWORK_MEMBER => array(RolePeer::RL_NETWORK_MEMBER, RolePeer::RL_SELF)
        );
    }
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->prmatrix = $this->sesuser->getPrivacyPrefMatrix();

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $open_profile = $this->getRequestParameter("profile_status");
                
                foreach ($this->view_filter as $viewact)
                {
                    if (!isset($this->prmatrix[$viewact]) || $this->prmatrix[$viewact]['X'] != $this->getRequestParameter("pa_opt_$viewact"))
                    {
                        $pref_all = $this->sesuser->getPrivacyPref(isset($this->prmatrix[$viewact][RolePeer::RL_ALL]) ? $this->prmatrix[$viewact][RolePeer::RL_ALL]['ID'] : null, true, $viewact, RolePeer::RL_ALL);
                        $pref_network = $this->sesuser->getPrivacyPref(isset($this->prmatrix[$viewact][RolePeer::RL_NETWORK_MEMBER]) ? $this->prmatrix[$viewact][RolePeer::RL_NETWORK_MEMBER]['ID'] : null, true, $viewact, RolePeer::RL_NETWORK_MEMBER);

                        $set = $this->getRequestParameter("pa_opt_$viewact");
                        $pref_all->setAllowed($open_profile && $set == RolePeer::RL_ALL ? 1 : 0);
                        $pref_all->save();
                        $pref_network->setAllowed($open_profile && ($set == RolePeer::RL_ALL || $set == RolePeer::RL_NETWORK_MEMBER) ? 1 : 0);
                        $pref_network->save();
                    }
                }
                
                foreach ($this->intr_filter as $intract)
                {
                    if (!isset($this->prmatrix[$intract]) || $this->prmatrix[$intract]['X'] != $this->getRequestParameter("pa_opt_$intract"))
                    {
                        $pref_all = $this->sesuser->getPrivacyPref(isset($this->prmatrix[$intract][RolePeer::RL_ALL]) ? $this->prmatrix[$intract][RolePeer::RL_ALL]['ID'] : null, true, $intract, RolePeer::RL_ALL);
                        $pref_network = $this->sesuser->getPrivacyPref(isset($this->prmatrix[$intract][RolePeer::RL_NETWORK_MEMBER]) ? $this->prmatrix[$intract][RolePeer::RL_NETWORK_MEMBER]['ID'] : null, true, $intract, RolePeer::RL_NETWORK_MEMBER);
                        
                        $set = $this->getRequestParameter("pa_opt_$intract");
                        $pref_all->setAllowed($set == RolePeer::RL_ALL ? 1 : 0);
                        $pref_all->save();
                        $pref_network->setAllowed(($set == RolePeer::RL_ALL || $set == RolePeer::RL_NETWORK_MEMBER) ? 1 : 0);
                        $pref_network->save();
                    }
                }
                $this->prmatrix = $this->sesuser->getPrivacyPrefMatrix();
            }
        }
    }

    public function validate()
    {
        $vwr = $this->getRequestParameter('profile_viewer');
        if (!in_array($vwr, array_keys($this->nodes))) {
            $this->getRequest()->setError('profile_viewer', 'Invalid Selection');
        }
        else
        {
            foreach ($this->view_filter as $act_id)
            {
                if (!in_array($this->getRequestParameter("pa_opt_$act_id"), $this->nodes[$vwr]))
                    $this->getRequest()->setError("pa_opt_$act_id", 'Invalid Selection');
            }
        }
        
        foreach ($this->intr_filter as $act_id)
        {
            if (!in_array($this->getRequestParameter("pa_opt_$act_id"), $this->nodes[RolePeer::RL_ALL]))
                $this->getRequest()->setError("pa_opt_$act_id", 'Invalid Selection');
        }
        
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}