<?php
$criterias = array('wheres' => array("(P_OBJECT_TYPE_ID={$target->getObjectTypeId()} AND P_OBJECT_ID={$target->getId()})"));
$connections = $subject->getConnections(null, null, true, false, null, false, null, null, $criterias);
?>
<?php if (count($connections)): ?>
<ul class="conn-how">
<li class="conn-source t_bold"><?php echo $subject ?></li>
<?php if (count($connections) == 1 &&  $connections[0]['DEPTH'] == 1): ?>
<li><?php echo $target ?><span class="relevel margin-l2"><?php echo $connections[0]['DEPTH'] ?></span></li>
<?php else: ?>
<?php foreach ($connections as $con): ?>
<?php if ($con['P_OBJECT_TYPE_ID'] != $con['CONNECT_OBJECT_TYPE_ID'] && $con['P_OBJECT_ID'] == $con['CONNECT_OBJECT_ID']): ?>
<?php $object = PrivacyNodeTypePeer::retrieveObject($con['CONNECT_OBJECT_ID'], $con['CONNECT_OBJECT_TYPE_ID']) ?>
<li><?php echo link_to($object, $object->getProfileUrl()) ?></li>
<?php else: ?>
<?php $object = PrivacyNodeTypePeer::retrieveObject($con['CONNECT_OBJECT_ID'], $con['CONNECT_OBJECT_TYPE_ID']) ?>
<li><?php echo link_to($object, $object->getProfileUrl()) ?></li>
<?php endif ?>
<?php endforeach ?>
<?php if ($con): ?>
<?php if ($con['DEPTH'] > 2): ?>
<li class="conn-target"><?php echo __('?') ?></li>
<?php endif ?>
<li class="conn-target t_bold"><?php echo $target ?><span class="relevel margin-l2"><?php echo $con['DEPTH'] ?></span></li>
<?php endif ?>
<?php endif ?>
</ul>
<?php else: ?>
<?php echo __('You are not connected to %1', array('%1' => $target)) ?>
<p class="margin-t1 t_grey t_smaller"><?php echo __('If you are already a member, %1 to see your connection with %2.<br />Not a member? Click %3 to start connecting to others.', array('%1' => link_to(__('Login'), '@myemt.login', array('query_string' => "_ref=".urlencode($sf_request->getUri()), 'class' => 'loginlink inherit-font bluelink hover')), '%2' => $target, '%3' => link_to(__('Sign Up'), "@myemt.signup?_ref=".urlencode($sf_request->getUri()), 'class=inherit-font bluelink hover'))) ?></p>
<?php endif ?>