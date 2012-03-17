<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Applications'), 'admin/applications') ?></li>
<li class="last"><?php echo !$application->isNew()?$application->getName():__('New Application') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='application' && $application->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Application'), 'admin/application') ?></li>
<li<?php echo $sf_context->getActionName()=='applications'?' class="selected"':'' ?>><?php echo link_to(__('List Applications'), 'admin/applications') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/application-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/application'.(!$application->isNew()?'?id='.$application->getId()."&do=".md5($application->getName().$application->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('application_appcode', __('App Code')) ?></li>
    <li class="column span-92 prepend-2"><?php echo input_tag('application_appcode', $sf_params->get('application_appcode', $application->getAppCode())) ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('admin/application_lsi_form', array('culture' => 'en', 'application' => $application, 'active' => ($application->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('admin/application_lsi_form', array('culture' => 'tr', 'application' => $application, 'active' => ($application->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Applications List'), 'admin/applications') ?></li>
</ol>
</form>
</fieldset>