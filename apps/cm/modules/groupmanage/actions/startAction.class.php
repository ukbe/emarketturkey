<?php

class startAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->contact_cities = array();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $register_fields = $this->getRequest()->getParameterHolder();
            $register_fields->set('group_logins', array(RolePeer::RL_GP_OWNER => $this->sesuser));
            $data = new sfParameterHolder();
            
            $con = Propel::getConnection(GroupPeer::DATABASE_NAME);
            try
            {
                $con->beginTransaction();
                
                $this->group = GroupPeer::Create($register_fields, &$data);
                
                $con->commit();
            }
            catch (Exception $e)
            {
                $con->rollBack();
                ErrorLogPeer::Log($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, 'Error while creating new group: '.$e->getMessage().'; File: '.$e->getFile().'; Line: '.$e->getLine());
                $this->errorWhileSaving = true;
            }
            
            if ($this->group instanceof Group)
            {
                ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_CREATE_GROUP, null, $this->group);
                $vars = array();
                $vars['email'] = $data->get('email');
                $vars['user_id'] = $data->get('user_id');
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_CREATE_GROUP;

                try
                {
                    EmailTransactionPeer::CreateTransaction($vars);
                }
                catch (Exception $e)
                {
                    ErrorLogPeer::Log($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, 'Error while creating email transaction for new group: '.$e->getMessage().'; File: '.$e->getFile().'; Line: '.$e->getLine());
                }
            }
            else
            {
                $this->errorWhileSaving = true;
                return sfView::SUCCESS;
            }

            $this->redirect('@group-manage?action=manage&stripped_name='.$this->group->getStrippedName());
        }
        elseif ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->getRequestParameter('group_country'));
        }
        else
        {
            return sfView::SUCCESS;
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
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