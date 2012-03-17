<?php

class ResumeCoursePeer extends BaseResumeCoursePeer
{
    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumeCourse();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumeCoursePeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumeCoursePeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!(3 < strlen($params->get("rsmc_name")) && 
                  strlen($params->get("rsmc_name")) < 250)) $request->setError("rsmc_name", 'Please provide a course or certification title.');
        if (!(3 < strlen($params->get("rsmc_institute")) && 
                  strlen($params->get("rsmc_institute")) < 250)) $request->setError("rsmc_institute", 'Please provide Institute name for course/certification.');
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumeCourse)
        {
            $object->setName($params->get('rsmc_name'));
            $object->setInstitute($params->get('rsmc_institute'));
            $object->setDaily($params->get('rsmc_daily'));
            $object->setDateFrom($params->get('rsmc_sdate'));
            $object->setDateTo($params->get('rsmc_daily') == 1 ? $params->get('rsmc_sdate') : $params->get('rsmc_edate'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}
