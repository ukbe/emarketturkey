<?php if (count($friends)): ?>
<table cellpadding="0" cellspacing="5" class="network-list span-143">
<?php $i = 0 ?>
<?php foreach ($friends as $friend): ?>
<?php $i++ ?>
<?php if ($i % 3 == 1): ?>
<tr>
<?php endif ?>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $friend) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $friend)): ?>
<?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?>
<?php echo link_to($friend, $friend->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($friend->getProfilePictureUri()) ?>
<?php echo $friend ?><br />
<?php endif ?>
<?php $token = sha1(base64_encode($friend.session_id())); ?>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $friend)) echo link_to(__('Send Message'), '@myemt.compose-message', array('query_string' => 'rcpu='.$friend->getId().'&rcptyp='.PrivacyNodeTypePeer::PR_NTYP_USER.'&_ref='.urlencode($sf_request->getUri()), 'class' => 'action')) ?><br />
<?php if (!$sesuser->isFriendsWith($friend->getId()) && $sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $friend)) echo link_to(__('Add as Friend'), "@user-action?action=add&id={$friend->getId()}", array('query_string' => "token=$token&width=560&height=220&_ref=".urlencode($sf_request->getUri()), 'class' => 'thickbox', 'title' => __('Add as Friend'))) ?>
</td>
<?php if ($i % 3 == 0): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if ($i % 3 != 0): ?> 
</tr>
<?php endif ?>
</table>
<?php else: ?>
<div class="traditional">
<h3><?php echo __('No existing friends in network.') ?></h3>
</div>
<?php endif ?>