<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $types = array('selling' => B2bLeadPeer::B2B_LEAD_SELLING, 'buying' => B2bLeadPeer::B2B_LEAD_BUYING);
        $this->type_code = myTools::pick_from_list($this->getRequestParameter('type_code'), array_keys($types), null);
        $this->type_id = in_array($this->type_code, array_keys($types)) ? $types[$this->type_code] : null;
        if (!$this->type_id) $this->redirect('@homepage');

        $wheres = array("EMT_B2B_LEAD.TYPE_ID={$this->type_id} AND (TRUNC(EMT_B2B_LEAD.EXPIRES_AT) >= TRUNC(SYSDATE))");
        
        $this->network_leads = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, true, true, 5, true, null, null, array('wheres' => $wheres),PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD);
        $this->latest = B2bLeadPeer::getLatestLeads($this->type_id, 5);
    }
    
    public function handleError()
    {
    }
    
}
