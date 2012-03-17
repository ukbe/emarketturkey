<?php

class ResumePeer extends BaseResumePeer
{
    CONST RSM_LIC_POS_CAR       = 0;
    CONST RSM_LIC_POS_MCYCLE    = 1;
    CONST RSM_LIC_POS_BUS       = 2;
    CONST RSM_LIC_POS_TRUCK     = 3;

    CONST RSM_MILS_PERFORMED    = -1;
    CONST RSM_MILS_NOTPERFORMED = 0;
    CONST RSM_MILS_POSTPONED    = -2;
    
    CONST CAREER_BOTH           = 0;
    CONST CAREER_WORK           = 1;
    CONST CAREER_EDUCATION      = 2;
    
    public static $licenseLabels    = array(self::RSM_LIC_POS_CAR     => 'Car',
                                            self::RSM_LIC_POS_MCYCLE  => "Motorcycle",
                                            self::RSM_LIC_POS_BUS     => 'Bus',
                                            self::RSM_LIC_POS_TRUCK   => 'Truck',
                                            );

    public static $mservLabels      = array(self::RSM_MILS_NOTPERFORMED => 'Not Performed',
                                            self::RSM_MILS_PERFORMED    => 'Performed',
                                            self::RSM_MILS_POSTPONED    => 'Postponed',
                                            );

    CONST GENDER_ANY            = 0;
    CONST GENDER_MALE           = 1;
    CONST GENDER_FEMALE         = 2;
    
    public static $genderOptLabels  = array(self::GENDER_ANY          => "Doesn't Matter",
                                            self::GENDER_MALE         => "Male",
                                            self::GENDER_FEMALE       => 'Female',
                                            );

    CONST RSM_CRT_DESIRED_POSITION              = 1;
    CONST RSM_CRT_DESIRED_POSITION_LEVEL        = 2;
    CONST RSM_CRT_CONTACT_COUNTRY               = 3;
    CONST RSM_CRT_CONTACT_STATE                 = 4;
    CONST RSM_CRT_EDU_SCHOOL_NAME               = 5;
    CONST RSM_CRT_EDU_DEGREE                    = 6;
    CONST RSM_CRT_EDU_MAJOR                     = 7;
    CONST RSM_CRT_WORK_COMPANY_NAME             = 8;
    CONST RSM_CRT_WORK_POSITION                 = 9;
    CONST RSM_CRT_WORK_CURRENT                  = 10;
    CONST RSM_CRT_LANG_NAME                     = 11;
    CONST RSM_CRT_LANG_LEVEL_READ               = 12;
    CONST RSM_CRT_LANG_LEVEL_SPEAK              = 13;
    CONST RSM_CRT_LANG_LEVEL_WRITE              = 14;
    CONST RSM_CRT_LANG_NATIVE                   = 15;
    CONST RSM_CRT_SKILL_NAME                    = 16;
    CONST RSM_CRT_SKILL_ID                      = 17;
    CONST RSM_CRT_HAS_PUBLICATION               = 18;
    CONST RSM_CRT_HAS_AWARD                     = 19;
    CONST RSM_CRT_HAS_REFERENCE                 = 20;
    CONST RSM_CRT_MIL_SERVICE_STATUS            = 21;
    CONST RSM_CRT_MIL_POSTPONED_YEAR            = 22;
    CONST RSM_CRT_OTH_SMOKES                    = 23;
    CONST RSM_CRT_OTH_WILL_RELOCATE             = 24;
    CONST RSM_CRT_OTH_WILL_TELECOMMUTE          = 25;
    CONST RSM_CRT_OTH_TRAVEL_PERCENT            = 26;
    CONST RSM_CRT_HAS_LICENSE                   = 27;
    CONST RSM_CRT_OTH_LICENSE_TYPE              = 28;
    CONST RSM_CRT_ORG_NAME                      = 29;
    CONST RSM_CRT_ORG_COUNTRY                   = 30;
    CONST RSM_CRT_ORG_STATE                     = 31;
    CONST RSM_CRT_ORG_LEVEL                     = 32;
    CONST RSM_CRT_APPLIED_JOB_OWNER_ID          = 33;
    CONST RSM_CRT_APPLIED_JOB_OWNER_TYPE_ID     = 34;
    CONST RSM_CRT_DATABASE_PROFILE_ID           = 35;
    CONST RSM_CRT_USER_JOB_TYPE_ID              = 36;
    CONST RSM_CRT_USER_NAME_LASTNAME            = 37;
    CONST RSM_CRT_RESUME_ID                     = 38;
    CONST RSM_CRT_FOLDER_ID                     = 39;
    
