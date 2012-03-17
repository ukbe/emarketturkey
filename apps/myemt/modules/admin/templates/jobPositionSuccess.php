<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Job Positions'), 'admin/jobPositions') ?></li>
<li class="last"><?php echo !$jobPosition->isNew()?$jobPosition->getName():__('New Job Position') ?></li>
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
<?php echo image_tag('layout/background/admin/jobposition-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/jobPosition'.(!$jobPosition->isNew()?'?id='.$jobPosition->getId()."&do=".md5($jobPosition->getName().$jobPosition->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('jobposition_active', __('Active')) ?></li>
    <li class="column span-92 prepend-2"><?php echo checkbox_tag('jobposition_active', 1, $sf_params->get('jobposition_active', $jobPosition->getActive())) ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('admin/jobposition_lsi_form', array('culture' => 'en', 'jobPosition' => $jobPosition, 'active' => ($jobPosition->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('admin/jobposition_lsi_form', array('culture' => 'tr', 'jobPosition' => $jobPosition, 'active' => ($jobPosition->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Job Positions List'), 'admin/jobPositions') ?></li>
</ol>
</form>
</fieldset>