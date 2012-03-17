<?php

class ResumeLanguagePeer extends BaseResumeLanguagePeer
{
    CONST RLANG_LEVEL_LOW           = 1;
    CONST RLANG_LEVEL_FAIR          = 2;
    CONST RLANG_LEVEL_FLUENT        = 3;
    
    public static $langLevels       = array(self::RLANG_LEVEL_LOW     => 'Low',
                                            self::RLANG_LEVEL_FAIR    => 'Fair',
                                            self::RLANG_LEVEL_FLUENT  => 'Fluent',
                                            0                         => 'Not Specified'
                                        );

    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new ResumeLanguage();
            if ($owner instanceof Resume) $obj->setResumeId($owner->getId());
        }
        else
        {
            $c = new Criteria();
            $c->add(ResumeLanguagePeer::ID, $params->get('id'));
            if ($owner) $c->add(ResumeLanguagePeer::RESUME_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $owner = null, $request)
    {
        if (!$params->get("rsml_language$id")) $request->setError("rsml_language", 'Please select a language.');
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null)
    {
        if ($object instanceof ResumeLanguage)
        {
            $object->setLanguage($params->get('rsml_language'));
            $object->setNative($params->get('rsml_native'));
            $object->setLevelRead($params->get('rsml_native') ? self::RLANG_LEVEL_FLUENT : $params->get('rsml_read_level'));
            $object->setLevelWrite($params->get('rsml_native') ? self::RLANG_LEVEL_FLUENT : $params->get('rsml_write_level'));
            $object->setLevelSpeak($params->get('rsml_native') ? self::RLANG_LEVEL_FLUENT : $params->get('rsml_speak_level'));
            if ($owner instanceof Resume) $object->setResumeId($owner->getId());
            $object->save();
            return $object;
        }
        return null;
    }
}