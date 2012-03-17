<?php

class LikeItPeer extends BaseLikeItPeer
{
    public static function countLikes($item)
    {
        $c = new Criteria();
        $c->add(LikeItPeer::ITEM_ID, $item->getId());
        $c->add(LikeItPeer::ITEM_TYPE_ID, $item->getObjectTypeId());
        return self::doCount($c);
    }
}
