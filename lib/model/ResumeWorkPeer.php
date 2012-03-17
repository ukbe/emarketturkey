<?php

class ResumeWorkPeer extends BaseResumeWorkPeer
{
    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumeWork();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumeWorkPeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumeWorkPeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!(3 < strlen($params->get("rsmw_company_name")) && 
                  strlen($params->get("rsmw_company_name")) < 250)) $request->setError("rsmw_company_name", 'Please provide a company name.');
        if (!(3 < strlen($params->get("rsmw_job_title")) && 
                  strlen($params->get("rsmw_job_title")) < 250)) $request->setError("rsmw_job_title", 'Please provide your job title in this company.');
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumeWork)
        {
            $object->setCompanyName($params->get('rsmw_company_name'));
            $object->setJobTitle($params->get('rsmw_job_title'));
            $object->setListedOnEmt($params->get('rsmw_listed_on_emt'));
            $object->setCompanyId(1);
            $object->setPresent($params->get('rsmw_present'));
            $object->setDateFrom($params->get('rsmw_sdate'));
            $object->setDateTo($params->get('rsmw_edate'));
            $object->setProjects($params->get('rsmw_projects'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}