    CONST RSM_OPR_EQUAL                         = 1;
    CONST RSM_OPR_LIKE                          = 2;
    CONST RSM_OPR_GREATER_THAN                  = 3;
    CONST RSM_OPR_LESS_THAN                     = 4;
    CONST RSM_OPR_LATER_THAN                    = 5;
    CONST RSM_OPR_BEFORE                        = 6;
    CONST RSM_OPR_INCLUDE                       = 7;
    CONST RSM_OPR_IN                            = 8;
    CONST RSM_OPR_BITSET                        = 9;

    CONST RSM_VAL_TYPE_INT                      = 1;
    CONST RSM_VAL_TYPE_STRING                   = 2;
    CONST RSM_VAL_TYPE_BOOL                     = 3;
    CONST RSM_VAL_TYPE_ID                       = 4;
    CONST RSM_VAL_TYPE_ARRAY                    = 5;
    CONST RSM_VAL_TYPE_BINARY                   = 6;
    
    public static $criteriaMatrix    = array(
                    self::RSM_CRT_DESIRED_POSITION          => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumePeer::JOB_POSITION_ID, 'JOIN' => null),
                    self::RSM_CRT_DESIRED_POSITION_LEVEL    => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumePeer::JOB_POSITION_ID, 'JOIN' => null),
                    self::RSM_CRT_CONTACT_COUNTRY           => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ContactAddressPeer::COUNTRY, 'JOIN' => array(ResumePeer::CONTACT_ID => ContactPeer::ID, ContactPeer::ID => ContactAddressPeer::CONTACT_ID)),
                    self::RSM_CRT_CONTACT_STATE             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ContactAddressPeer::STATE, 'JOIN' => array(ResumePeer::CONTACT_ID => ContactPeer::ID, ContactPeer::ID => ContactAddressPeer::CONTACT_ID)),
                    self::RSM_CRT_EDU_SCHOOL_NAME             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeSchoolPeer::SCHOOL, 'JOIN' => array(ResumePeer::ID => ResumeSchoolPeer::RESUME_ID)),
                    self::RSM_CRT_EDU_DEGREE             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumeSchoolPeer::DEGREE_ID, 'JOIN' => array(ResumePeer::ID => ResumeSchoolPeer::RESUME_ID)),
                    self::RSM_CRT_EDU_MAJOR             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeSchoolPeer::MAJOR, 'JOIN' => array(ResumePeer::ID => ResumeSchoolPeer::RESUME_ID)),
                    self::RSM_CRT_WORK_COMPANY_NAME     => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeWorkPeer::COMPANY_NAME, 'JOIN' => array(ResumePeer::ID => ResumeWorkPeer::RESUME_ID)),
                    self::RSM_CRT_WORK_POSITION             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeWorkPeer::JOB_TITLE, 'JOIN' => array(ResumePeer::ID => ResumeWorkPeer::RESUME_ID)),
                    self::RSM_CRT_WORK_CURRENT             => array('TYPE' => self::RSM_VAL_TYPE_BOOL, 'FIELD_NAME' => ResumeWorkPeer::PRESENT, 'JOIN' => array(ResumePeer::ID => ResumeWorkPeer::RESUME_ID)),
                    self::RSM_CRT_LANG_NAME             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeLanguagePeer::LANGUAGE, 'JOIN' => array(ResumePeer::ID => ResumeLanguagePeer::RESUME_ID)),
                    self::RSM_CRT_LANG_LEVEL_READ           => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumeLanguagePeer::LEVEL_READ, 'JOIN' => array(ResumePeer::ID => ResumeLanguagePeer::RESUME_ID)),
                    self::RSM_CRT_LANG_LEVEL_SPEAK           => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumeLanguagePeer::LEVEL_SPEAK, 'JOIN' => array(ResumePeer::ID => ResumeLanguagePeer::RESUME_ID)),
                    self::RSM_CRT_LANG_LEVEL_WRITE           => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumeLanguagePeer::LEVEL_WRITE, 'JOIN' => array(ResumePeer::ID => ResumeLanguagePeer::RESUME_ID)),
                    self::RSM_CRT_LANG_NATIVE             => array('TYPE' => self::RSM_VAL_TYPE_BOOL, 'FIELD_NAME' => ResumeLanguagePeer::NATIVE, 'JOIN' => array(ResumePeer::ID => ResumeLanguagePeer::RESUME_ID)),
                    self::RSM_CRT_SKILL_NAME             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => SkillInventoryItemI18nPeer::NAME, 'JOIN' => array(ResumePeer::ID => ResumeSkillPeer::RESUME_ID, ResumeSkillPeer::SKILL_ITEM_ID => SkillInventoryItemI18nPeer::ID)),
                    self::RSM_CRT_SKILL_ID             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => SkillInventoryItemPeer::ID, 'JOIN' => array(ResumePeer::ID => ResumeSkillPeer::RESUME_ID, ResumeSkillPeer::SKILL_ITEM_ID => SkillInventoryItemPeer::ID)),
                    self::RSM_CRT_HAS_PUBLICATION             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumePublicationPeer::ID, 'JOIN' => array(ResumePeer::ID => ResumePublicationPeer::RESUME_ID)),
                    self::RSM_CRT_HAS_AWARD             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumeAwardPeer::ID, 'JOIN' => array(ResumePeer::ID => ResumeAwardPeer::RESUME_ID)),
                    self::RSM_CRT_HAS_REFERENCE             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumeReferencePeer::ID, 'JOIN' => array(ResumePeer::ID => ResumeReferencePeer::RESUME_ID)),
                    self::RSM_CRT_MIL_SERVICE_STATUS             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumePeer::MILITARY_SERVICE_STATUS, 'JOIN' => null),
                    self::RSM_CRT_MIL_POSTPONED_YEAR             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumePeer::MILITARY_SERVICE_STATUS, 'JOIN' => null),
                    self::RSM_CRT_OTH_SMOKES             => array('TYPE' => self::RSM_VAL_TYPE_BOOL, 'FIELD_NAME' => ResumePeer::SMOKES, 'JOIN' => null),
                    self::RSM_CRT_OTH_WILL_RELOCATE             => array('TYPE' => self::RSM_VAL_TYPE_BOOL, 'FIELD_NAME' => ResumePeer::WILLING_TO_RELOCATE, 'JOIN' => null),
                    self::RSM_CRT_OTH_WILL_TELECOMMUTE             => array('TYPE' => self::RSM_VAL_TYPE_BOOL, 'FIELD_NAME' => ResumePeer::WILLING_TO_TELECOMMUTE, 'JOIN' => null),
                    self::RSM_CRT_OTH_TRAVEL_PERCENT             => array('TYPE' => self::RSM_VAL_TYPE_ID, 'FIELD_NAME' => ResumePeer::WILLING_TO_TRAVEL, 'JOIN' => null),
                    self::RSM_CRT_HAS_LICENSE             => array('TYPE' => self::RSM_VAL_TYPE_BINARY, 'FIELD_NAME' => ResumePeer::DRIVERS_LICENSE, 'JOIN' => null),
                    self::RSM_CRT_OTH_LICENSE_TYPE             => array('TYPE' => self::RSM_VAL_TYPE_BINARY, 'FIELD_NAME' => ResumePeer::DRIVERS_LICENSE, 'JOIN' => null),
                    self::RSM_CRT_ORG_NAME             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeOrganisationPeer::NAME, 'JOIN' => array(ResumePeer::ID => ResumeOrganisationPeer::RESUME_ID)),
                    self::RSM_CRT_ORG_COUNTRY             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeOrganisationPeer::COUNTRY_CODE, 'JOIN' => array(ResumePeer::ID => ResumeOrganisationPeer::RESUME_ID)),
                    self::RSM_CRT_ORG_STATE             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeOrganisationPeer::STATE, 'JOIN' => array(ResumePeer::ID => ResumeOrganisationPeer::RESUME_ID)),
                    self::RSM_CRT_ORG_LEVEL             => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => ResumeOrganisationPeer::ACTIVITY_ID, 'JOIN' => array(ResumePeer::ID => ResumeOrganisationPeer::RESUME_ID)),
                    self::RSM_CRT_APPLIED_JOB_OWNER_ID  => array('TYPE' => self::RSM_VAL_TYPE_INT, 'FIELD_NAME' => JobPeer::OWNER_ID, 'JOIN' => array(ResumePeer::USER_ID => UserJobPeer::USER_ID, UserJobPeer::JOB_ID => JobPeer::ID)),
                    self::RSM_CRT_APPLIED_JOB_OWNER_TYPE_ID  => array('TYPE' => self::RSM_VAL_TYPE_INT, 'FIELD_NAME' => JobPeer::OWNER_TYPE_ID, 'JOIN' => array(ResumePeer::USER_ID => UserJobPeer::USER_ID, UserJobPeer::JOB_ID => JobPeer::ID)),
                    self::RSM_CRT_DATABASE_PROFILE_ID  => array('TYPE' => self::RSM_VAL_TYPE_INT, 'FIELD_NAME' => DatabaseCVPeer::HR_PROFILE_ID, 'JOIN' => array(ResumePeer::ID => DatabaseCVPeer::RESUME_ID)),
                    self::RSM_CRT_USER_JOB_TYPE_ID  => array('TYPE' => self::RSM_VAL_TYPE_INT, 'FIELD_NAME' => UserJobPeer::TYPE_ID, 'JOIN' => array(ResumePeer::USER_ID => UserJobPeer::USER_ID)),
                    self::RSM_CRT_USER_NAME_LASTNAME  => array('TYPE' => self::RSM_VAL_TYPE_STRING, 'FIELD_NAME' => "EMT_USER.NAME || ' ' || EMT_USER.LASTNAME", 'JOIN' => array(ResumePeer::USER_ID => UserPeer::ID)),
                    self::RSM_CRT_RESUME_ID  => array('TYPE' => self::RSM_VAL_TYPE_INT, 'FIELD_NAME' => ResumePeer::ID, 'JOIN' => null),
                    self::RSM_CRT_FOLDER_ID  => array('TYPE' => self::RSM_VAL_TYPE_INT, 'FIELD_NAME' => ClassifiedResumePeer::FOLDER_ID, 'JOIN' => array(ResumePeer::ID => ClassifiedResumePeer::RESUME_ID)),
              );
    
                                            
    CONST SRC_RETURN_CRITERIA   = 1;
    CONST SRC_RETURN_COUNT      = 2;
    CONST SRC_RETURN_OBJECTS    = 3;
    
    public static function retrieveFromQS($defaultToEmptyObject=false)
    {
        $resume = null;
        $context = sfContext::getInstance();
        
        if (is_numeric($context->getRequest()->getParameter('id')))
        {
            $resume = $context->getUser()->getUser()->getResumeById($context->getRequest()->getParameter('id'));
        }
        elseif ($defaultToEmptyObject)
        {
            $this->resume = new Resume();
            $this->resume->setUser($context->getUser()->getUser());
        }
        return $resume;
    }

    public static function searchByCriteria($rsm_criteria, $return_type = null)
    {
        $c = new Criteria();

        $c->add(self::convertCriteria($rsm_criteria, $c));

        $c->setDistinct();

        switch ($return_type)
        {
            case self::SRC_RETURN_CRITERIA:
                return $c; 
                break;
            case self::SRC_RETURN_COUNT:
                return ResumePeer::doCount($c);
                break;
            case self::SRC_RETURN_OBJECTS:
            default:
                return ResumePeer::doSelect($c);
                break;
        }
    }
    
    public static function searchDB($rsm_criteria, $hr_profile_id, $return_type = null)
    {
        $c = new Criteria();

        $c->add(self::convertCriteria($rsm_criteria, $c));

        $c->setDistinct();
        
        $c->add(ResumePeer::ID, "not exists (select 1 from emt_user_job left join emt_job on emt_user_job.job_id=emt_job.id left join emt_hr_profile on emt_job.owner_id=emt_hr_profile.owner_id where emt_resume.user_id=emt_user_job.user_id and type_id=" . UserJobPeer::UJTYP_APPLIED . " and emt_job.owner_type_id=emt_hr_profile.owner_type_id and emt_hr_profile.id=$hr_profile_id)", Criteria::CUSTOM);
        $c->add(ResumePeer::ID, "not exists (select 1 from emt_database_cv where emt_resume.id=emt_database_cv.resume_id and emt_database_cv.hr_profile_id=$hr_profile_id)", Criteria::CUSTOM);
        // no need to add another criteria for referral signup since its also existed in emt_database_cv table

        switch ($return_type)
        {
            case self::SRC_RETURN_CRITERIA:
                return $c; 
                break;
            case self::SRC_RETURN_COUNT:
                return ResumePeer::doCount($c);
                break;
            case self::SRC_RETURN_OBJECTS:
            default:
                return ResumePeer::doSelect($c);
                break;
        }
    }
    
    public static function convertCriteria($arr, Criteria $c)
    {
        $var = $arr;
        foreach ($var as $key => $v)
        {
            if (is_array($v) && count($v) > 1 && is_array($v[1]))
            {
                $var[$key] = self::convertCriteria($v, $c);
            }
            elseif (is_array($v) && count($v))
            {
                if (!is_null(self::$criteriaMatrix[$v[0]]['JOIN']))
                {
                    foreach (self::$criteriaMatrix[$v[0]]['JOIN'] as $left => $right)
                        $c->addJoin($left, $right, Criteria::LEFT_JOIN);
                }
    
                $val = $v[2];
                $oper = null;
    
                switch ($v[1])
                {
                    case self::RSM_OPR_EQUAL: 
                        $oper = Criteria::EQUAL;
                        break;
                    case self::RSM_OPR_GREATER_THAN:
                        $oper = Criteria::GREATER_THAN;
                        break;
                    case self::RSM_OPR_LESS_THAN:
                        $oper = Criteria::LESS_THAN;
                        break;
                    case self::RSM_OPR_IN:
                        $oper = Criteria::IN;
                        break;
                    case self::RSM_OPR_LIKE:
                        $oper = Criteria::LIKE;
                        break;
                    case self::RSM_OPR_INCLUDE:
                        //$oper = Criteria::;
                        break;
                    case self::RSM_OPR_LATER_THAN:
                        //$oper = Criteria::;
                        break;
                    case self::RSM_OPR_BEFORE:
                        //$oper = Criteria::;
                        break;
                }
    
                $field = self::$criteriaMatrix[$v[0]]['FIELD_NAME'];
                
                $val = ($oper == Criteria::LIKE ? "UPPER($field) LIKE UPPER('%$v[2]%')" : $v[2]);
                $oper = ($oper == Criteria::LIKE ? Criteria::CUSTOM : $oper);
                
                $field = (explode('||', $field));
                $field = $field[0];
                $var[$key] = $c->getNewCriterion($field, $val, $oper);
            }
            if ($key > 1)
            {
                switch ($var[0])
                {
                    case 'AND': $var[1]->addAnd($var[$key]);
                        break;
                    case 'OR': $var[1]->addOr($var[$key]);
                        break;
                }
            }
        }
        return $var[1];
    }

    public static function validateMilServIdList($list)
    {
        $list = !is_array($list) ? array($list) : $list;
        return array_intersect($list, array_keys(self::$mservLabels));
    }

    public static function validateGenderOptIdList($list)
    {
        $list = !is_array($list) ? array($list) : $list;
        return array_intersect($list, array_keys(self::$genderOptLabels));
    }

}
