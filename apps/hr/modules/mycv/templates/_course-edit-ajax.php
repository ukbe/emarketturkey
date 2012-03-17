<?php
$data = sfDateTimeFormatInfo::getInstance('tr');

$json = json_encode(array('months' => implode(',', $data->getMonthNames()), 
                          'shortMonths' => implode(',', $data->getAbbreviatedMonthNames()), 
                          'days' => implode(',', $data->getDayNames()),
                          'shortDays' => implode(',', $data->getAbbreviatedDayNames())
                    )
        );
  ?>
<emtAjaxResponse>
<emtInit>
<?php echo "
$('#ajx-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });

$.tools.dateinput.localize('{$sf_user->getCulture()}', $json);
$('#rsmc_sdate_dp').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#rsmc_sdate').val(isoDate);
    },
    min: '1900-01-01', max: 120, firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});
$('#rsmc_edate_dp').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#rsmc_edate').val(isoDate);
    },
    min: '1900-01-01', max: 120, firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});

$('dl._table input').customInput();
" ?>
</emtInit>
<emtHeader>
<?php if ($object->isNew()): ?>
<?php echo __('Add New Course/Certificate Item') ?>
<?php else: ?>
<?php echo __('Editing Course/Certificate Information') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
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
    <dd><?php echo checkbox_tag('rsmc_daily', 1, $sf_params->get('rsmc_daily', $object->getDaily()), array('onchange' => "if ($(this).is(':checked')) $('.end-date').hide(); else $('.end-date').show();")) ?></dd>
    <dt class="end-date<? echo $sf_params->get('rsmc_daily', $object->getDaily()) ? ' ghost' : '' ?>"><?php echo emt_label_for('rsmc_edate', __('Ending')) ?></dt>
    <dd class="end-date<? echo $sf_params->get('rsmc_daily', $object->getDaily()) ? ' ghost' : '' ?>"><?php echo input_hidden_tag('rsmc_edate') ?>
        <?php echo input_tag('rsmc_edate_dp', $sf_params->get('rsmc_edate_dp', $object->getDateTo('Y-m-d'))) ?></dd>
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