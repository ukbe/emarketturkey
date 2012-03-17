<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<?php foreach ($companies as $company): ?>
<div class="rounded-border">
<span><?php echo link_to(image_tag($company->getProfilePictureUri(), 'width=20 height=20'), 'company/manage') ?>
<?php echo link_to($company, 'company/manage') ?></span>
<div><div>
<ol>
<li><?php echo image_tag('layout/icon/bullet.png') ?>&nbsp;&nbsp;<?php
$mescount = $company->getUnreadMessageCount();
if ($company->getUnreadMessageCount() > 0)
    echo link_to(format_number_choice('[1]<b>1 new message.</b>|(1,+Inf]<b>%1 new messages.</b>', array('%1' => $mescount), $mescount), 'messages/index', array('query_string' => 'cls=inbox&mod=cm'));
else
    echo __('No new messages')
?></li>
<li><?php echo image_tag('layout/icon/bullet.png') ?>&nbsp;&nbsp;<?php echo link_to(__('Products'), 'products/list') ?></li>
</ol>
</div>
</div>
</div>
<div class="hrsplit-2"></div>
<?php endforeach ?>
<?php foreach ($groups as $group): ?>
<div class="rounded-border">
<span><?php echo link_to(image_tag($group->getProfilePictureUri(false), 'height=20'), 'group/manage', array('query_string' => 'id='.$group->getId())) ?>
<?php echo link_to($group, '@cm.group-manage?stripped_name='.$group->getStrippedName().'&action=manage') ?></span>
<div><div>
<ol>
<li><?php echo image_tag('layout/icon/bullet.png') ?>&nbsp;&nbsp;<?php
$mescount = $group->getUnreadMessageCount();
if ($mescount > 0)
    echo link_to(format_number_choice('[1]<b>1 new message.</b>|(1,+Inf]<b>%1 new messages.</b>', array('%1' => $mescount), $mescount), 'messages/index', array('query_string' => 'cls=inbox&mod=gr'));
else
    echo __('No new messages')
?></li>
<li><?php echo image_tag('layout/icon/bullet.png') ?>&nbsp;&nbsp;<?php echo link_to(__('Members'), 'group/members', array('query_string' => 'id='.$group->getId())) ?>
</ol>
</div>
</div>
</div>
<div class="hrsplit-2"></div>
<?php endforeach ?>
