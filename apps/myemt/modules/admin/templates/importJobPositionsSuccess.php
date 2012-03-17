<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Job Positions'), 'admin/jobPositions') ?></li>
<li class="last"><?php echo __('Import') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='jobPosition' && $jobPosition->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Job Position'), 'admin/jobPosition') ?></li>
<li<?php echo $sf_context->getActionName()=='jobPositions'?' class="selected"':'' ?>><?php echo link_to(__('List Job Positions'), 'admin/jobPositions') ?></li>
<li<?php echo $sf_context->getActionName()=='importJobPositions'?' class="selected"':'' ?>><?php echo link_to(__('Import Job Positions'), 'admin/importJobPositions') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<h3><?php echo __('Import Job Positions') ?></h3>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/importJobPositions') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('jobstr', __('Jobs List')) ?></li>
    <li class="column span-92 prepend-2"><?php echo textarea_tag('jobstr', $sf_params->get('jobstr'), 'cols=60 rows=10') ?><br />
    <span class="hint"><em><?php echo __('Attention: This job list should be in comma seperated format. First column represents Job Position name in English, while second column represents Job Position name in Turkish.') ?></em></span></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-36 first right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Import')) ?>&nbsp;<?php echo link_to(__('Back to Job Positions List'), 'admin/jobPositions') ?></li>
</ol>
</form>
</fieldset>