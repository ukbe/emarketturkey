<?php

class ResumeSchoolPeer extends BaseResumeSchoolPeer
{
    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumeSchool();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumeSchoolPeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumeSchoolPeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!(3 < strlen($params->get("rsme_school")) && 
                  strlen($params->get("rsme_school")) < 250)) $request->setError("rsme_school", 'Please provide a school name.');
        if (!$params->get("rsme_degree_id")) $request->setError("rsme_degree_id", 'Please select education degree.');
        if (!$params->get("rsme_major")) $request->setError("rsme_major", 'Please specify your major.');
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumeSchool)
        {
            $object->setSchool($params->get('rsme_school'));
            $object->setMajor($params->get('rsme_major'));
            $object->setDegreeId($params->get('rsme_degree_id'));
            $object->setPresent($params->get('rsme_present'));
            $object->setDateFrom($params->get('rsme_sdate'));
            $object->setDateTo($params->get('rsme_present') == 1 ? null : $params->get('rsme_edate'));
            $object->setSubjects($params->get('rsme_subjects'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}
