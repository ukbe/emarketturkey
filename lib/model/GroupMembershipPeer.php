<?php

class GroupMembershipPeer extends BaseGroupMembershipPeer
{
    CONST STYP_PENDING                  = 0;
    CONST STYP_ACTIVE                   = 1;
    CONST STYP_BANNED                   = 2;
    CONST STYP_INVITED                  = 3;
    CONST STYP_REJECTED_BY_USER         = 4;
    CONST STYP_REJECTED_BY_MOD          = 5;
    CONST STYP_USER_LEFT                = 6;
    CONST STYP_ENDED_BY_STARTER_USER    = 7;
    CONST STYP_ENDED_BY_TARGET_USER     = 8;
}
