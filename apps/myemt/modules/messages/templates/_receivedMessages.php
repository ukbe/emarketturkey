<?php use_helper('Text') ?>
<?php if (count($messages)): ?>
<ol class="column span-131 message-list">
<?php foreach ($messages as $message): ?>
<li class="first column span-5">
<?php echo checkbox_tag('msg_select') ?></li>
<li class="column span-76 message" onclick="location='<?php echo url_for('messages/read?id='.$message->getId()) ?>'">
<span><span>
<?php if ($mod == 'cm'): ?>
<?php $rec = $message->getRecipientFor($company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?>
<?php else: ?>
<?php $rec = $message->getRecipientFor($user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER) ?>
<?php endif ?>
<?php if (!$rec->getIsRead()): ?>
<em style="float:right"><?php echo image_tag('layout/icon/new-star.png', array('alt' => 'New Message')) ?></em>
<?php endif ?>
<?php echo link_to($message->getSubject(), 'messages/read?id='.$message->getId()) ?>
<br />
<?php echo truncate_text($message->getBody(), 100) ?></span></span></li>
<li class="column span-15 right append-2">
<?php echo link_to(image_tag($message->getSender()->getProfilePictureUri(), array('alt' => $message->getSender(), 'height' => '35')), $message->getSender()->getProfileUrl()) ?></li>
<li class="column span-30"><b><?php echo link_to($message->getSender(), $message->getSender()->getProfileUrl()) ?></b><br />
<em><?php echo $message->getCreatedAt('d F Y h:i:s') ?></em></li>
<?php endforeach ?>
</ol>
<?php else: ?>
<p>
<?php echo image_tag('layout/icon/info-s.jpg').' '.($folder=='inbox'?__('You do not have any messages.'):__('You do not have any archived messages.')) ?>
</p>
<?php endif ?>