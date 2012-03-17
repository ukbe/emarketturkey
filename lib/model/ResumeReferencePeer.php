<?php

class ResumeReferencePeer extends BaseResumeReferencePeer
{
    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumeReference();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumeReferencePeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumeReferencePeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!(3 < strlen($params->get("rsmr_name")) && 
                  strlen($params->get("rsmr_name")) < 100)) $request->setError("rsmr_name", 'Please provide the name and lastname of your reference person.');
        if (100 < strlen($params->get("rsmr_job_title"))) $request->setError("rsmr_job_title", "Reference person's job title should be maximum 100 characters long.");
        if (300 < strlen($params->get("rsmr_company_name"))) $request->setError("rsmr_company_name", "Reference person's company name should be maximum 300 characters long.");
        if (50 < strlen($params->get("rsmr_phone_number"))) $request->setError("rsmr_phone_number", "Reference person's phone number should be maximum 50 characters long.");
        if (50 < strlen($params->get("rsmr_email"))) $request->setError("rsmr_email", "Reference person's email address should be maximum 50 characters long.");
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumeReference)
        {
            $object->setName($params->get('rsmr_name'));
            $object->setCompanyName($params->get('rsmr_company_name'));
            $object->setJobTitle($params->get('rsmr_job_title'));
            $object->setEmail($params->get('rsmr_email'));
            $object->setPhoneNumber($params->get('rsmr_phone_number'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}
