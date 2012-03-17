<?php

class ResumeAwardPeer extends BaseResumeAwardPeer
{
    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumeAward();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumeAwardPeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumeAwardPeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!(3 < strlen($params->get("rsma_title")) && 
                  strlen($params->get("rsma_title")) < 200)) $request->setError("rsma_title", 'Please provide the name of award/honor.');
        if (100 < strlen($params->get("rsma_issuer"))) $request->setError("rsma_issuer", 'Issuer should be maximum 100 characters long.');
        if (2000 < strlen($params->get("rsma_notes"))) $request->setError("rsma_notes", 'Notes should be maximum 100 characters long.');
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumeAward)
        {
            $object->setTitle($params->get('rsma_title'));
            $object->setIssuer($params->get('rsma_issuer'));
            $object->setYear($params->get('rsma_year'));
            $object->setNotes($params->get('rsma_notes'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}