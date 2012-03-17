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
$('#rsmw_sdate_dp').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#rsmw_sdate').val(isoDate);
    },
    min: '1900-01-01', max: 120, firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});
$('#rsmw_edate_dp').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#rsmw_edate').val(isoDate);
    },
    min: '1900-01-01', max: 120, firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});

$('dl._table input').customInput();
" ?>
</emtInit>
<emtHeader>
<?php if ($object->isNew()): ?>
<?php echo __('Add New Work Experience Item') ?>
<?php else: ?>
<?php echo __('Editing Work Experience Item') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
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
        <?php echo input_tag('rsmw_edate_dp', $sf_params->get('rsmw_edate_dp', $object->getDateTo('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('rsmw_projects', __('Projects')) ?></dt>
    <dd><?php echo textarea_tag('rsmw_projects', $sf_params->get('rsmw_projects', $object->getProjects()), array('cols' => 53, 'rows' => 4, 'max' => 5)) ?>
        <em class="ln-example"><?php echo __('You may specify some projects you have worked on. (max. 900 characters)') ?></em></dd>
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