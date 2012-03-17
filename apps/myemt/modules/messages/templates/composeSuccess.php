<?php use_helper('Cryptographp') ?>
<div class="column span-198">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Messages'), '@messages') ?></li>
<li class="last"><?php echo __('Compose') ?></li>
</ol>
<ol class="column" style="margin: 0px;">
<li></li>
</ol>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('messages/leftmenu', array('companies' => $companies, 'user' => $user)) ?>
<div class="column span-156 prepend-1 last">
<?php echo form_errors() ?>
<?php if ($blocked): ?>
<?php echo __('You have exceeded the message sending frequency limits.') ?>
<?php else: ?>
<?php echo form_tag('messages/compose') ?>
<?php echo input_hidden_tag('ref', $sf_request->getAttribute('ref', url_for('messages/index'))) ?>
<?php echo (isset($message)?input_hidden_tag('inreplyto', $message->getThreadId()).input_hidden_tag('mod', 'reply'):"") ?>
<ol class="column span-102">
<?php if (count($senderlist)>0): ?>
<li class="column span-20 right append-2"><?php echo emt_label_for('sender', __('Sender')) ?></li>
<style>
#sender option { padding-left: 25px; display: inline-block; background-image: url(/images/layout/icon/add-icon.png)}
</style>
<li class="column span-80"><?php echo select_tag('sender', options_for_select($senderlist, $default_sender), 'style=width:390px') ?></li>
<?php endif ?>
<li class="column span-20 right append-2" style="padding: 3px 0px;"><?php echo emt_label_for('type_rcpnt', __('Recipient')) ?></li>
<li class="column span-80"><ol class="column span-80" style="margin: 0px; padding: 0px;">
<?php if (isset($rcpu)): ?>
<li id="fu<?php echo $rcpu->getId() ?>" class="column span-69" style="padding: 3px;border-bottom: dotted 1px #CCCCCC;" onmouseover="this.style.backgroundColor='#99AAAA'" onmouseout="this.style.backgroundColor='#FFFFFF'"><?php echo input_hidden_tag('recipients[]',$rcpu->getId()) ?><span class="column span-65"><?php echo $rcpu ?></span><span class="column span-4"><?php echo link_to_function(image_tag('layout/icon/delete-icon.png', 'width=15'), '$(\'fu'.$rcpu->getId().'\').outerHTML=\'\';') ?></span></li>
<?php elseif (isset($rcpus)): ?>
<?php foreach ($rcpus as $rcpu): ?>
<li id="fu<?php echo $rcpu->getId() ?>" class="column span-69" style="padding: 3px;border-bottom: dotted 1px #CCCCCC;" onmouseover="this.style.backgroundColor='#99AAAA'" onmouseout="this.style.backgroundColor='#FFFFFF'"><?php echo input_hidden_tag('recipients[]',$rcpu->getId()) ?><span class="column span-65"><?php echo $rcpu ?></span><span class="column span-4"><?php echo link_to_function(image_tag('layout/icon/delete-icon.png', 'width=15'), '$(\'fu'.$rcpu->getId().'\').outerHTML=\'\';') ?></span></li>
<?php endforeach ?>
<?php endif ?>
<li id="lastli" class="column span-4" style="padding: 3px;" style="border-bottom: dotted 1px #CCCCCC;"><?php echo link_to_function(image_tag('layout/icon/add-icon.png', 'width=15'), visual_effect('BlindDown', 'type_rcpnt', array('duration' => 0.2))) ?></li>
</ol>
<?php echo input_auto_complete_tag('type_rcpnt', '' , 'messages/setrecipient', array('autocomplete' => 'off', 'style' => 'width:390px;'.(isset($rcpu)?'display:none;':'')), array('use_style' => false)) ?></li>
<li class="column span-20 right append-2"><?php echo emt_label_for('msg_subject', __('Subject')) ?></li>
<li class="column span-80"><?php echo input_tag('msg_subject', $sf_params->get('msg_subject', ''), 'style=width:390px') ?></li>
<li class="column span-20 right append-2"><?php echo emt_label_for('msg_body', __('Message')) ?></li>
<li class="column span-80"><?php echo textarea_tag('msg_body', $sf_params->get('msg_body', ''), 'cols=61 rows=6') ?></li>
      <li class="column span-20 right append-2"></li>
      <li class="column span-80"><?php echo cryptographp_picture(); ?>&nbsp;
<?php echo cryptographp_reload(); ?></li>
      <li class="column span-20 right append-2"><?php echo emt_label_for('captcha', __('Please type the security code')) ?></li>
      <li class="column span-80"><?php echo input_tag('captcha', '', array('style' => 'border:solid 1px #CCCCCC', 'size' => '6')); ?></li>
<?php if ($confirmPassword): ?>
<li class="column span-102">&nbsp;</li>
<li class="column span-20 right append-2"><?php echo emt_label_for('msg_passwd', __('Your Password')) ?></li>
<li class="column span-80"><?php echo input_password_tag('msg_passwd', '', 'length=15 maxlength=50') ?></li>
<?php endif ?>
<li class="column span-20 append-2"></li>
<li class="column span-80"><?php echo submit_tag(__('Send Message')) ?></li>
</ol>
<?php echo "</form>" ?>
<?php endif ?>
</div>