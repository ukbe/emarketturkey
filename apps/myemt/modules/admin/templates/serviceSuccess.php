<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Administrator'), 'admin/index') ?></li>
<li><?php echo link_to(__('Services'), 'admin/services') ?></li>
<li class="last"><?php echo !$service->isNew()?$service->getName():__('New Service') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='service' && $service->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Service'), 'admin/service') ?></li>
<li<?php echo $sf_context->getActionName()=='services'?' class="selected"':'' ?>><?php echo link_to(__('List Services'), 'admin/services') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/service-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/service'.(!$service->isNew()?'?id='.$service->getId()."&do=".md5($service->getName().$service->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('application_id', __('Application')) ?></li>
    <li class="column span-92 prepend-2"><?php echo object_select_tag($sf_params->get('application_id', $service->getApplicationId()), 'application_id', array(
      'include_custom' => __('select an application'),
      'related_class' => 'Application',
      )) ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('applies_to_id', __('Applies To')) ?></li>
    <li class="column span-92 prepend-2"><?php echo object_select_tag($sf_params->get('applies_to_id', $service->getAppliesToTypeId()), 'applies_to_id', array(
      'include_custom' => __('select an object type'),
      'related_class' => 'PrivacyNodeType',
      'peer_method' => 'getOrderedObjectNames'
      )) ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('service_active', __('Active')) ?></li>
    <li class="column span-92 prepend-2"><?php echo checkbox_tag('service_active', 1, $sf_params->get('service_active', $service->getActive())) ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('admin/service_lsi_form', array('culture' => 'en', 'service' => $service, 'active' => ($service->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('admin/service_lsi_form', array('culture' => 'tr', 'service' => $service, 'active' => ($service->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Services List'), 'admin/services') ?></li>
</ol>
</form>
</fieldset>