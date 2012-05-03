<?php

class GroupPeer extends BaseGroupPeer
{
    CONST GRP_PBL_CLOSED        = 1;
    CONST GRP_PBL_OPEN          = 2;

    public static $pblLabels    = array(self::GRP_PBL_CLOSED    => 'Closed Group',
                                        self::GRP_PBL_OPEN      => 'Open Group',
                                    );
    
    CONST GRP_STAT_ONLINE           = 1;
    CONST GRP_STAT_IS_UNPUBLISHED   = 2;
    CONST GRP_STAT_IS_SUSPENDED     = 3;
    CONST GRP_STAT_OWNER_BLOCKED    = 4;

    public static $statMessages     = array(self::GRP_STAT_ONLINE           => 'Group profile is online',
                                            self::GRP_STAT_IS_UNPUBLISHED   => 'Group profile is unpublished by account owner',
                                            self::GRP_STAT_IS_SUSPENDED     => 'Group profile is suspended',
                                            self::GRP_STAT_OWNER_BLOCKED    => 'Group account owner is blocked',
                                        );

    public static function Create(sfParameterHolder $register_prefs, sfParameterHolder $group_prefs)
    {
        $con = Propel::getConnection(self::DATABASE_NAME);
        $group = null;
        
        $users = $register_prefs->get('group_logins');
        $user = $users[RolePeer::RL_GP_OWNER];
        
        try
        {
            $con->beginTransaction();

            $group = new Group();

            if ($register_prefs->get('group_type_id') != GroupTypePeer::GRTYP_ONLINE)
            {
                $contact = new Contact();
                $contact->setEmail($register_prefs->get('group_email'));
                $contact->save();
                
                $contact_address = new ContactAddress();
                $contact_address->setContactId($contact->getId());
                $contact_address->setType(ContactPeer::WORK);
                $contact_address->setStreet($register_prefs->get('group_street'));
                $contact_address->setCity($register_prefs->get('group_city'));
                $contact_address->setPostalcode($register_prefs->get('group_postalcode'));
                $contact_address->setState($register_prefs->get('group_state'));
                $contact_address->setCountry($register_prefs->get('group_country'));
                $contact_address->save();
                
                $contact_phone = new ContactPhone();
                $contact_phone->setContactId($contact->getId());
                $contact_phone->setPhone($register_prefs->get('group_phone'));
                $contact_phone->setType(ContactPeer::WORK);
                $contact_phone->save();
            }
            
            $group->setName($register_prefs->get('group_name_0'));
            $group->setTypeId($register_prefs->get('group_type_id'));
            //$group->setInterestAreaId($register_prefs->get('group_interest_area_id'));
            if ($group->getTypeId()!=GroupTypePeer::GRTYP_ONLINE)
            {
                $group->setFoundedIn($register_prefs->get('group_founded_in'));
                $group->setAbbreviation($register_prefs->get('group_abbreviation_0'));
                $group->setContactId($contact->getId());
            }
            else
            {
                $group->setFoundedIn('');
                $group->setAbbreviation('');
                if ($contact = $group->getContact()) $contact->delete();
                $group->setContactId(null);
            }
            $group->setUrl($register_prefs->get('group_url'));
            $group->setPublicity($register_prefs->get('group_publicity'));
            
            $pr = $register_prefs->get('group_lang');

            if (is_array($pr))
            {
                foreach($pr as $key => $lang)
                {echo "$key = $lang";
                    $ci18n = $group->getCurrentGroupI18n($lang);
                    $ci18n->setDisplayName($register_prefs->get("group_name_$key"));
                    $ci18n->setAbbreviation($register_prefs->get("group_abbreviation_$key"));
                    $ci18n->setIntroduction($register_prefs->get("group_introduction_$key"));
                    $ci18n->setMemberProfile($register_prefs->get("group_member_profile_$key"));
                    $ci18n->setEventsIntroduction($register_prefs->get("group_events_$key"));
                    $ci18n->save();
                }
            }

            $group->save();
            /*   Geçici olarak sakla, daha sonra silinecek
            $pref = new PrivacyPreference();
            $pref->setObjectId($group->getId());
            $pref->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
            $pref->setRoleOnObject(RolePeer::RL_ALL);
            $pref->setActionId(ActionPeer::ACT_JOIN_GROUP);
            $pref->setAllowed($register_prefs->get('group_member_confirm')==1?1:0);
            $pref->setSubjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
            $pref->save();
            $pref = new PrivacyPreference();
            $pref->setObjectId($group->getId());
            $pref->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
            $pref->setRoleOnObject(RolePeer::RL_ALL);
            $pref->setActionId(ActionPeer::ACT_JOIN_GROUP);
            $pref->setAllowed($register_prefs->get('group_member_confirm')==1?1:0);
            $pref->setSubjectTypeId(PrivacyNodeTypePeer::PR_NTYP_COMPANY);
            $pref->save();
            $pref = new PrivacyPreference();
            $pref->setObjectId($group->getId());
            $pref->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
            $pref->setRoleOnObject(RolePeer::RL_ALL);
            $pref->setActionId(ActionPeer::ACT_JOIN_GROUP);
            $pref->setAllowed($register_prefs->get('group_member_confirm')==1?1:0);
            $pref->setSubjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
            $pref->save();
            */

            foreach ($users as $role => $role_user)
            {
                $group_login = new GroupMembership();
                $group_login->setGroupId($group->getId());
                $group_login->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $group_login->setObjectId($role_user->getId());
                $group_login->setRoleId($role);
                $group_login->setStatus(GroupMembershipPeer::STYP_ACTIVE);
                $group_login->save();
            }
            
            $con->commit();

            $group_prefs->set("user_id", $user->getId());
            $group_prefs->set("group_id", $group->getId());
            $group_prefs->set("gname", $group->getName());
            $group_prefs->set("uname", $user->getName());
            $group_prefs->set("ulname", $user->getLastname());
            $group_prefs->set("email", $user->getLogin()->getEmail());
            
        }
        catch(Exception $e)
        {
            $con->rollBack();
            ErrorLogPeer::Log($users[RolePeer::RL_GP_OWNER]->getId(), RolePeer::RL_GP_OWNER, "Error while registering new group: ".$e->getMessage()."; File: ".$e->getFile()."; Line: ".$e->getLine());
            return null;
        }

        return $group;
    }
    
