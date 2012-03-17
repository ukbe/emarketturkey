<?php echo form_tag('@login') ?>
<?php echo form_errors() ?>
<div class="hrsplit-1"></div>
 <ol class="column span-60 last easylogin">
  <li class="column span-13 right first"><?php echo emt_label_for('email_e', __('E-mail')) ?></li>
  <li class="column span-45 prepend-1"><?php echo input_tag('email', '', 'id=email_e name=email') ?></li>
  <li class="column span-13 right first"><?php echo emt_label_for('password_e', __('Password')) ?></li>
  <li class="column span-45 prepend-1"><?php echo input_password_tag('password', '', 'id=password_e name=password') ?></li>
  <li class="column span-44 prepend-14 first"><?php echo checkbox_tag('remember', 1, $sf_user->getAttribute("remember"), 'id=remember_e name=remember') ?>
                                        <?php echo emt_label_for('remember_e', __('Remember Me'), array('class' => 'smaller')) ?></li>
  <li class="column span-44 prepend-14 first"><?php echo submit_tag(__('Log in')) ?></li>
  <li class="column span-60 first" style="text-align: center;">
  <div class="hrsplit-1"></div><?php echo link_to(__('Login Problems?'), "@homepage") ?>
  &nbsp;&nbsp;or&nbsp;&nbsp;<?php echo link_to(__('Forgot Password?'), "@forgot-password") ?></li>
 </ol>
<?php echo "</form>" ?>
</div>