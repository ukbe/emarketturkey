<?php

class ResumeOrganisationPeer extends BaseResumeOrganisationPeer
{
    CONST ORG_ATT_TYP_MEMBER        = 1;
    CONST ORG_ATT_TYP_ADMIN         = 2;

    public static $typeAttNames    = array (null => 'Not Specified',
                                            1    => 'Member Level',
                                            2    => 'Administrator Level'
                                            );

    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumeOrganisation();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumeOrganisationPeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumeOrganisationPeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!(3 < strlen($params->get("rsmo_name")) && 
                  strlen($params->get("rsmo_name")) < 300)) $request->setError("rsmo_name", 'Please provide an organisation name.');
        if (50 < strlen($params->get("rsmo_city"))) $request->setError("rsmo_city", "Organisation's city name should be maximum 50 characters long.");
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumeOrganisation)
        {
            $object->setName($params->get('rsmo_name'));
            $object->setListedOnEmt($params->get('rsmo_listed_on_emt'));
            $object->setOrganisationId($params->get('rsmo_organisation_id'));
            $object->setCountryCode($params->get('rsmo_country_code'));
            $object->setCity($params->get('rsmo_city'));
            $object->setState($params->get('rsmo_state'));
            $object->setJoinedInYear($params->get('rsmo_joined_in_year'));
            $object->setActivityId($params->get('rsmo_activity_id'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}
