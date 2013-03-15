<?php

class UserPeer extends BaseUserPeer
{
    public static function SignupUser(sfParameterHolder $signup_prefs, sfParameterHolder $user_prefs, $is_verified = false)
    {
        $con = Propel::getConnection(self::DATABASE_NAME);

        try
        {
            $con->beginTransaction();

            $gender = Array('male' => 1, 'female' => 2, '' => null);
            $user = new User();
            $login = new Login();
            $user->setName($signup_prefs->get('name'));
            $user->setLastname($signup_prefs->get('lastname'));
            $user->setGender($gender[$signup_prefs->get('gender')]);
            $user->setBirthdate($signup_prefs->get('bd_year').'-'.
                                $signup_prefs->get('bd_month').'-'.
                                $signup_prefs->get('bd_day'));
            $user->setRegistrationIp(ip2long($signup_prefs->get('registration_ip')));
            $login->setEmail(strtolower($signup_prefs->get('email_first')));
            $password = EmtPasswordUtil::generate();
            $login->setPassword($password);
            $login->setReminderQuestion($signup_prefs->get('reminder_question'));
            $login->setReminderAnswer($signup_prefs->get('reminder_answer'));
            $login->setRoleId(RolePeer::RL_USER);
            if (!$is_verified) $login->setRememberCode(uniqid());
            $login->save();
            $login->reload();
            
            $user->setLogin($login);
            $user->save();
            
            $rol_assign = new RoleAssignment();
            $rol_assign->setLogin($login);
            $rol_assign->setRoleId(RolePeer::RL_USER);
            $rol_assign->save();
            
            if (GlobalConfigPeer::getConfig(GlobalConfigPeer::GC_VERIFY_USER_EMAIL) == true && !$is_verified)
            {
                $block = new Blocklist();
                $block->setLoginId($login->getId());
                $block->setBlockreasonId(BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED);
                $block->setActive(1);
                $block->save();
            }
            
            $con->commit();

            $user_prefs->set("user_id", $user->getId());
            $user_prefs->set("uname", $user->getName());
            $user_prefs->set("ulname", $user->getLastname());
            $user_prefs->set("email", $login->getEmail());
            $user_prefs->set("password", $password);
            if (!$is_verified)
            {
                $user_prefs->set("is_verified", false);
                $user_prefs->set("ui", $login->getRememberCode());
                $user_prefs->set("em", $login->getGuid());
            }
            else
            {
                $user_prefs->set("is_verified", true);
            }
            
        }
        catch(Exception $e)
        {
            $con->rollBack();
            ErrorLogPeer::Log(0, RolePeer::RL_USER, "Error while sign up process.", $e);
                        
            return null;
        }

        return $user;
    }
    
    public static function retrieveByUsername($username)
    {
        $c = new Criteria();
        $c->addJoin(LoginPeer::ID, UserPeer::LOGIN_ID, Criteria::LEFT_JOIN);
        $c->add(LoginPeer::USERNAME, $username);
        return UserPeer::doSelectOne($c);
    }
    
    public static function selectRecentMembers($from_date)
    {
        $c = new Criteria();
        $c->add(UserPeer::CREATED_AT, isset($from_date)?$from_date:time(), Criteria::GREATER_THAN);
        return UserPeer::doSelect($c);
    }
    
    public static function countRecentMembers($from_date)
    {
        $c = new Criteria();
        $c->add(UserPeer::CREATED_AT, isset($from_date)?$from_date:time(), Criteria::GREATER_THAN);
        return UserPeer::doCount($c);
    }  

    public static function getUserFromUrl(sfParameterHolder $ph)
    {
        if ($ph->get('hash'))
        {
            if (is_numeric($ph->get('hash')) && $ph->get('hash') < 179)
                $user = self::retrieveByPK($ph->get('hash'));
            else
                $user = self::getUserFromHash($ph->get('hash'));
        }
        elseif ($ph->get('username'))
        {
            $user = UserPeer::retrieveByUsername($ph->get('username'));
        }

        // Check if user is blocked
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "cm")
            return $user && !$user->isBlocked() ? $user : null;
        else
            return $user && !$user->isBlocked() ? $user : null;
    }

    public static function getUserFromHash($hash)
    {
        $id = myTools::flipHash($hash, true, PrivacyNodeTypePeer::PR_NTYP_USER);
        return is_numeric($id) && $id!==null && $id!=='' ? self::retrieveByPK($id) : null;
    }

}
