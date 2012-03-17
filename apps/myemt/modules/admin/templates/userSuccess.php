 <?php use_helper('Date', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Administrator'), 'admin/index') ?></li>
<li><?php echo link_to(__('Users'), 'admin/users') ?></li>
<li class="last"><?php echo $usr ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo $sf_context->getActionName()=='users'?' class="selected"':'' ?>><?php echo link_to(__('List Users'), 'admin/users') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/user-details.'.$sf_user->getCulture().'.png') ?>
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
<tr><th><b><?php echo __('Member Since') ?></b></th><td>
<?php echo format_datetime($usr->getCreatedAt('U')) ?></td></tr>
<tr><th><b><?php echo __('Registration IP') ?></b></th><td>
<?php $cip = long2ip($usr->getRegistrationIp()) ?>
<?php echo $cip ?></td></tr>
<tr><th><b><?php echo __('Country Code') ?></b></th><td>
<?php echo geoip_country_code3_by_name($cip) ?></td></tr>
<tr><th><b><?php echo __('Country Name') ?></b></th><td>
<?php echo geoip_country_name_by_name($cip) ?></td></tr>
<tr><th><b><?php echo __('Connection Type') ?></b></th><td>
<?php echo geoip_id_by_name($cip) ?></td></tr>
<tr><th><b><?php echo __('ISP') ?></b></th><td>
<?php echo geoip_isp_by_name($cip) ?></td></tr>
<tr><th><b><?php echo __('Organisation') ?></b></th><td>
<?php echo geoip_org_by_name($cip) ?></td></tr>
<tr><th><b><?php echo __('Time Zone') ?></b></th><td>
<?php echo geoip_time_zone_by_country_and_region(geoip_region_by_name($cip)) ?></td></tr>
<tr><th><b><?php echo __('City ') ?></b></th><td>
<?php $rec = geoip_record_by_name($cip) ?>
<?php echo link_to_function(utf8_encode($rec['city']), "jQuery('#city-detail').toggle();") ?>
<div id="city-detail" class="ghost">
<ol class="column span-90">
<li class="column span-40"><?php echo __('Postal Code') ?> : </li>
<li class="column span-50"> : <?php echo $rec['postal_code'] ?></li>
<li class="column span-40"><?php echo __('Latitude') ?> : </li>
<li class="column span-50"> : <?php echo $rec['latitude'] ?></li>
<li class="column span-40"><?php echo __('Longitude') ?> : </li>
<li class="column span-50"> : <?php echo $rec['longitude'] ?></li>
<li class="column span-40"><?php echo __('Designated Market Area Code(DMA)') ?></li>
<li class="column span-50"> : <?php echo $rec['dma_code'] ?></li>
<li class="column span-40"><?php echo __('Area Code(PSTN)') ?> : </li>
<li class="column span-50"> : <?php echo $rec['area_code'] ?></li>
</ol></div>
</td></tr>
</table>
<div class="hrsplit-2"></div>
<h3><?php echo __('Contact Information') ?></h3>
<?php $contact = $usr->getContact() ?>
<?php if (!$contact): ?>
<?php echo __('Contact information is missing.') ?>
<?php else: ?>
<table class="monocolor" width="95%" cellpadding="4" cellspacing="0">
<tr><th><b><?php echo __('Home Contact') ?></b></th><td></td></tr>
<?php $home_address = $contact->getHomeAddress() ?>
<?php if($home_address): ?>
<tr><th><b><?php echo __('Street Address') ?></b></th><td>
<?php echo $home_address->getStreet() ?></td></tr>
<tr><th><b><?php echo __('Postal Code') ?></b></th><td><?php echo $home_address->getPostalCode() ?></td></tr>
<tr><th><b><?php echo __('City/State') ?></b></th><td ><?php echo ($home_address->getCountry()!=''?image_tag('layout/flag/'.$home_address->getCountry().'.png', 'style=height:13px;margin-bottom:0px;margin-right:5px; title='.format_country($home_address->getCountry())):'').' '.$home_address->getCity(). " / " .$home_address->getGeonameCity() ?></td></tr>
<?php endif ?>
<tr><th><b><?php echo __('Phone Number') ?></b></th><td ><?php echo $contact->getWorkPhone()?$contact->getWorkPhone()->getPhone():__('Not Available') ?></td></tr>
<tr><th><b><?php echo __('Work Contact') ?></b></th><td></td></tr>
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
<h3><?php echo __('Resume Details') ?></h3>
<table class="monocolor" width="95%" cellpadding="4" cellspacing="0">
<tr><th><b><?php echo __('Has Resume') ?></b></th><td><?php echo $usr->getResume()?__('Yes'):__('No') ?></td></tr>
</table>
<div class="hrsplit-2"></div>
<h3><?php echo __('Managing') ?></h3>
<?php if (!count($manages)): ?>
<?php echo __('Has nothing to manage.') ?>
<?php else: ?>
<table class="monocolor" width="95%" cellpadding="4" cellspacing="0">
<?php $i = 0; ?>
<?php foreach ($manages as $mana): ?>
<tr><th><b><?php echo $i++ ?></b></th><td><?php echo link_to($mana->getCompany(), 'admin/company', array('query_string' => 'id='.$mana->getCompany()->getId())) ?>&nbsp;(<?php echo $mana->getRole()->getName() ?>)</td></tr>
<?php endforeach ?>
</table>
<?php endif ?>
<div class="hrsplit-2"></div>
<h3><?php echo __('Blocks') ?></h3>
<table cellspacing="10">
<tr><td>
        <?php echo isset($blockError) ? $blockError : '' ?>
        <?php echo form_tag("admin/user?id={$usr->getId()}") ?>
        <?php echo input_hidden_tag('act', 'block')?>
        <?php echo submit_tag(__('Block'), array('style' => 'background-color: red; color: white; font: bold 12px tahoma; border: solid 1px #ac0303; padding: 4px 8px; cursor: pointer;')) ?>
        </form>
    </td>
    <td>
        <?php echo isset($killError) ? $killError : '' ?>
        <?php echo form_tag("admin/user?id={$usr->getId()}") ?>
        <?php echo input_hidden_tag('act', 'kill')?>
        <?php echo submit_tag(__('Kill'), array('style' => 'background-color: red; color: white; font: bold 12px tahoma; border: solid 1px #ac0303; padding: 4px 8px; cursor: pointer;')) ?>
        </form>
    </td>
</tr>
</table>
<?php $c = new Criteria(); $c->addDescendingOrderByColumn(BlocklistPeer::CREATED_AT) ?>
<?php $blocks=$usr->getLogin()->getBlocklists($c) ?>
<table width="95%" cellpadding="4" cellspacing="0" style="background: #F0F0F0">
<?php if (count($blocks)): ?>
<?php foreach ($blocks as $block): ?>
<tr><td><b><?php echo $block->getBlockReason() ?></b></td>
    <td><?php echo format_datetime($block->getCreatedAt('U')) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
<tr><td><?php echo __('No blocks found.') ?></td></tr>
<?php endif ?>
</table>
<div class="hrsplit-2"></div>
<h3><?php echo __('Event History') ?></h3>
<?php $events=$usr->getActions() ?>
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