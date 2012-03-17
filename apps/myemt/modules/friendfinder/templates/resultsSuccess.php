<div class="column span-198">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tools'), 'tools/index') ?></li>
<li><?php echo link_to(__('Networking'), '@network-tools') ?></li>
<li><?php echo link_to(__('Friend Finder'), 'friendfinder/index') ?></li>
<li class="last"><?php echo __('Results') ?></li>
</ol>
<ol class="column" style="margin: 0px;">
</ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-196">
<div class="column span-194 prepend-2">
<h1><?php echo __('Search Results') ?></h1>
<ol class="column span-194">
<li class="column append-2">
<?php echo __('Recent Searches :') ?>
</li>
<?php foreach ($sf_user->getAttribute("recentsearches",array(), "myemt") as $recents): ?>
<li class="column append-2"><?php echo link_to($recents, 'friendfinder/index?fkeyword='.$recents) ?></li>
<?php endforeach ?>
</ol>
<?php echo form_tag('friendfinder/index') ?>
<ol class="column" style="margin: 0;">
<li class="column span-19 right append-1"><?php echo emt_label_for('fkeyword', __('Search for :')) ?></li>
<li class="column span-58"><?php echo input_tag('fkeyword', $sf_params->get('fkeyword'), 'size=40') ?><br /><em><?php echo __('name of a person or company') ?></em></li>
<li class="column span-19"><?php echo submit_tag(__('Search')) ?></li>
</ol>
</form>
</div>
<?php if (isset($user_results) && isset($company_results)): ?>
<div class="column span-184 prepend-3">
<div class="column span-90">
<h3><?php echo __('Users :') ?></h3>
<?php if (count($user_results)): ?>
<ol class="column span-90 network-list">
<?php $fc = 0; ?>
<?php foreach ($user_results as $user_result): ?>
<li class="<?php $fc++; echo (($fc % 3) == 0)?"first ":"" ?>span-46 pad-1">
<?php if ($user->can(ActionPeer::ACT_VIEW_PROFILE, $user_result)): ?>
<?php echo link_to(image_tag($user_result->getProfilePictureUri()), $user_result->getProfileUrl()) ?>
<?php echo link_to($user_result, $user_result->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($user_result->getProfilePictureUri()) ?>
<?php echo $user_result ?><br />
<?php endif ?>
<?php if ($user->can(ActionPeer::ACT_SEND_MESSAGE, $user_result)) echo link_to('Send Message', 'messages/compose', array('query_string' => 'rcpu='.$user_result->getId()."&_ref=$_here", 'class' => 'action')) ?><br />
<?php if (!$user_result->isFriendsWith($user->getId())) echo link_to(__('Add to My Network'), 'network/add', array('query_string' => 'cid='.$user_result->getId())) ?></li>
</li>
<?php endforeach ?> 
</ol>
<?php else: ?>
<?php echo __('No users found with specified name.') ?>
<?php endif ?>
</div>
<div class="column span-90 prepend-4">
<h3><?php echo __('Companies :') ?></h3>
<?php if (count($company_results)): ?>
<ol class="column span-90">
<?php foreach ($company_results as $company_result): ?>
<li class="first column span-16 right append-1"><?php echo link_to(image_tag($company_result->getProfilePictureUri(true), "width=60"), '@company-profile?id='.$company_result->getId()) ?></li>
<li class="column span-69"><?php echo link_to($company_result, '@company-profile?id='.$company_result->getId()) ?></li>
<?php endforeach ?>
</ol>
<?php else: ?>
<?php echo __('No companies found with specified name.') ?>
<?php endif ?>
</div>
</div>
<?php endif ?>
</div>