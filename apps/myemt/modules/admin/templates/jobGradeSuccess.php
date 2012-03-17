<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Job Grades'), 'admin/jobGrades') ?></li>
<li class="last"><?php echo !$jobGrade->isNew()?$jobGrade->getName():__('New Job Grade') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='jobGrade' && $jobGrade->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Job Grade'), 'admin/jobGrade') ?></li>
<li<?php echo $sf_context->getActionName()=='jobGrades'?' class="selected"':'' ?>><?php echo link_to(__('List Job Grades'), 'admin/jobGrades') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/jobgrade-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/jobGrade'.(!$jobGrade->isNew()?'?id='.$jobGrade->getId()."&do=".md5($jobGrade->getName().$jobGrade->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('jobgrade_active', __('Active')) ?></li>
    <li class="column span-92 prepend-2"><?php echo checkbox_tag('jobgrade_active', 1, $sf_params->get('jobgrade_active', $jobGrade->getActive())) ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('admin/jobgrade_lsi_form', array('culture' => 'en', 'jobGrade' => $jobGrade, 'active' => ($jobGrade->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('admin/jobgrade_lsi_form', array('culture' => 'tr', 'jobGrade' => $jobGrade, 'active' => ($jobGrade->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Job Grades List'), 'admin/jobGrade') ?></li>
</ol>
</form>
</fieldset>