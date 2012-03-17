<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Payment Terms'), 'admin/paymentTerms') ?></li>
<li class="last"><?php echo !$paymentTerm->isNew()?$paymentTerm->getName():__('New Payment Term') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='paymentTerm' && $paymentTerm->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Payment Term'), 'admin/paymentTerm') ?></li>
<li<?php echo $sf_context->getActionName()=='paymentTerms'?' class="selected"':'' ?>><?php echo link_to(__('List Payment Terms'), 'admin/paymentTerms') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/paymentterm-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/paymentTerm'.(!$paymentTerm->isNew()?'?id='.$paymentTerm->getId()."&do=".md5($paymentTerm->getName().$paymentTerm->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('paymentterm_code', __('Payment Term Code')) ?></li>
    <li class="column span-92 prepend-2"><?php echo input_tag('paymentterm_code',$sf_params->get('paymentterm_code', $paymentTerm->getCode()), 'size=20') ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('admin/paymentterm_lsi_form', array('culture' => 'en', 'paymentTerm' => $paymentTerm, 'active' => ($paymentTerm->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('admin/paymentterm_lsi_form', array('culture' => 'tr', 'paymentTerm' => $paymentTerm, 'active' => ($paymentTerm->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Payment Terms List'), 'admin/paymentTerms') ?></li>
</ol>
</form>
</fieldset>