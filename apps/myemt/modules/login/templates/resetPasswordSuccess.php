<?php use_helper('Cryptographp') ?>
<div class="column span-95 pad-2 prepend-4">
<h3><?php echo __('Reset Your Password') ?></h3>
<p class="prepend-4"><?php echo __('Please enter your email address in the form below in order to start resetting your password. We will send you an email containing a link to reset your password.') ?></p>
<div class="hrsplit-3"></div>
<?php echo form_tag('login/resetPassword') ?>
  <ol class="column span-137" style="margin: 0px;">
      <li class="column span-35 right append-2"><?php echo emt_label_for('reset_email', __('Email')) ?></li>
      <li class="column span-100"><?php echo input_tag('reset_email', '', 'size=30') ?><br />
<em class="tip"><?php echo __('You should enter your registered email address here.') ?></em></li>
      <li class="column span-35 right append-2"></li>
      <li class="column span-100"><?php echo cryptographp_picture(); ?>&nbsp;
<?php echo cryptographp_reload(); ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('captcha', __('Please type the security code')) ?></li>
      <li class="column span-100"><?php echo input_tag('captcha', '', array('style' => 'border:solid 1px #CCCCCC', 'size' => '6')); ?></li>
      <li class="column span-35"></li>
      <li class="column span-100"><?php echo submit_tag(__('Send Email')) ?></li>
</ol>
</div>
<div class="column span-86 pad-3 prepend-2">
<div class="hrsplit-3"></div>
<?php echo form_errors() ?>
</div>