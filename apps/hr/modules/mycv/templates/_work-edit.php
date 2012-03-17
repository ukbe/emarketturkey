<div id="editrecord" class="cvRecordBlock">
<div>
<?php if ($object->isNew()): ?>
<h2><?php echo __('Add New Work Experience Item') ?></h2>
<?php else: ?>
<h2><?php echo __('Editing Work Experience Item') ?></h2>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=work', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsmw_company_name', __('Company Name')) ?></dt>
    <dd><?php echo input_tag('rsmw_company_name',$sf_params->get('rsmw_company_name', $object->getCompanyName()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmw_job_title', __('Job Title')) ?></dt>
    <dd><?php echo input_tag('rsmw_job_title',$sf_params->get('rsmw_job_title', $object->getJobTitle()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmw_sdate', __('Beginning')) ?></dt>
    <dd><?php echo input_hidden_tag('rsmw_sdate') ?>
        <?php echo input_tag('rsmw_sdate_dp', $sf_params->get('rsmw_sdate_dp', $object->getDateFrom('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('rsmw_present', __('Present')) ?></dt>
    <dd><?php echo checkbox_tag('rsmw_present', 1, $sf_params->get('rsmw_present', $object->getPresent()), array('onchange' => "if ($(this).is(':checked')) $('.end-date').hide(); else $('.end-date').show();")) ?></dd>
    <dt class="end-date<? echo $sf_params->get('rsmw_present', $object->getPresent()) ? ' ghost' : '' ?>"><?php echo emt_label_for('rsmw_edate', __('Ending')) ?></dt>
    <dd class="end-date<? echo $sf_params->get('rsmw_present', $object->getPresent()) ? ' ghost' : '' ?>"><?php echo input_hidden_tag('rsmw_edate') ?>
        <?php echo input_tag('rsme_wdate_dp', $sf_params->get('rsmw_edate_dp', $object->getDateTo('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('rsmw_projects', __('Projects')) ?></dt>
    <dd><?php echo textarea_tag('rsmw_projects', $sf_params->get('rsmw_projects', $object->getProjects()), array('cols' => 53, 'rows' => 4, 'max' => 5)) ?>
        <em class="ln-example"><?php echo __('You may specify some projects you have worked on. (max. 900 characters)') ?></em></dd>
</dl>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), "@mycv-action?action=work", 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
</div>