<?php

class saveCompanyAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        
        if (!$this->user) $this->redirect404();
        
        $this->user_company = $this->user->isOwnerOf($this->company);
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')) && $this->hasRequestParameter('type') && in_array($this->getRequestParameter('type'), array_keys(UserCompanyPeer::$typeNames)))
        {
            $this->company = CompanyPeer::retrieveByPK($this->getRequestParameter('id'));
            if (!$this->company || !$this->company->getAvailable() || $this->company->getId()==$this->user_company->getId()) $this->redirect404();
            
            if (!$this->user->getUserCompany($this->company->getId(), UserBookmarkPeer::BMTYP_FAVOURITE))
            {
                $uj = new UserCompany();
                $uj->setUserId($this->user->getId());
                $uj->setCompanyId($this->company->getId());
                $uj->setTypeId(UserBookmarkPeer::BMTYP_FAVOURITE);
                $uj->save();
            }
            $this->redirect('@favourite-companies');
        }
        else
        {
            $this->redirect('mycareer/index');
        }
    }
    
    public function handleError()
    {
    }
    
}