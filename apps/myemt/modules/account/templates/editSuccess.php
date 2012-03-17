<?php slot('uppermenu') ?>
<?php include_partial('account/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenu') ?>
<?php end_slot() ?>
<?php echo form_errors() ?>
<?php echo form_tag('account/edit') ?>
<ol class="column span-100">
<li class="column span-30"><?php echo emt_label_for('user_name', __('Name')) ?></li>
<li class="column span-70"><?php echo input_tag('user_name', $sf_params->get('user_name', $user->getName()), 'size=25') ?></li>
<li class="column span-30"><?php echo emt_label_for('user_lastname', __('Lastname')) ?></li>
<li class="column span-70"><?php echo input_tag('user_lastname', $sf_params->get('user_lastname', $user->getLastname()), 'size=25') ?></li>
<li class="column span-30"><?php echo emt_label_for('user_alternative_email', __('Alternative Email')) ?></li>
<li class="column span-70"><?php echo input_tag('user_alternative_email', $sf_params->get('user_alternative_email', $user->getAlternativeEmail()), 'size=25') ?></li>
<li class="column span-30"><?php echo emt_label_for('user_username', __('Username')) ?></li>
<li class="column span-70"><?php echo input_tag('user_username', $sf_params->get('user_username', $login->getUsername()), 'size=25 '.($login->hasUsername()==true?"disabled=disabled":"")) ?><br />
<em class="tip"><?php echo __('Once you set your username, you cannot change it anymore.') ?></em></li>
<li class="column span-30"></li>
<li class="column span-70"><?php echo submit_tag(__('Save Changes')) ?></li>
</ol>
</form>
