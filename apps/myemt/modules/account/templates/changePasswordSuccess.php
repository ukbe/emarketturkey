<?php slot('uppermenu') ?>
<?php include_partial('account/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenu') ?>
<?php end_slot() ?>
<?php if (form_errors()): ?>
<?php echo form_errors() ?>
<?php endif ?>
<?php echo form_tag('account/changePassword') ?>
<ol class="column span-100">
<li class="first column span-30"><?php echo emt_label_for('old_pass', __('Old Password')) ?></li>
<li class="column span-70"><?php echo input_password_tag('old_pass', $sf_params->get('old_pass'), 'size=20') ?></li>
<li class="first column span-30"><?php echo emt_label_for('new_pass', __('New Password')) ?></li>
<li class="column span-70"><?php echo input_password_tag('new_pass', $sf_params->get('new_pass'), 'size=20') ?></li>
<li class="first column span-30"><?php echo emt_label_for('new_pass_repeat', __('New Password (repeat)')) ?></li>
<li class="column span-70"><?php echo input_password_tag('new_pass_repeat', $sf_params->get('new_pass_repeat'), 'size=20') ?></li>
<li class="column span-30"></li>
<li class="column span-70"><?php echo submit_tag(__('Set Password')) ?></li>
</ol>