<?php use_helper('Cryptographp') ?>
<div class="column span-95 pad-2 prepend-4">
<h3><?php echo __('Set Your New Password') ?></h3>
<p class="prepend-4"><?php echo __('Hi %1', array('%1' => $user)) ?></p>
<p class="prepend-4"><?php echo __('Please set a new password for your account. Make sure that it is not easily guessable by other people.') ?></p>
<div class="hrsplit-3"></div>
<?php echo form_tag('login/resetPassword?log='.$sf_params->get('log').'&req='.$sf_params->get('req')) ?>
  <ol class="column span-137" style="margin: 0px;">
      <li class="column span-35 right append-2"><?php echo emt_label_for('new_passwd', __('New Password')) ?></li>
      <li class="column span-100"><?php echo input_password_tag('new_passwd', '', 'size=30') ?><br />
<em class="tip"><?php echo __('Your password should include 6-14 chars. and <b>at least one</b> numerical character.') ?></em></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('new_passwd_rpt', __('New Password (repeat)')) ?></li>
      <li class="column span-100"><?php echo input_password_tag('new_passwd_rpt', '', 'size=30') ?><br />
      <li class="column span-35"></li>
      <li class="column span-100"><?php echo submit_tag(__('Set Password')) ?></li>
</ol>
</div>
<div class="column span-86 pad-3 prepend-2">
<div class="hrsplit-3"></div>
<?php echo form_errors() ?>
</div>