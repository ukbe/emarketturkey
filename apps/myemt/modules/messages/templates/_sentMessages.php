<?php use_helper('Text') ?>
<?php if (count($messages)): ?>
<ol class="column span-131 message-list">
<?php foreach ($messages as $message): ?>
<li class="first column span-5">
<?php echo checkbox_tag('msg_select') ?></li>
<li class="column span-76 message" onclick="location='<?php echo url_for('messages/read?id='.$message->getId()) ?>'">
<span><span>
<?php echo link_to($message->getSubject(), 'messages/read?id='.$message->getId()) ?><br />
<?php echo truncate_text($message->getBody(), 100) ?></span></span></li>
<?php $recips=$message->getRecipients() ?>
<?php if (!$message->hasMultipleRecipient()): ?>
<li class="column span-15 right append-2">
<?php echo link_to(image_tag($recips[0]->getRecipient()->getProfilePictureUri(), array('alt' => $recips[0]->getRecipient(), 'width' => '35')), $recips[0]->getRecipient()->getProfileUrl()) ?></li>
<li class="column span-30"><b><?php echo link_to($recips[0]->getRecipient(), $recips[0]->getRecipient()->getProfileUrl()) ?></b><br />
<em><?php echo $message->getCreatedAt('d F Y h:i:s') ?></em></li>
<?php else: ?>
<li class="column span-45 right prepend-2">
<?php echo implode(', ', $message->getRecipientNames()) ?>
<br />
<em><?php echo $message->getCreatedAt('d F Y h:i:s') ?></em></li>
<?php endif ?>
<?php endforeach ?>
</ol>
<?php else: ?>
<p>
<?php echo image_tag('layout/icon/info-s.jpg').' '.__('You have not sent any messages yet.') ?>
</p>
<?php endif ?>