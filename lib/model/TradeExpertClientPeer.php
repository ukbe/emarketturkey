<?php

class TradeExpertClientPeer extends BaseTradeExpertClientPeer
{
    CONST TEC_STAT_PENDING               = 1;
    CONST TEC_STAT_APPROVED              = 2;
    CONST TEC_STAT_DECLINED_BY_CLIENT    = 3;
    CONST TEC_STAT_CANCELLED_TRADE_EXPERT= 4;
    CONST TEC_STAT_CANCELLED_CLIENT      = 5;
    CONST TEC_STAT_SUSPENDED             = 6;
    
    public static $statLabels   = array (1 => 'Pending',
                                         2 => 'Approved',
                                         3 => 'Declined by Client',
                                         4 => 'Cancelled by Trade Expert',
                                         5 => 'Cancelled by Client',
                                         );

}
