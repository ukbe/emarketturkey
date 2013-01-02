<div id="editrecord" class="cvRecordBlock">
<div>
<?php if ($object->isNew()): ?>
<h2><?php echo __('Add New Course/Certificate Item') ?></h2>
<?php else: ?>
<h2><?php echo __('Editing Course/Certificate Information') ?></h2>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=courses', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsmc_name', __('Title')) ?></dt>
    <dd><?php echo input_tag('rsmc_name', $sf_params->get('rsmc_name', $object->getName()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmc_institute', __('Institue')) ?></dt>
    <dd><?php echo input_tag('rsmc_institute',$sf_params->get('rsmc_institute', $object->getInstitute()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmc_sdate', __('Beginning')) ?></dt>
    <dd><?php echo input_hidden_tag('rsmc_sdate') ?>
        <?php echo input_tag('rsmc_sdate_dp', $sf_params->get('rsmc_sdate_dp', $object->getDateFrom('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('rsmc_daily', __('Daily Event')) ?></dt>
    <dd><?php echo checkbox_tag('rsmc_daily', '1', $sf_params->get('rsmc_daily', $object->getDaily()), array('onchange' => "if (this.checked) {jQuery('.rsmc_end_date"."').slideUp();} else {jQuery('.rsmc_end_date"."').slideDown();}")) ?></dd>
    <dt class="end-date<? echo $sf_params->get('rsmc_daily', $object->getDaily()) ? ' ghost' : '' ?>"><?php echo emt_label_for('rsmc_edate', __('Ending')) ?></dt>
    <dd class="end-date<? echo $sf_params->get('rsmc_daily', $object->getDaily()) ? ' ghost' : '' ?>"><?php echo input_hidden_tag('rsmc_edate') ?>
        <?php echo input_tag('rsmc_edate_dp', $sf_params->get('rsmc_edate_dp', $object->getDateTo('Y-m-d'))) ?></dd>
</dl>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), "@mycv-action?action=courses", 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
</div>
<?php
$data = sfDateTimeFormatInfo::getInstance('tr');

$json = json_encode(array('months' => implode(',', $data->getMonthNames()), 
                          'shortMonths' => implode(',', $data->getAbbreviatedMonthNames()), 
                          'days' => implode(',', $data->getDayNames()),
                          'shortDays' => implode(',', $data->getAbbreviatedDayNames())
                    )
        );
  ?>
<?php echo javascript_tag("
$(function(){
    $.tools.dateinput.localize('{$sf_user->getCulture()}', $json);
    $('#rsme_sdate_dp').dateinput({
        change: function() {
            var isoDate = this.getValue('yyyy-mm-dd');
            $('#rsme_sdate').val(isoDate);
        },
        min: '1900-01-01', max: 120, firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});
    $('#rsme_edate_dp').dateinput({
        change: function() {
            var isoDate = this.getValue('yyyy-mm-dd');
            $('#rsme_edate').val(isoDate);
        },
        min: '1900-01-01', max: 120, firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});
});
") ?>