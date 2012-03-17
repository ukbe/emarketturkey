<?php slot('uppermenu') ?>
<?php if ($sf_params->get('sup') == 'true'): ?>
<?php include_partial('friendfinder/startup-uppermenu') ?>
<?php else: ?>
<?php include_partial('friendfinder/uppermenu') ?>
<?php endif ?>
<?php end_slot() ?>
<div style="margin: 0 auto; width: 731px;">
<div class="rounded-border">
<div>
<div class="pad-1">
<ol class="column prepend-2">
<li class="column span-25"><?php echo image_tag('layout/windows.live.2009.png', 'width=100') ?></li>
<li class="column span-116">
<h1><?php echo __('Windows Live Contacts') ?></h1>
<?php echo __('Search for your friends by using your Windows Live account.<br />This way you will have the opportunity to find your friends who are already member of eMarketTurkey.') ?>
<div class="hrsplit-2"></div>
<?php echo link_to_function(__('Find Friends'), "popit('".url_for('@myemt.consent-import')."');", 'class=command target=_blank') ?>
<div class="hrsplit-2"></div>
<em><?php echo __('Notice: eMarketTurkey WILL NOT be able to access or store your password.') ?></em>
</li>
</ol>
</div>
</div>
</div>
<div class="hrsplit-2"></div>
<div class="rounded-border">
<div>
<div class="pad-1">
<ol class="column prepend-2">
<li class="column span-25"><?php echo image_tag('layout/google-contacts.png', 'width=100 style=margin-top:20px;') ?></li>
<li class="column span-116">
<h1><?php echo __('Google Contacts') ?></h1>
<?php echo __('Search for your friends by using your Google account.<br />This way you will have the opportunity to find your friends who are already member of eMarketTurkey.') ?>
<div class="hrsplit-2"></div>
<?php echo link_to_function(__('Find Friends'), "popit('".url_for('@myemt.google-import')."');", 'class=command target=_blank') ?>
<div class="hrsplit-2"></div>
<em><?php echo __('Notice: eMarketTurkey WILL NOT be able to access or store your password.') ?></em>
</li>
</ol>
</div>
</div>
</div>
<div class="hrsplit-2"></div>
<div class="rounded-border">
<div>
<div class="pad-1">
<ol class="column prepend-2">
<li class="column span-25 center"><?php echo image_tag('layout/invite-friends.png', 'width=80') ?></li>
<li class="column span-116">
<h1><?php echo __('Invite Friends') ?></h1>
<?php echo __('You may invite your friends to join eMarketTurkey by providing their e-mail addresses.') ?>
<div class="hrsplit-2"></div>
<?php echo link_to(__('Continue'), "@invite-friends", 'class=command') ?>
<div class="hrsplit-2"></div>
</li>
</ol>
</div>
</div>
</div>
<?php if ($sf_params->get('sup') == 'true'): ?>
<div class="right">
<div class="hrsplit-1"></div>
<?php echo link_to(__('Skip this step'), '@myemt.homepage', 'class=action') ?>
</div>
<?php endif ?>
</div>
<?php echo javascript_tag("
window.name='emt-base';
function popit(url){window.open(url, 'consent','width=1000, height=570, left='+(screen.width/2-500)+', top='+(screen.height/2-285));}") ?>