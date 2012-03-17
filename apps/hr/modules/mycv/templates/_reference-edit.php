<div id="editrecord" class="cvRecordBlock">
<div>
<?php if ($object->isNew()): ?>
<h2><?php echo __('Add New Reference Item') ?></h2>
<?php else: ?>
<h2><?php echo __('Editing Reference Information') ?></h2>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=references', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsmr_name', __('Reference Name Lastname')) ?></dt>
    <dd><?php echo input_tag('rsmr_name', $sf_params->get('rsmr_name', $object->getName()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmr_company_name', __('Company Name')) ?></dt>
    <dd><?php echo input_tag('rsmr_company_name', $sf_params->get('rsmr_company_name', $object->getCompanyName()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmr_job_title', __('Position')) ?></dt>
    <dd><?php echo input_tag('rsmr_job_title', $sf_params->get('rsmr_job_title', $object->getJobTitle()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmr_email', __('Email')) ?></dt>
    <dd><?php echo input_tag('rsmr_email', $sf_params->get('rsmr_email', $object->getEmail()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmr_phone_number', __('Phone Number')) ?></dt>
    <dd><?php echo input_tag('rsmr_phone_number', $sf_params->get('rsmr_phone_number', $object->getPhoneNumber()?$object->getPhoneNumber()->getPhone():''), 'size=50') ?></dd>
</dl>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), "@mycv-action?action=references", 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
</div>