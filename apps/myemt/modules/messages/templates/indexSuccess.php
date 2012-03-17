<div class="column span-198">
<div class="column">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<?php if ($folder == 'inbox'): ?>
<li class="last"><?php echo __('Messages') ?></li>
<?php elseif ($folder == 'sent'): ?>
<li class="last"><?php echo __('Sent Messages') ?></li>
<?php elseif ($folder == 'archived'): ?>
<li class="last"><?php echo __('Archived Messages') ?></li>
<?php endif ?>
</ol>
</div>
<ol class="column command-menu">
<li><?php echo link_to(__('Compose'), 'messages/compose') ?></li>
</ol>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('messages/leftmenu', array('companies' => $companies, 'user' => $user)) ?>
<div class="column span-156 prepend-1 last">
<?php if ($folder == 'sent'): ?>
<?php include_partial('messages/sentMessages', array('messages' => $messages, 'folder' => $folder, 'user' => $user, 'company' => $company, 'mod' => $mod)) ?>
<?php else: ?>
<?php include_partial('messages/receivedMessages', array('messages' => $messages, 'folder' => $folder, 'user' => $user, 'company' => $company, 'mod' => $mod)) ?>
<?php endif ?>
</div>