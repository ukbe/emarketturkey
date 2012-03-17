<style>
.invite-box {
    background: url(/images/layout/background/invite-friend-box.png) no-repeat left top;
    padding: 20px;
    width: 483px;
    height: 285px;
}
.invite-box div {
    width: 445px;
    height: 277px;
    overflow: scroll;
}
.invite-box table {
width: 427px; height:272px;
}
.invite-box table td {
padding: 4px;
font: 14px verdana;
color: #000000;
border-bottom: solid 1px #C0C0C0;
}
</style>
<?php echo form_tag('consent/invite') ?>
<div>
<h1><?php echo __('Contact List Retrieved') ?></h1>
<div class="column span-97 pad-1 right">
<?php if (count($members)): ?>
<div class="sidebar-header"><?php echo __('Add to Your Network') ?></div>
<div class="hrsplit-1"></div>
<div class="invite-box">
<div>
<table class="network-list" cellpadding="0" cellspacing="0" align="left">
<?php foreach ($members as $member): ?>
<tr>
<td><?php echo checkbox_tag('members[]', $member->getId(), true) ?></td>
<td><?php if ($user->can(ActionPeer::ACT_VIEW_PROFILE, $member)): ?>
<?php echo link_to(image_tag($member->getProfilePictureUri()), $member->getProfileUrl()) ?>
<?php else: ?>
<?php echo image_tag($member->getProfilePictureUri()) ?>
<?php endif ?>
<?php if ($user->can(ActionPeer::ACT_VIEW_PROFILE, $member)): ?>
<?php echo link_to($member, $member->getProfileUrl(), 'class=name') ?>
<?php else: ?>
<b class="large"><?php echo $member ?></b>
<?php endif ?>
</td></tr>
<?php endforeach ?>
</table>
</div>
</div>
<div class="right">
<?php echo link_to_function('Check All', "jQuery('input[name=members\\[\\]]').each(function(){this.checked=true});") ?>&nbsp;&nbsp;
<?php echo link_to_function('Un-check All', "jQuery('input[name=members\\[\\]]').each(function(){this.checked=false});") ?>
</div>
<div class="hrsplit-1"></div>
<?php echo button_to_function('Add Network Message', "jQuery('.add-friend').slideToggle()", 'class=add-friend') ?>
<div class="add-friend ghost">
<?php echo emt_label_for('add-friend-message', __('Network Request Message :')) ?><em><?php echo __('(optional)') ?></em><br />
<?php echo textarea_tag('add-friend-message', '', array('style' => 'width: 470px; height: 40px;')) ?>
<br />
<em><?php echo __('This message will be contained in the network request notification e-mail.') ?></em>
</div>
<?php endif ?>
</div>
<div class="column span-97 pad-1 left">
<?php if (count($candidates)): ?>
<div class="sidebar-header"><?php echo __('Send Invitations to') ?></div>
<div class="hrsplit-1"></div>
<div class="invite-box">
<div>
<table class="invite-list" cellpadding="0" cellspacing="0" style="">
<?php foreach ($candidates as $candidate): ?>
<?php $attr = array();
      if (in_array($candidate->getEmail(), $banned_emails))
      {
          $attr[0] = 'disabled=disabled';
          $attr[1] = "<font color=\"#999999\">{$candidate->getEmail()}</font>";
      }
      else
      {
          $attr[0] = '';
          $attr[1] = $candidate->getEmail();
      } ?>
<tr>
<td><?php echo checkbox_tag('candidates[]', $candidate->getId(), $attr[0]==''?true:false, $attr[0]) ?></td>
<td><?php echo $attr[1] ?></td></tr>
<?php endforeach ?>
</table>
</div>
</div>
<div class="right">
<?php echo link_to_function('Check All', "jQuery('input[name=candidates\\[\\]]').each(function(){this.checked=true});") ?>&nbsp;&nbsp;
<?php echo link_to_function('Un-check All', "jQuery('input[name=candidates\\[\\]]').each(function(){this.checked=false});") ?>
</div>
<div class="hrsplit-1"></div>
<?php echo button_to_function('Add Invitation Message', "jQuery('.invite-friend').slideToggle();", 'class=invite-friend') ?>
<div class="invite-friend ghost">
<?php echo emt_label_for('invite-friend-message', __('Invitation Message :')) ?><em><?php echo __('(optional)') ?></em><br />
<?php echo textarea_tag('invite-friend-message', '', array('style' => 'width: 470px; height: 40px;' )) ?>
<br />
<em><?php echo __('This message will be contained in the invitation e-mail.') ?></em>
</div>
<?php endif ?>
</div>
</div>
<div class="hrsplit-1"></div>
<div align="center">
<?php echo submit_image_tag('layout/button/send-invitations.'.$sf_user->getCulture().'.png') ?>
</div>
</form>
