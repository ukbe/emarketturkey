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
<li class="column span-21" style="padding: 10px;">
<?php if ($consent_type == ConsentLoginPeer::CST_SERV_TYP_WINDOWS_LIVE): ?>
<?php echo image_tag('layout/live-add-friends.png') ?>
<?php elseif ($consent_type == ConsentLoginPeer::CST_SERV_TYP_GOOGLE): ?>
<?php echo image_tag('layout/google-add-friends.png', 'width=100 style=margin-top:0px;') ?>
<?php endif ?>
</li>
<li class="column span-116">
<?php echo form_tag('@consent-add?lid='.$consentLogin->getId()) ?>
<h1 style="font: bold 20px tahoma; color: #737373; border-bottom: solid 3px #A4A9A6; padding: 3px;"><?php echo __('Add Friends') ?></h1>
<?php if (count($members)): ?>
<table class="add-list" cellpadding="0" cellspacing="0" align="left">
<?php foreach ($members as $member): ?>
<tr><td><?php echo checkbox_tag('members[]', $member->getId(), true) ?></td>
<td class="logo"><?php echo image_tag($member->getProfilePictureUri()) ?></td>
<td><b><?php echo $member ?></b><br /><em class="tip"><?php echo $member->getLogin()->getEmail() ?></em></td></tr>
<?php endforeach ?>
</table>
<div class="right first">
<?php echo link_to_function(__('Check All'), "jQuery('input[name=members\\[\\]]').each(function(){this.checked=true});", 'class=action') ?>&nbsp;&nbsp;
<em class="sepdot"></em>
<?php echo link_to_function(__('Un-check All'), "jQuery('input[name=members\\[\\]]').each(function(){this.checked=false});", 'class=action') ?>
</div>
<?php endif ?>
<div class="hrsplit-2"></div>
<div class="right">
<?php echo submit_tag(__('Continue'), 'class=command target=_blank') ?>
</div>
</form>
<div class="hrsplit-2"></div>
</li>
</ol>
</div>
</div>
</div>
</div>