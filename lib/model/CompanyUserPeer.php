<?php

class CompanyUserPeer extends BaseCompanyUserPeer
{
    CONST CU_STAT_PENDING_CONFIRMATION      = 1;
    CONST CU_STAT_ACTIVE                    = 2;
    CONST CU_STAT_REJECTED                  = 3;
    CONST CU_STAT_ENDED_BY_TARGET_USER      = 4;
    CONST CU_STAT_ENDED_BY_STARTER_USER     = 5;
}
