<div class="column span-198">
<div class="hrsplit-2"></div>
<h2><?php echo $group->getName() ?></h2>
<h3><?php echo __('Thank you for starting a new group!') ?></h3>
<div class="span-194 pad-2">
<?php echo __('We have sent you an e-mail including access information for your group. If you can\'t find the message in your inbox you might need to check your spam folder.<br />In case of any account problems, please write to %1.', array('%1' => '<a href="mailto:support@emarketturkey.com">support@emarketturkey.com</a>')) ?>
</div>
</div>
<div class="hrsplit-2"></div>
<div class="column span-193 prepend-5">
<div class="column span-60">
<?php echo image_tag('layout/background/individuals.'.$sf_user->getCulture().'.png') ?>
<ol class="welcome-actions">
<li><?php echo link_to(__('Setup your Profile'), '@myemt.profile') ?></li>
<li><?php echo link_to(__('Create CV'), '@hr-cv-create') ?></li>
<li><?php echo __('Search for Jobs') ?></li>
<li><?php echo __('Start your Blog') ?></li>
<li><?php echo link_to(__('Search for your Friends'), '@myemt.friendfinder') ?></li>
<li><?php echo __('Invite your Friends') ?></li>
<li><?php echo __('Leave a message to Public Bulletin') ?></li>
<li><?php echo __('Become an EMT Contributor and get paid') ?></li>
</ol>
</div>
<div class="column span-60">
<?php echo image_tag('layout/background/suppliers.'.$sf_user->getCulture().'.png') ?>
<ol class="welcome-actions">
<li><?php echo link_to(__('Promote your Products or Services'), '@myemt.manage-products') ?></li>
<li><?php echo link_to(__('Search for Products from other Companies'), '@b2b.homepage') ?></li>
<li><?php echo __('Maintain a customized Company Website') ?></li>
<li><?php echo link_to(__('Post Jobs'), 'jobs/new') ?></li>
<li><?php echo __('Get your information translated online') ?></li>
<li><?php echo __('Query prices on Transportation Directory') ?></li>
<li><?php echo __('Get EMT Localized Representatives work for you') ?></li>
</ol>
</div>
<div class="column span-60">
<?php echo image_tag('layout/background/business.organisations.'.$sf_user->getCulture().'.png') ?>
<ol class="welcome-actions">
<li><?php echo __('Invite your Members') ?></li>
<li><?php echo __('Promote your Events online on EMT Calender') ?></li>
<li><?php echo __('Contact other Business Organisations worldwide') ?></li>
</ol>
</div>
<div class="hrsplit-1"></div>
</div>