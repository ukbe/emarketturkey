<div class="column span-198">
</div>
<div class="hrsplit-2"></div>
<div class="column span-156 prepend-1 last">
<div class="column span-41 right">
<?php echo image_tag('layout/icon/sad.png', 'width=50') ?>
</div>
<div class="column span-104 prepend-2">
<div class="column span-100">
<div class="column span-96 pad-2" style="border: solid 1px #E4D08C; background-color: #FFF6D6">
<div class="column span-13">
<?php echo image_tag('layout/icon/stock-lock-50x50.png') ?>
</div>
<div class="column">
<h3><?php echo __('Blocked Account!') ?></h3>
<?php echo __('Hi %1, ', array('%1' => $blockeduser->getName())) ?><br />
<?php echo __('We are sorry that your account has been blocked.') ?>
</div>
</div>
<div class="hrsplit-1"></div>
<em><?php echo __('If you think this is not proper situation please send an e-mail to support@emarketturkey.com including the information on this situation.') ?></em>
<div class="hrsplit-3"></div>
<?php echo link_to_function(__('Go Back'), 'history.back()') ?>
</div>
</div>
</div>
</div>