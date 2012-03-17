<div class="column span-198">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Messages'), '@messages') ?></li>
<li class="last"><?php echo __('Send Successful') ?></li>
</ol>
<ol class="column command-menu">
<li><?php echo link_to(__('Compose'), 'messages/compose') ?></li>
</ol>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('messages/leftmenu') ?>
<div class="column span-156 prepend-1 last">
<div class="larger">
<h2><?php echo __('Send Successful!') ?></h2>
<?php echo __('Your message was successfully sent to '.$rcpnt_user) ?>
</div>
</div>