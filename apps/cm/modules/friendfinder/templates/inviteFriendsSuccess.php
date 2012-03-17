<?php slot('uppermenu') ?>
<?php include_partial('friendfinder/uppermenu') ?>
<?php end_slot() ?>
<div style="margin: 0 auto; width: 731px;">
<style>
.add-list tr td.logo 
{
    width: 40px; 
    text-align: center; 
}
.add-list tr td.logo img  
{
}
.add-list tr td  
{
    font-size: 14px;
    padding: 6px 10px; 
    text-align: left;
    vertical-align: middle;
}
</style>
<div class="rounded-border" style="margin: 0 auto;">
<div>
<div>
<ol class="column">
<li class="column span-19" style="padding: 15px;"><?php echo image_tag('layout/invite-friends.png', 'width=80') ?></li>
<li class="column span-116">
<h1 style="font: bold 20px tahoma; color: #737373; border-bottom: solid 3px #A4A9A6; padding: 3px;"><?php echo __('Invite Friends') ?></h1>
<div class="hrsplit-2"></div>
<?php echo __('You may invite your friends to join eMarketTurkey by providing their e-mail addresses.') ?>
<div class="hrsplit-2"></div>
<?php if (isset($sent)): ?>
<div class="notify-bar">
<?php echo format_number_choice('[0]No friends were invited|[1]1 friend was invited|(1,+Inf]%1% friends were invited', array('%1%' => $sent), $sent) ?>
</div>
<?php endif ?>
<?php echo form_errors() ?>
<div class="hrsplit-1"></div>
<?php echo form_tag('@invite-friends') ?>
<ol class="column span-105">
<li class="column span-20 right append-1"><?php echo emt_label_for('emaillist', __('E-mail List')) ?></li>
<li class="column span-84"><?php echo textarea_tag('emaillist', !(isset($sent) && $sent) ? $sf_params->get('emaillist') : '', 'cols=60 rows=6') ?><br /><em class="tip"><?php echo __('please enter only one email address per line') ?></em></li>
<li class="column span-20 right append-1"><?php echo emt_label_for('message', __('Invite Message')) ?></li>
<li class="column span-84"><?php echo textarea_tag('message', !(isset($sent) && $sent) ? $sf_params->get('message') : '', 'cols=60 rows=6') ?><br /><em class="tip"><?php echo __('optional') ?></em></li>
<li class="column span-20 right append-1"><?php echo emt_label_for('cult', __('Invitation Language')) ?></li>
<li class="column span-84"><?php echo select_tag('cult', options_for_select(array('tr' => 'Türkçe', 'en' => 'English'), $sf_params->get('cult'))) ?></li>
</ol>
<div class="hrsplit-2"></div>
<div class="right">
<?php echo submit_tag(__('Send Invitation'), 'class=command') ?>
</div>
</form>
<div class="hrsplit-2"></div>
</li>
</ol>
</div>
</div>
</div>
</div>