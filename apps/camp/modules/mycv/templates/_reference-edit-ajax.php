<emtAjaxResponse>
<emtInit>
<?php echo "
$('#ajx-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });

$('dl._table input').customInput();
" ?>
</emtInit>
<emtHeader>
<?php if ($object->isNew()): ?>
<?php echo __('Add Reference Item') ?>
<?php else: ?>
<?php echo __('Editing Reference Information') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
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
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Save'), "", 'id=ajx-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>