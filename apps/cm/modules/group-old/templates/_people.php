<table cellpadding="0" cellspacing="5" class="network-list span-143">
<?php if (count($people)): ?>
<?php $i = 0 ?>
<?php foreach ($people as $person): ?>
<?php $i++ ?>
<?php if ($i % 3 == 1): ?>
<tr>
<?php endif ?>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $person) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $person)): ?>
<?php echo link_to(image_tag($person->getProfilePictureUri()), $person->getProfileUrl()) ?>
<?php echo link_to($person, $person->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($person->getProfilePictureUri()) ?>
<?php echo $person ?><br />
<?php endif ?>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $person)) echo link_to('Send Message', 'messages/compose', array('query_string' => 'rcpu='.$person->getId().'&_ref='.urlencode($sf_request->getUri()), 'class' => 'action')) ?>
</td>
<?php if ($i % 3 == 0): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if ($i % 3 != 0): ?> 
</tr>
<?php endif ?>
<?php else: ?>
<tr><td><?php echo __('There are no members yet.') ?><br /><br />
</td></tr>
<?php endif ?>
</table>