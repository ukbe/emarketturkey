<?php slot('uppermenu') ?>
<?php include_partial('account/uppermenu') ?>
<?php end_slot() ?>
<?php if ($sf_user->getUSer()): ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenu') ?>
<?php end_slot() ?>
<?php endif ?>
<h1 style="font: bold 14pt verdana; color: #333379;"><?php echo __('Verify Your E-mail Address') ?></h1>
<?php if ($resentMail): ?>
<div style="font: 14px verdana; background-color: #b1ee9e; float: left; padding: 10px;clear: both;">
<b><?php echo __('Message Sent!') ?></b><br />
<?php echo __('Verification message has been re-sent to your e-mail address.') ?>
</div>
<div class="hrsplit-1"></div>
<?php endif ?>
<p style="font: 13px tahoma; clear: both;"><?php echo __('You should verify your e-mail address in order to unlock your account. Once you unlock your account you will be able to;') ?></p>
<style>
    ul.list {list-style-type: lower-roman; padding: 10px 10px 10px 40px; }
    ul.list li {list-style-type: lower-roman; }
</style> 
<ul class="list">
<li><?php echo __('send messages to other members,') ?></li>
<li><?php echo __('add friends and colleagues to your network,') ?></li>
<li><?php echo __('register your company,') ?></li>
<li><?php echo __('start your own community group,') ?></li>
</ul>
<em class="tip" style="padding-left: 40px;"><?php echo __('and much more ..') ?></em>
<div class="hrsplit-3"></div>
<p style="font: 13px tahoma;"><?php echo __('Verification message was sent to your e-mail address. Please check your inbox and click the verification link in the message.') ?></p>
<div class="hrsplit-2"></div>
<p style="font: 12px arial;"><?php echo __("Note: If you didn't receive verification e-mail, click the re-send link below so that we re-send you the verification message.") ?>
<div class="hrsplit-1"></div>
<?php echo link_to(__('Re-send'), '@verify-email', array('query_string' => 'resend=yes', 'class' => 'nice')) ?></p>