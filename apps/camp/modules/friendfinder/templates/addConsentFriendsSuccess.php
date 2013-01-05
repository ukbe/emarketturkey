<?php slot('subNav') ?>
<?php include_partial('subNav-addFriends', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">
    <div class="box_657 _titleBG_Transparent" style="float: none; margin: 0 auto;">
        <?php $logo = ($consent_type == ConsentLoginPeer::CST_SERV_TYP_WINDOWS_LIVE) ? 'windows-live-logo.png' : 'google.png' ?>
        <h4 style="background: url(/images/layout/<?php echo $logo ?>) 99% top no-repeat; background-size: auto 40px; padding-top: 20px;"><?php echo __('Found Some Friends') ?></h4>
        <div class="_noBorder">


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
<?php echo form_tag('@consent-add?lid='.$consentLogin->getId()) ?>
<?php if (count($members)): ?>
<table class="add-list" cellpadding="0" cellspacing="0" align="left">
<?php foreach ($members as $member): ?>
<tr><td><?php echo checkbox_tag('members[]', $member->getId(), true) ?></td>
<td class="logo"><?php echo image_tag($member->getProfilePictureUri()) ?></td>
<td><b><?php echo $member ?></b><br /><em class="tip"><?php echo $member->getLogin()->getEmail() ?></em></td></tr>
<?php endforeach ?>
</table>
<div class="hrsplit-3"></div>
<ul class="_horizontal sepdot">
    <li><?php echo link_to_function(__('Check All'), "$('input[name=\"members\\[\\]\"]').each(function(){ $(this).attr('checked', true); });", 'class=inherit-font bluelink hover') ?></li>
    <li><?php echo link_to_function(__('Un-check All'), "$('input[name=\"members\\[\\]\"]').each(function(){ $(this).attr('checked', false); });", 'class=inherit-font bluelink hover') ?></li>
</ul>
<?php endif ?>
<div class="hrsplit-1"></div>
<div class="_right">
<?php echo submit_tag(__('Continue'), 'class=green-button target=_blank') ?>
</div>
</form>
<div class="hrsplit-2"></div>

        </div>
    </div>
</div>