<ol class="leftactions">
<?php if (!$sf_user->getUser()->getLogin()->isVerified()): ?>
<li<?php echo $sf_context->getActionName()=='verify'?' class="selected"':'' ?>><?php echo link_to(__('Verify E-mail Address'), 'account/verify', array("style" => 'color: red;')) ?></li>
<?php endif ?>
<li<?php echo $sf_context->getActionName()=='edit'?' class="selected"':'' ?>><?php echo link_to(__('Edit Account Settings'), 'account/edit') ?></li>
<li<?php echo $sf_context->getActionName()=='changePassword'?' class="selected"':'' ?>><?php echo link_to(__('Change Password'), 'account/changePassword') ?></li>
</ol>