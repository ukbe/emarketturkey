<?php

class CustomerMessagePeer extends BaseCustomerMessagePeer
{
    CONST CM_TPC_TECHNICAL_SUPPORT      = 1;
    CONST CM_TPC_FEATURE_REQUEST        = 2;
    CONST CM_TPC_BUG_REPORT             = 3;
    CONST CM_TPC_FINANCIAL_INQUIRY      = 4;
    CONST CM_TPC_OTHER                  = 5;
    CONST CM_TPC_WORK_FOR_EMT           = 6;
    CONST CM_TPC_CORPORATE_COMM         = 7;
    
    public static $topics = Array('1' => 'Technical Support',
                                  '2' => 'Feature Request',
                                  '3' => 'Bug Report',
                                  '4' => 'Financial Inquiry',
                                  '5' => 'Other',
                                  '6' => 'Work for eMarketTurkey',
                                  '7' => 'Corporate Communications',
                            );
}
