<div class="column span-198">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tools'), 'tools/index') ?></li>
<li><?php echo link_to(__('Networking'), '@network-tools') ?></li>
<li class="last"><?php echo __('Friend Finder') ?></li>
</ol>
<ol class="column" style="margin: 0px;">
</ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-156 last">
<div class="column span-100 prepend-20">
<h1><?php echo __('Friend Finder') ?></h1>
<?php echo __('Friend Finder helps you find your friends and partner companies in eMarketTurkey.') ?>
<div class="hrsplit-3"></div>
<?php echo form_tag('friendfinder/index') ?>
<ol class="column span-90">
<li class="column span-19 right append-1"><?php echo emt_label_for('fkeyword', __('Search for')) ?></li>
<li class="column span-70"><?php echo input_tag('fkeyword', $sf_params->get('fkeyword'), 'size=40') ?><br /><em><?php echo __('name of a person or company') ?></em></li>
<li class="column span-19 append-1"></li>
<li class="column span-70"><?php echo submit_tag(__('Search')) ?></li>
</ol>
</form>
<?php if (count($sf_user->getAttribute("recentsearches",array(), "myemt"))): ?>
<ol class="column span-90">
<li class="column append-2">
<?php echo __('Recent Searches :') ?>
</li>
<?php foreach ($sf_user->getAttribute("recentsearches",array(), "myemt") as $recents): ?>
<li class="column append-2"><?php echo link_to($recents, 'friendfinder/index?fkeyword='.$recents) ?></li>
<?php endforeach ?>
</ol>
<?php endif ?>
</div>
<?php if (isset($user_results) && isset($company_results)): ?>
<div class="column span-184 prepend-3">
<div class="column span-90">
<h3><?php echo __('User Results :') ?></h3>
<?php if (count($user_results)): ?>
<ol class="column span-90">
<?php foreach ($user_results as $user_result): ?>
<li class="first column span-20 right append-1"><?php echo link_to(image_tag($user_result->getUserProfile()?$user_result->getUserProfile()->getPicture():"nopic", "height=60"), '@user-profile?id='.$user_result->getId()) ?></li>
<li class="column span-69"><?php echo link_to($user_result, '@user-profile?id='.$user_result->getId()) ?></li>
<?php endforeach ?>
</ol>
<?php else: ?>
<?php echo __('No users found with specified name.') ?>
<?php endif ?>
</div>
<div class="column span-90 prepend-4">
<h3><?php echo __('Company Results :') ?></h3>
<?php if (count($company_results)): ?>
<ol class="column span-90">
<?php foreach ($company_results as $company_result): ?>
<li class="first column span-20 right append-1"><?php echo link_to(image_tag($company_result->getCompanyProfile()?$company_result->getCompanyProfile()->getPicture():"nopic", "height=60"), '@company-profile?id='.$company_result->getId()) ?></li>
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