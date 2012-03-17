<?php use_helper('Date') ?>
<div class="column span-198">
<div class="column span-43">
<ol class="column mappath" style="margin: 0px;">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Messages'), '@messages') ?></li>
<li class="last"><?php echo __('Read') ?></li>
</ol>
</div>
<ol class="column command-menu">
<li><?php echo link_to(__('Compose'), 'messages/compose') ?></li>
<li><?php echo link_to(__('Delete'), 'messages/read', array('query_string' => 'mod=del&id='.$message->getId())) ?></li>
<?php if (!$message->isSentBy($sf_user->getUser()->getId())): ?>
<li><?php echo link_to(__('Reply'), 'messages/compose', array('query_string' => 'mod=reply&inreplyto='.$message->getId())) ?></li>
<?php endif ?>
</ol>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('messages/leftmenu', array('companies' => $companies, 'user' => $user)) ?>
<div class="column span-156 prepend-1">
<?php if($message): ?>
<ol class="message-read">
<li class="senderpic">
<?php echo link_to(image_tag($message->getSender()->getProfilePictureUri(), 'width=30'), $message->getSender()->getProfileUrl()) ?>
</li>
<li class="sendertext"><?php echo link_to($message->getSender(), $message->getSender()->getProfileUrl()) ?><br />
<em><?php echo __('sent ').time_ago_in_words($message->getCreatedAt('U')).' ago' ?></em></li>
<li class="envelope">&nbsp;</li>
<?php $recs=$message->getRecipients() ?>
<?php if (count($recs)>1): ?>
<li class="rectext">
<?php $i=0; ?>
<?php foreach ($recs as $rec): ?>
<?php $i++; echo ($i>1)?", ":"" ?>
<?php echo link_to($rec->getRecipient(), $rec->getRecipient()->getProfileUrl()) ?>
<?php endforeach ?>
</li>
<?php else: ?>
<li class="recpic">
<?php echo link_to(image_tag($recs[0]->getRecipient()->getProfilePictureUri(), 'width=30'), $recs[0]->getRecipient()->getProfileUrl()) ?>
</li>
<li class="rectext"><?php echo link_to($recs[0]->getRecipient(), $recs[0]->getRecipient()->getprofileUrl()) ?>
</li>
<?php endif ?>
<li class="splitter"></li>
<li class="left"><?php echo __('Subject') ?> :</li>
<li class="right"><?php echo $message->getSubject() ?></li>
<li class="dotlitter"></li>
<li class="left"><?php echo __('Sent at') ?> :</li>
<li class="right"><?php echo $message->getCreatedAt('d F Y h:i:s') ?></li>
<li class="dotlitter"></li>
<li class="left"><?php echo __('Message') ?> :</li>
<li class="right"><?php echo str_replace(chr(13), '<br />', $message->getBody()) ?></li>
</ol>
<?php if (count($thread_messages)): ?>
<div class="hrsplit-3"></div>
<ol class="column span-117 prepend-2">
<li class="column span-117"><b><u><?php echo __('Other messages in this thread')." :" ?></u></b></li>
<?php foreach ($thread_messages as $tmes): ?>
<li class="column span-117"><em><? echo __('"%1" sent by %2 at %3', array('%1' => link_to($tmes->getSubject(), 'messages/read?id='.$tmes->getId()), '%2' => link_to($tmes->getSender(), $tmes->getSender()->getProfileUrl()), '%3' => $tmes->getCreatedAt('d F Y h:i:s'))) ?></em></li>
<?php endforeach ?>
</ol>
<?php endif ?>
<?php endif ?>
</div>