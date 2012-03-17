<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Marketing Packages'), 'admin/packages') ?></li>
<li class="last"><?php echo !$package->isNew()?$package->getName():__('New Marketing Package') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='package' && $package->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Marketing Package'), 'admin/package') ?></li>
<li<?php echo $sf_context->getActionName()=='packages'?' class="selected"':'' ?>><?php echo link_to(__('List Marketing Packages'), 'admin/packages') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/package-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/package'.(!$package->isNew()?'?id='.$package->getId()."&do=".md5($package->getName().$package->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('application_id', __('Application')) ?></li>
    <li class="column span-92 prepend-2"><?php echo object_select_tag($sf_request->getParameter('application_id', $package->getApplicationId()), 'application_id', array(
      'include_custom' => __('select an application'),
      'related_class' => 'Application',
      )) ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('applies_to_id', __('Applies To')) ?></li>
    <li class="column span-92 prepend-2"><?php echo object_select_tag($sf_request->getParameter('applies_to_id', $package->getAppliesToTypeId()), 'applies_to_id', array(
      'include_custom' => __('select an object type'),
      'related_class' => 'PrivacyNodeType',
      'peer_method' => 'getOrderedObjectNames'
      )) ?></li>
    <li class="column span-36 right first"><?php echo emt_label_for('valid_from_day', __('Valid From')) ?></li>
    <li class="column span-92 prepend-2"><?php echo select_day_tag('valid_from_day', $sf_params->get('valid_from_day', $package->getValidFrom('d')), array('include_custom' => __('day'))) . '&nbsp;' . select_month_tag('valid_from_month', $sf_params->get('valid_from_month', $package->getValidFrom('m')), array('include_custom' => __('month'))) . '&nbsp;' . select_year_tag('valid_from_year', $sf_params->get('valid_from_year', $package->getValidFrom('Y')), array('year_start' => date('Y')-5, 'year_end' => date('Y')+20, 'include_custom' => __('year'))) ?></li>
    <li class="column span-36 right first"><?php echo emt_label_for('valid_to_day', __('Valid To')) ?></li>
    <li class="column span-92 prepend-2"><?php echo select_day_tag('valid_to_day', $sf_params->get('valid_to_day', $package->getValidTo('d')), array('include_custom' => __('day'))) . '&nbsp;' . select_month_tag('valid_to_month', $sf_params->get('valid_to_month', $package->getValidTo('m')), array('include_custom' => __('month'))) . '&nbsp;' . select_year_tag('valid_to_year', $sf_params->get('valid_to_year', $package->getValidTo('Y')), array('year_start' => date('Y')-5, 'year_end' => date('Y')+20, 'include_custom' => __('year'))) ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('package_active', __('Active')) ?></li>
    <li class="column span-92 prepend-2"><?php echo checkbox_tag('package_active', 1, $sf_params->get('package_active', $package->getActive())) ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('package_status', __('Status')) ?></li>
    <li class="column span-92 prepend-2"><?php echo select_tag('package_status', options_for_select(array())) ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('admin/package_lsi_form', array('culture' => 'en', 'package' => $package, 'active' => ($package->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('admin/package_lsi_form', array('culture' => 'tr', 'package' => $package, 'active' => ($package->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Marketing Packages List'), 'admin/packages') ?></li>
</ol>
</form>
</fieldset>