    public static function retrieveByStrippedName($sname)
    {
        $c = new Criteria();
        $c->add(GroupPeer::STRIPPED_NAME, $sname);
        $groups = self::doSelect($c);
        if (is_array($groups) && count($groups))
        {
            return $groups[0];
        }
        else
        {
            return null;
        }
    }
    
    public static function getGroupFromHash($hash)
    {
        $id = myTools::flipHash($hash, true, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        return is_numeric($id) && $id!==null && $id!=='' ? self::retrieveByPK($id) : null;
    }

    public static function getGroupFromUrl(sfParameterHolder $ph)
    {
        $group = self::getGroupFromHash($ph->get('hash'));

        // Check if group is blocked on cm
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "cm")
            return $group && !$group->getBlocked() ? $group : null;
        else
            return $group;
    }

    public static function getFeaturedGroups($type_class = null, $random = true, $ipp = 20, $page = null, $return_pager = false)
    {
        // ignoring random option if using paging for the query
        if (isset($page)) $random = false;

        $con = Propel::getConnection();

        $sql = "
            SELECT * FROM EMT_GROUP
            WHERE EMT_GROUP.IS_FEATURED=1
            ". ($random ? "order by dbms_random.value" : "");

        $pager = new EmtPager('Group', $ipp);
        $pager->setSql($sql);
        $pager->setPage($page);
        $pager->setBindColumns(array('relevel' => UserPeer::NUM_COLUMNS + 1));
        $pager->init();
        return $return_pager ? $pager : $pager->getResults();
    }

}
