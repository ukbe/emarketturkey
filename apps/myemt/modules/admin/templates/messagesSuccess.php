<div class="column span-198">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li class="last"><?php echo __('Customer Messages') ?></li>
</ol>
<ol class="column" style="margin: 0px;">
</ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-156 last">
<div class="column span-156">
<h2><?php echo __('Customer Messages') ?></h2>
<?php if (isset($message) && $message): ?>
<div class="column span-62 pad-2 divbox">
<ol class="column span-62">
<li class="column span-20 right append-2 first"><b><?php echo __('Name Lastname') ?></b></li>
<li class="column span-40"><?php echo $message->getSenderNamelastname() ?></li>
<li class="column span-20 right append-2 first"><b><?php echo __('Session User') ?></b></li>
<li class="column span-40"><?php echo $message->getUser()?link_to($message->getUser(), $message->getUser()->getProfileUrl()):__('Anonymous') ?></li>
<li class="column span-20 right append-2 first"><b><?php echo __('Email') ?></b></li>
<li class="column span-40"><?php echo $message->getSenderEmail() ?></li>
<li class="column span-20 right append-2 first"><b><?php echo __('Topic') ?></b></li>
<li class="column span-40"><?php echo $topic[$message->getTopicId()] ?></li>
<li class="column span-20 right append-2 first"><b><?php echo __('Message') ?></b></li>
<li class="column span-40"><?php echo str_replace('\n', '<br />', $message->getMessage()) ?></li>
</ol>
</div>
<div class="hrsplit-1"></div>
<?php endif ?>
<?php if (count($messages)): ?>
<h3><?php echo __('Received Messages') ?></h3>
<table style="border: solid 1px #CCCCCC;" cellpadding="7" cellspacing="0" width="100%">
<tr><th style="border-bottom: solid 1px #EFEFEF;"><?php echo __('Email') ?></th>
<th style="border-bottom: solid 1px #EFEFEF;"><?php echo __('Topic') ?></th>
<th style="border-bottom: solid 1px #EFEFEF;"><?php echo __('Name Lastname') ?></th>
<th style="border-bottom: solid 1px #EFEFEF;"><?php echo __('Session User') ?></th>
<th style="border-bottom: solid 1px #EFEFEF;"><?php echo __('Sent At') ?></th>
<th style="border-bottom: solid 1px #EFEFEF;"><?php echo __('Action') ?></th>
</tr>
<?php foreach($messages as $mes): ?>
<tr><td style="border-bottom: solid 1px #EFEFEF;"><?php echo $mes->getSenderEmail() ?></td>
<td style="border-bottom: solid 1px #EFEFEF;"><?php echo $topic[$mes->getTopicId()] ?></td>
<td style="border-bottom: solid 1px #EFEFEF;"><?php echo $mes->getSenderNamelastname() ?></td>
<td style="border-bottom: solid 1px #EFEFEF;"><?php echo $mes->getUser()?link_to($mes->getUser(),$mes->getUser()->getProfileUrl()):__('Anonymous') ?></td>
<td style="border-bottom: solid 1px #EFEFEF;"><?php echo $mes->getCreatedAt() ?></td>
<td style="border-bottom: solid 1px #EFEFEF;"><?php echo link_to(__('Reply'), 'admin/messages?id='.$mes->getId()) ?> - 
<?php echo link_to(__('Read'), 'admin/messages?id='.$mes->getId()) ?></td>
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
<?php echo __('There is no sent messages.') ?>
<?php endif ?>
</div>
</div>