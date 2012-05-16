<?php

class CompanyHRProfile extends BaseCompanyHRProfile
{
    public function getHRLogo()
    {
        if ($this->getCompany())
            $logo = $this->getCompany()->getMediaItems(MediaItemPeer::MI_TYP_HR_LOGO);
        else
            $logo = null;
        return count($logo)?$logo[0]:null;
    }
}
