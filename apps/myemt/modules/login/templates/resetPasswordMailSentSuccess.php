<?php use_helper('Cryptographp') ?>
<div class="column span-95 pad-2 prepend-4">
<h3><?php echo __('Reset Password Mail Sent') ?></h3>
<p class="prepend-4"><?php echo __('An email including information on how to reset your password has been sent to your email address.<br />Please check your e-mail inbox.') ?></p>
<div class="hrsplit-3"></div>
</div>
<div class="column span-86 pad-3 prepend-2">
<div class="hrsplit-3"></div>
<?php echo $error_msg?$error_msg:'' ?>
</div>