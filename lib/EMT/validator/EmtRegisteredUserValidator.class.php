<?php

class EmtRegisteredUserValidator extends sfValidator
{    
    public function initialize($context, $parameters = null)
    {
        // initialize parent
        parent::initialize($context);
        
        // set defaults
        $this->setParameter('absent_error', 'This user is not registered, yet.');
        
        $this->getParameterHolder()->add($parameters);

        return true;
    }

    public function execute(&$value, &$error)
    {
        $className  = $this->getParameter('class').'Peer';
        $columnName = call_user_func(array($className, 'translateFieldName'), $this->getParameter('column'), BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
    
        $c = new Criteria();
        $c->add($columnName, $value);
        $object = call_user_func(array($className, 'doSelectOne'), $c);
        
        // user exists?
        if ($object)
        {
            return true;
        }
        $error = $this->getParameter('absent_error');
        return false;
    }
}