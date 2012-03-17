<?php

class CompanyPeer extends BaseCompanyPeer
{
    public static function Register(sfParameterHolder $register_prefs, sfParameterHolder $company_prefs)
    {
        $con = Propel::getConnection(self::DATABASE_NAME);
        $company = null;
        
        $users = $register_prefs->get('company_logins');
        
        try
        {
            $con->beginTransaction();

            $company = new Company();
            
            $contact = new Contact();
            $contact->setEmail($users[RolePeer::RL_CM_OWNER]->getLogin()->getEmail());
            $contact->save();
            
            $contact_address = new ContactAddress();
            $contact_address->setContactId($contact->getId());
            $contact_address->setType(ContactPeer::WORK);
            $contact_address->setStreet($register_prefs->get('company_street'));
            $contact_address->setCity($register_prefs->get('company_city'));
            $contact_address->setPostalcode($register_prefs->get('company_postalcode'));
            $contact_address->setState($register_prefs->get('company_state'));
            $contact_address->setCountry($register_prefs->get('company_country'));
            $contact_address->save();
            
            $contact_phone = new ContactPhone();
            $contact_phone->setContactId($contact->getId());
            $contact_phone->setPhone($register_prefs->get('company_phone'));
            $contact_phone->setType(ContactPeer::WORK);
            $contact_phone->save();
            
            $company_profile = new CompanyProfile();
            $company_profile->setContactId($contact->getId());
            $company_profile->setIntroduction($register_prefs->get('company_introduction'));
            $company_profile->setProductService($register_prefs->get('company_products'));
            $company_profile->save();
            
            $company->setName($register_prefs->get('company_name'));
            $company->setSectorId($register_prefs->get('company_industry'));
            $company->setBusinessTypeId($register_prefs->get('company_business_type'));
            $company->setInterestedInHr($register_prefs->get('company_services_hr'));
            $company->setInterestedInB2b($register_prefs->get('company_services_b2b'));
            $company->setMemberType($register_prefs->get('company_b2b_purpose'));
            $company->setProfileId($company_profile->getId());
            $company->save();

            foreach ($users as $role => $role_user)
            {
                if ($role == RolePeer::RL_CM_OWNER) $user = $role_user;

                $company_user = new CompanyUser();
                $company_user->setCompanyId($company->getId());
                $company_user->setObjectId($role_user->getId());
                $company_user->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $company_user->setRoleId($role);
                $company_user->setStatus(CompanyUserPeer::CU_STAT_ACTIVE);
                $company_user->save();
            }

            $con->commit();

            if (isset($company_prefs))
            {
                $company_prefs->set("user_id", $user->getId());
                $company_prefs->set("company_id", $company->getId());
                $company_prefs->set("cname", $company->getName());
                $company_prefs->set("uname", $user->getName());
                $company_prefs->set("ulname", $user->getLastname());
                $company_prefs->set("email", $user->getLogin()->getEmail());
            }
        }
        catch(Exception $e)
        {
            $con->rollBack();
            ErrorLogPeer::Log(array_key_exists(RolePeer::RL_CM_REPRESENTATIVE, $users)?$users[RolePeer::RL_CM_REPRESENTATIVE]:$users[RolePeer::RL_CM_OWNER], RolePeer::RL_CM_ALL, "Error while registering new company: ".$e->getMessage()."; File: ".$e->getFile()."; Line: ".$e->getLine());
            return null;
        }

        return $company;
    }
    
    public static function getFeaturedCompanies($maxnum=20)
    {
        // @todo: Add an algorith to select companies to display on homepage
        $c = new Criteria();
        $c->add(CompanyPeer::AVAILABLE, 1);
        $c->addDescendingOrderByColumn(CompanyPeer::CREATED_AT);
        $c->setLimit($maxnum);
        $c->addJoin(MediaItemPeer::OWNER_ID, CompanyPeer::ID);
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_LOGO);
        $c->add(MediaItemPeer::ID, null, Criteria::ISNOTNULL);
        return CompanyPeer::doSelect($c);
    }
    
    public static function getCompaniesOfCategory($catid)
    {
        $c = new Criteria();
        $c->addJoin(CompanyPeer::ID, ProductPeer::COMPANY_ID, Criteria::LEFT_JOIN);
        $c->add(ProductPeer::CATEGORY_ID, $catid);
        $c->add(CompanyPeer::AVAILABLE, 1);
        $c->setDistinct();
        return CompanyPeer::doSelect($c);
    }
    
    public static function doSelectByUser($user_id, $role_id=null)
    {
        $c = new Criteria();
        $c->addJoin(CompanyPeer::ID, CompanyLoginPeer::COMPANY_ID, Criteria::LEFT_JOIN);
        $c->addJoin(CompanyLoginPeer::LOGIN_ID, LoginPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(LoginPeer::ID, UserPeer::LOGIN_ID, Criteria::LEFT_JOIN);
        $c->add(UserPeer::ID, $user_id);
        if ($role_id) $c->add(CompanyLoginPeer::ROLE_ID, $role_id);
        return CompanyPeer::doSelect($c);
    }
    
    public static function countRecentMembers($from_date)
    {
        $c = new Criteria();
        $c->add(CompanyPeer::CREATED_AT, isset($from_date)?$from_date:time(), Criteria::GREATER_THAN);
        return CompanyPeer::doCount($c);
    }
    
    public static function getCompanyFromHash($hash)
    {
        $id = myTools::flipHash($hash, true, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        return is_numeric($id) && $id!==null && $id!=='' ? self::retrieveByPK($id) : null;
    }

    public static function getCompanyFromUrl(sfParameterHolder $ph)
    {
        if (is_numeric($ph->get('hash')) && $ph->get('hash') < 179)
            $company = self::retrieveByPK($ph->get('hash'));
        else
            $company = self::getCompanyFromHash($ph->get('hash'));
        
        // Check if company is blocked on b2b
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "b2b")
            return $company && !$company->getBlocked() ? $company : null;
        else
            return $company;
    }
}
