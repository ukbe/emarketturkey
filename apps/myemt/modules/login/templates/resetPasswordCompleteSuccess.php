<?php use_helper('Cryptographp') ?>
<div class="column span-95 pad-2 prepend-4">
<h3><?php echo __('Your New Password Set') ?></h3>
<p class="prepend-4"><?php echo __('Your new password has been set. You should use your new password while logging in.') ?></p>
<div class="hrsplit-3"></div>
<div class="prepend-3"><?php echo link_to('Log In Now', '@login') ?></div>
</div>
<div class="column span-86 pad-3 prepend-2">
<div class="hrsplit-3"></div>
<?php echo $error_msg?$error_msg:'' ?>
</div>