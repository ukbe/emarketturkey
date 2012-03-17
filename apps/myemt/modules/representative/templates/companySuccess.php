<?php use_helper('Date', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Corporate Representative'), 'representative/index') ?></li>
<li><?php echo link_to(__('Portfolio Companies'), 'representative/companies') ?></li>
<li class="last"><?php echo $company ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo $sf_context->getActionName()=='companies'?' class="selected"':'' ?>><?php echo link_to(__('List Companies'), 'admin/companies') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/company-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<style>
table.monocolor th
{
    width: 190px; background: #CECECE;
}
table.monocolor td
{
    background: #F0F0F0;
}
</style>
<h3><?php echo __('General Information') ?></h3>
<table class="monocolor" width="95%" cellpadding="4" cellspacing="0">
<tr><th><b><?php echo __('Registered At') ?></b></th><td>
<?php echo format_datetime($company->getCreatedAt('U')) ?></td></tr>
</table>
<div class="hrsplit-2"></div>
<h3><?php echo __('Contact Information') ?></h3>
<?php $contact = $company->getContact() ?>
<?php if (!$contact): ?>
<?php echo __('Contact information is missing.') ?>
<?php else: ?>
<table class="monocolor" width="95%" cellpadding="4" cellspacing="0">
<?php $work_address = $contact->getWorkAddress() ?>
<?php if($work_address): ?>
<tr><th><b><?php echo __('Street Address') ?></b></th><td>
<?php echo $work_address->getStreet() ?></td></tr>
<tr><th><b><?php echo __('Postal Code') ?></b></th><td><?php echo $work_address->getPostalCode() ?></td></tr>
<tr><th><b><?php echo __('City/State') ?></b></th><td ><?php echo ($work_address->getCountry()!=''?image_tag('layout/flag/'.$contact->getWorkAddress()->getCountry().'.png', 'style=height:13px;margin-bottom:0px;margin-right:5px; title='.format_country($work_address->getCountry())):'').' '.$work_address->getCity(). " / " .$work_address->getGeonameCity() ?></td></tr>
<?php endif ?>
<tr><th><b><?php echo __('Phone Number') ?></b></th><td ><?php echo $contact->getWorkPhone()?$contact->getWorkPhone()->getPhone():__('Not Available') ?></td></tr>
</table>
<?php endif ?>
<div class="hrsplit-2"></div>
<h3><?php echo __('Related Users') ?></h3>
<?php $company_logins = $company->getCompanyLogins() ?>
<table class="monocolor" width="95%" cellpadding="4" cellspacing="0">
<?php foreach ($company_logins as $company_login): ?>
<tr><th><b><?php echo __('User') ?></b></th><td>
<?php echo $company_login->getLogin()->getUser() ?> - <?php echo $company_login->getRole()->getName() ?></td></tr>
<?php endforeach ?>
</table>
<div class="hrsplit-2"></div>
<h3><?php echo __('Products Overview') ?></h3>
<table class="monocolor" width="95%" cellpadding="4" cellspacing="0">
<tr><th><b><?php echo __('Total Products') ?></b></th><td><?php echo $company->countProducts() ?></td></tr>
</table>
<div class="hrsplit-2"></div>
<h3><?php echo __('Event History') ?></h3>
<?php $events=$company->getActions() ?>
<table width="95%" cellpadding="4" cellspacing="0" style="background: #F0F0F0">
<?php if (count($events)): ?>
<?php foreach ($events as $event): ?>
<tr><td><b><?php echo $event->getAction()->getName() ?></b></td><td><?php echo format_datetime($event->getCreatedAt('U')) ?></td></tr>
<?php endforeach ?>
<?php else: ?>
<tr><td><?php echo __('No event records found.') ?></td></tr>
<?php endif ?>
</table>
</fieldset>