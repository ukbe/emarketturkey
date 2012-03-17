<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Business Types'), 'admin/businessTypes') ?></li>
<li class="last"><?php echo !$businessType->isNew()?$businessType->getName():__('New Business Type') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='businessType' && $businessType->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Business Type'), 'admin/businessType') ?></li>
<li<?php echo $sf_context->getActionName()=='businessTypes'?' class="selected"':'' ?>><?php echo link_to(__('List Business Types'), 'admin/businessTypes') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/businesstype-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/businessType'.(!$businessType->isNew()?'?id='.$businessType->getId()."&do=".md5($businessType->getName().$businessType->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('businesstype_active', __('Active')) ?></li>
    <li class="column span-92 prepend-2"><?php echo checkbox_tag('businesstype_active', 1, $sf_params->get('businesstype_active', $businessType->getActive())) ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('admin/businesstype_lsi_form', array('culture' => 'en', 'businessType' => $businessType, 'active' => ($businessType->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('admin/businesstype_lsi_form', array('culture' => 'tr', 'businessType' => $businessType, 'active' => ($businessType->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Business Types List'), 'admin/businessTypes') ?></li>
</ol>
</form>
</fieldset>