<?php if ($sf_user->getMessage()): ?>
<div class="ghost">
<?php if ($sf_user->getMessageHeader()): ?>
<div id="page-user-message-header"><?php echo $sf_user->getMessageHeader(true) ?></div>
<?php endif ?>
<div id="page-user-message"><div class="dynaboxMsg"><?php echo $sf_user->getMessage(true) ?></div></div>
</div>
<?php endif ?>