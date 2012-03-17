<?php
$tr = EmailTransactionPeer::retrieveByPK(16);
$tr->deliver();
?>