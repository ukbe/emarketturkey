<?php

class TranslatorPeer extends BaseTranslatorPeer
{
    CONST TR_STAT_PENDING           = 1;
    CONST TR_STAT_APPROVED          = 2;
    CONST TR_STAT_DECLINED          = 3;
    CONST TR_STAT_SUSPENDED         = 4;
    
    public static $statLabels   = array (1 => 'Pending',
                                         2 => 'Approved',
                                         3 => 'Declined',
                                         4 => 'Suspended',
                                         );

    public static function retrieveAccountFor($status = null, $holder, $holder_type_id = null)
    {
        if (is_object($holder))
        {
            $holder_id = $holder->getId();
            $holder_type_id = $holder->getObjectTypeId();
        }
        else
        {
            $holder_id = $holder;
        }
        $c = new Criteria();
        $c->add(TranslatorPeer::HOLDER_ID, $holder_id);
        $c->add(TranslatorPeer::HOLDER_TYPE_ID, $holder_type_id);
        if ($status) $c->add(TranslatorPeer::STATUS, $status, is_array($status) ? Criteria::IN : Criteria::EQUAL);
        return TranslatorPeer::doSelectOne($c);
    }

}
