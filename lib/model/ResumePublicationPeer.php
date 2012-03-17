<?php

class ResumePublicationPeer extends BaseResumePublicationPeer
{
    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumePublication();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumePublicationPeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumePublicationPeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!(3 < strlen($params->get("rsmp_subject")) && 
                  strlen($params->get("rsmp_subject")) < 250)) $this->getRequest()->setError("rsmp_subject", 'Please provide a publication subject.');
        if (20 < strlen($params->get("rsmp_isbn"))) $this->getRequest()->setError("rsmp_isbn", 'ISBN should be maximum 20 characters long.');
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumePublication)
        {
            $object->setSubject($params->get('rsmp_subject'));
            $object->setPublisher($params->get('rsmp_publisher'));
            $object->setEdition($params->get('rsmp_edition'));
            $object->setCoAuthors($params->get('rsmp_coauthors'));
            $object->setBinding($params->get('rsmp_binding'));
            $object->setIsbn($params->get('rsmp_isbn'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}
