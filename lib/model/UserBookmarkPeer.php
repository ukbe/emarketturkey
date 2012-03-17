<?php

class UserBookmarkPeer extends BaseUserBookmarkPeer
{
    CONST BMTYP_FAVOURITE           = 1;
    CONST BMTYP_BANNED              = 2;
    
    public static $typeNames    = array (1 => 'Favourite',
                                         2 => 'Banned'
                                         );
}
