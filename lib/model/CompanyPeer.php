<?php

class CompanyPeer extends BaseCompanyPeer
{

    CONST CMP_STAT_ONLINE           = 1;
    CONST CMP_STAT_IS_UNPUBLISHED   = 2;
    CONST CMP_STAT_IS_SUSPENDED     = 3;
    CONST CMP_STAT_OWNER_BLOCKED    = 4;

    public static $statMessages     = array(self::CMP_STAT_ONLINE           => 'Company profile is online',
                                            self::CMP_STAT_IS_UNPUBLISHED   => 'Company profile is unpublished by account owner',
                                            self::CMP_STAT_IS_SUSPENDED     => 'Company profile is suspended',
                                            self::CMP_STAT_OWNER_BLOCKED    => 'Company account owner is blocked',
                                        );

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
            $company_profile->save();

            $pr = $register_prefs->get('company_lang');

            if (is_array($pr))
            {
                foreach($pr as $key => $lang)
                {
                    if ($company_profile->hasLsiIn($lang))
                    {
                        $sql = "UPDATE EMT_COMPANY_PROFILE_I18N 
                    			SET id=:id, culture=:culture, introduction=:introduction, product_service=:product_service
                    			WHERE id=:id AND culture=:culture
                        ";
                    }
                    else
                    {
                        $sql = "INSERT INTO EMT_COMPANY_PROFILE_I18N 
                                (id, culture, introduction, product_service)
                                VALUES
                                (:id, :culture, :introduction, :product_service)
                        ";
                    }
                    
                    $stmt = $con->prepare($sql);
                    $c_intro = $register_prefs->get("company_introduction_$key");
                    $c_prod = $register_prefs->get("company_productservice_$key");
                    $stmt->bindValue(':id', $company_profile->getId());
                    $stmt->bindValue(':culture', $lang);
                    $stmt->bindParam(':introduction', $c_intro, PDO::PARAM_STR, strlen($c_intro));
                    $stmt->bindParam(':product_service', $c_prod, PDO::PARAM_STR, strlen($c_prod));
                    $stmt->execute();
                }
            }

            $company->setName($register_prefs->get('company_name'));
            $company->setSectorId($register_prefs->get('company_industry'));
            $company->setBusinessTypeId($register_prefs->get('company_business_type'));
            //$company->setInterestedInHr($register_prefs->get('company_services_hr'));
            //$company->setInterestedInB2b($register_prefs->get('company_services_b2b'));
            //$company->setMemberType($register_prefs->get('company_b2b_purpose'));
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
            echo $e->getMessage();
            $con->rollBack();
            $owner = array_key_exists(RolePeer::RL_CM_REPRESENTATIVE, $users)?$users[RolePeer::RL_CM_REPRESENTATIVE]:$users[RolePeer::RL_CM_OWNER];
            ErrorLogPeer::Log($owner->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, "Error while registering new company.", $e);
            return null;
        }

        return $company;
    }
    
    public static function getFeaturedCompanies($maxnum=20, $random = true)
    {
        // @todo: Add an algorithm to select companies to display on homepage
        $sql = "
            SELECT EMT_COMPANY.* FROM EMT_COMPANY
            LEFT JOIN EMT_COMPANY_USER_VIEW ON EMT_COMPANY.ID=EMT_COMPANY_USER_VIEW.COMPANY_ID AND EMT_COMPANY_USER_VIEW.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_COMPANY_USER_VIEW.ROLE_ID=".RolePeer::RL_CM_OWNER."
            LEFT JOIN EMT_USER ON EMT_COMPANY_USER_VIEW.OBJECT_ID=EMT_USER.ID
            LEFT JOIN EMT_PREMIUM_ACCOUNT ON EMT_COMPANY.ID=EMT_PREMIUM_ACCOUNT.OWNER_ID AND EMT_PREMIUM_ACCOUNT.OWNER_TYPE_ID=2
            WHERE EMT_COMPANY.AVAILABLE=1 AND EMT_COMPANY.BLOCKED=0 AND EMT_COMPANY.IS_FEATURED=1
                AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE LOGIN_ID=EMT_USER.LOGIN_ID AND ACTIVE=1)
                AND EXISTS (SELECT 1 FROM EMT_MEDIA_ITEM WHERE OWNER_ID=EMT_COMPANY.ID AND OWNER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY." AND ITEM_TYPE_ID=".MediaItemPeer::MI_TYP_LOGO.")
                AND EMT_PREMIUM_ACCOUNT.STATUS_ID=".PremiumAccountPeer::PA_STAT_ACTIVE."
            ORDER BY EMT_PREMIUM_ACCOUNT.CREATED_AT DESC
        ";
        
        if ($maxnum) $sql = "SELECT * FROM ($sql) WHERE ROWNUM <= $maxnum";
        
        if ($random) $sql = "SELECT * FROM ($sql) ORDER BY dbms_random.value";
        
        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return CompanyPeer::populateObjects($stmt);
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
        $company = self::getCompanyFromHash($ph->get('hash'));
        
        // Check if company is blocked on b2b
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "b2b")
            return $company && !$company->getBlocked() ? $company : null;
        else
            return $company;
    }
}
