<?php

class latestAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.leads-action?".http_build_query($params), 301);

        $types = array('selling' => B2bLeadPeer::B2B_LEAD_SELLING, 'buying' => B2bLeadPeer::B2B_LEAD_BUYING);
        $this->type_code = myTools::pick_from_list($this->getRequestParameter('type_code'), array_keys($types), null);
        $this->type_id = in_array($this->type_code, array_keys($types)) ? $types[$this->type_code] : null;
        if (!$this->type_id) $this->redirect('@homepage');
        $this->isbuying = $this->type_id == B2bLeadPeer::B2B_LEAD_BUYING;
        $this->latest = B2bLeadPeer::getLatestLeads($this->type_id, 20);
    }

    public function handleError()
    {
    }

}
