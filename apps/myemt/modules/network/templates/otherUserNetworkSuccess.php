<div class="column span-198">
<div class="column span-69">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to($user, $user->getProfileUrl()) ?></li>
<li class="last"><?php echo __('Network') ?></li>
</ol>
</div>
<ol class="inline-form">
<li><?php echo __('Search in Network :') ?></li>
<li><?php echo input_auto_complete_tag('network_keyword', '', 'network/search?id='.$user->getId(), array('autocomplete' => 'off'), array('use_style' => false)) ?></li></ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-146 last">
<div class="column span-100 pad-1 append-1">
<?php $i=0 ?>
<?php if ($friends || $company_relations): ?>
<h3><?php echo __('People') ?></h3>
<table cellpadding="0" cellspacing="5" class="network-list span-143">
<?php foreach ($friends as $friend): ?>
<?php $i++ ?>
<?php if ($i % 3 == 1): ?>
<tr>
<?php endif ?>
<td>
<?php if ($user->can(ActionPeer::ACT_VIEW_PROFILE, $friend) || $user->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $friend)): ?>
<?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?>
<?php echo link_to($friend, $friend->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($friend->getProfilePictureUri()) ?>
<?php echo $friend ?><br />
<?php endif ?>
<?php if ($user->can(ActionPeer::ACT_SEND_MESSAGE, $friend) && ($friend->getId()!=$sesuser->getId())) echo link_to('Send Message', 'messages/compose', array('query_string' => 'rcpu='.$friend->getId()."&_ref=$_here", 'class' => 'action')) ?>
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
<?php echo __('%1 does not have any contact, yet. You might want to inform people who knows %1. Go ahead and send them an advise to add %1 to their network.', array('%1' => $user)) ?><br /><br />
<h3><?php echo __('Network Advisor') ?></h3>
<ol>
<li><?php echo link_to('Advisor', 'networkadvisor/index') ?></li>
</ol>
<?php endif ?>
</div>
</div>
<div class="column span-49 pad-1 divbox">
<h3><?php echo __('Networking Tools') ?></h3>
<?php echo link_to(__('Friend Finder'), 'friendfinder/index') ?>
</div>
