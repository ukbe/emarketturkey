<?php

class TransferOwnershipRequestPeer extends BaseTransferOwnershipRequestPeer
{
    CONST ROLE_CURRENT_OWNER        = 1;
    CONST ROLE_NEW_OWNER            = 2;
    CONST ROLE_ISSUER               = 3;
    
    CONST STAT_INVALID              = 0;
    CONST STAT_PENDING              = 1;
    CONST STAT_CANCELLED_BY_INITER  = 2;
    CONST STAT_CANCELLED_BY_OWNER   = 3;
    CONST STAT_DECLINED_BY_USER     = 4;
    CONST STAT_ACCEPTED_BY_USER     = 5;
    CONST STAT_COMPLETED            = 6;
    
    public static $statLabels   = array (self::STAT_INVALID => 'Invalid',
                                         self::STAT_PENDING => 'Pending',
                                         self::STAT_CANCELLED_BY_INITER => 'Cancelled by Initiator',
                                         self::STAT_CANCELLED_BY_OWNER => 'Cancelled by Owner ',
                                         self::STAT_DECLINED_BY_USER => 'Declined by User',
                                         self::STAT_ACCEPTED_BY_USER => 'Accepted by User',
                                         self::STAT_COMPLETED => 'Completed'
                                     );
}
