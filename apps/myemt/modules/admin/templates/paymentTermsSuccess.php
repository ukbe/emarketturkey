<?php use_helper('EmtAjaxTable') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Administrator'), 'admin/index') ?></li>
<li class="last"><?php echo __('Payment Terms') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='paymentTerm' && $paymentTerm->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Payment Term'), 'admin/paymentTerm') ?></li>
<li<?php echo $sf_context->getActionName()=='paymentTerms'?' class="selected"':'' ?>><?php echo link_to(__('List Payment Terms'), 'admin/paymentTerms') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('pagecommands') ?>
<ol class="column" style="margin: 0px;">
<li>
<?php echo get_progress_bar($table) ?>
<?php echo get_error_box($table) ?>
</li>
</ol>
<?php echo get_pager_links($table) ?>
<?php end_slot() ?>

<div class="column span-156 last">
<div class="column span-156">
<h2><?php echo __('Payment Terms') ?></h2>
<?php echo get_ajax_table($table); ?>
</div>
</div>