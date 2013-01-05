<?php slot('uppermenu') ?>
<?php include_partial('network/uppermenu') ?>
<?php end_slot() ?>
<div class="network-panel">
<h2><?php echo __('Notifications') ?></h2>
<?php if (count($notifications)): ?>
<table id="request-list" cellspacing="0" cellpadding="0">
<?php foreach ($notifications as $notification): ?>
<tr>
<td>
<?php echo $notification ?>
</td>
</tr>
<?php endforeach ?>
</table> 
<?php else: ?>
<?php echo __("You don't have any notifications.") ?><br /><br />
<?php endif ?>
</div>