<?php

class MessageRecipientPeer extends BaseMessageRecipientPeer
{
    public static function retrieveByMessageId($message_id)
    {
        $sql = "SELECT * FROM ".MessageRecipientPeer::TABLE_NAME."
                WHERE ".MessageRecipientPeer::MESSAGE_ID."=$message_id";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return MessageRecipientPeer::populateObjects($stmt);
    }
    
    /**
     * Selects a collection of MessageRecipient objects pre-filled with their User or Company objects.
     * @param      Criteria  $c
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return     array Array of MessageRecipient objects.
     * @throws     PropelException Any exceptions caught during processing will be
     *       rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinRecipient(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {

    foreach (sfMixer::getCallables('BaseMessageRecipientPeer:doSelectJoin:doSelectJoin') as $callable)
    {
      call_user_func($callable, 'BaseMessageRecipientPeer', $c, $con);
    }


        $c = clone $c;

        // Set the correct dbName if it has not been overridden
        if ($c->getDbName() == Propel::getDefaultDB()) {
            $c->setDbName(self::DATABASE_NAME);
        }

        MessageRecipientPeer::addSelectColumns($c);
        $startcol2 = (MessageRecipientPeer::NUM_COLUMNS - MessageRecipientPeer::NUM_LAZY_LOAD_COLUMNS);
        
        UserPeer::addSelectColumns($c);
        $startcol3 = $startcol2 + (UserPeer::NUM_COLUMNS - UserPeer::NUM_LAZY_LOAD_COLUMNS);
        
        CompanyPeer::addSelectColumns($c);
        $startcol4 = $startcol3 + (CompanyPeer::NUM_COLUMNS - CompanyPeer::NUM_LAZY_LOAD_COLUMNS);
        
        $c->addJoin(array(MessageRecipientPeer::RECIPIENT_ID,), array(UserPeer::ID,), $join_behavior);
        $c->addJoin(array(MessageRecipientPeer::RECIPIENT_ID,), array(CompanyPeer::ID,), $join_behavior);
        $stmt = BasePeer::doSelect($c, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MessageRecipientPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MessageRecipientPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://propel.phpdb.org/trac/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $omClass = MessageRecipientPeer::getOMClass();

                $cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
                $obj1 = new $cls();
                $obj1->hydrate($row);
                MessageRecipientPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded
            
            if ($obj1->getRecipientTypeId()==PrivacyNodeTypePeer::PR_NTYP_USER)
            {
                $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = UserPeer::getInstanceFromPool($key2);
                    if (!$obj2) {
    
                        $omClass = UserPeer::getOMClass();
    
                        $cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
                        $obj2 = new $cls();
                        $obj2->hydrate($row, $startcol2);
                        UserPeer::addInstanceToPool($obj2, $key2);
                    } // if obj2 already loaded
    
                    // Add the $obj1 (MessageRecipient) to $obj2 (User)
                    $obj1->setRecipient($obj2);
                } // if joined row was not null
            }
            elseif ($obj1->getRecipientTypeId()==PrivacyNodeTypePeer::PR_NTYP_COMPANY)
            {
                $key3 = CompanyPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CompanyPeer::getInstanceFromPool($key3);
                    if (!$obj3) {
    
                        $omClass = CompanyPeer::getOMClass();
    
                        $cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
                        $obj3 = new $cls();
                        $obj3->hydrate($row, $startcol3);
                        CompanyPeer::addInstanceToPool($obj3, $key3);
                    } // if obj3 already loaded
    
                    // Add the $obj1 (MessageRecipient) to $obj3 (Company)
                    $obj1->setRecipient($obj3);
    
                } // if joined row was not null
            }
            
            $results[] = $obj1;
        }
        $stmt->closeCursor();
        return $results;
    }
    
}
