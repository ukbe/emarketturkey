<?php

class connectedAction extends EmtAction
{
    public function execute($request)
    {
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        
        $joins = $wheres = array();
        
        if ($this->country)
        {
            $joins[] = "INNER JOIN EMT_USER_PROFILE ON EMT_USER.PROFILE_ID=EMT_USER_PROFILE.ID";
            $joins[] = "INNER JOIN EMT_CONTACT ON EMT_USER_PROFILE.CONTACT_ID=EMT_CONTACT.ID";
            $joins[] = "INNER JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID";
        }
        
        if ($this->keyword)
        {
            $wheres[] = "
                (
                    " . myTools::NLSFunc(UserPeer::NAME . ' ' . UserPeer::LASTNAME, 'UPPER') . " LIKE ".myTools::NLSFunc("'%{$this->keyword}%'", 'UPPER')."
                 OR " . myTools::NLSFunc(UserPeer::DISPLAY_NAME, 'UPPER') . " LIKE ".myTools::NLSFunc("'%{$this->keyword}%'", 'UPPER')."
                )
            ";
        }

        if ($this->country)
        {
            $wheres[] = "UPPER(EMT_CONTACT_ADDRESS.COUNTRY)='{$this->country}'";
        }

        $this->pager = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_USER, null, true, true, null, false, 20, $this->page, array('joins' => $joins, 'wheres' => $wheres));
    }

    public function handleError()
    {
    }

}
