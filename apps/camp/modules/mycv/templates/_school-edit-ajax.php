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
    
$('dl._table input').customInput();
" ?>
</emtInit>
<emtHeader>
<?php if ($object->isNew()): ?>
<?php echo __('Add New Education Item') ?>
<?php else: ?>
<?php echo __('Editing Education Information') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=education', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsme_school', __('School')) ?></dt>
    <dd><?php echo input_tag('rsme_school',$sf_params->get('rsme_school', $object->getSchool()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsme_degree_id', __('Grade')) ?></dt>
    <dd><?php echo select_tag('rsme_degree_id', options_for_select(ResumeSchoolDegreePeer::getSortedList(), $sf_params->get('rsme_degree_id', $object->getDegreeId()), array('include_custom' => __('school degree')))) ?></dd>
    <dt><?php echo emt_label_for('rsme_major', __('Major')) ?></dt>
    <dd><?php echo input_tag('rsme_major',$sf_params->get('rsme_major', $object->getMajor()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsme_sdate', __('Beginning')) ?></dt>
    <dd><?php echo input_hidden_tag('rsme_sdate') ?>
        <?php echo input_tag('rsme_sdate_dp', $sf_params->get('rsme_sdate_dp', $object->getDateFrom('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('rsme_present', __('Present')) ?></dt>
    <dd><?php echo checkbox_tag('rsme_present', 1, $sf_params->get('rsme_present', $object->getPresent()), array('onchange' => "if ($(this).is(':checked')) $('.end-date').hide(); else $('.end-date').show();")) ?></dd>
    <dt class="end-date<? echo $sf_params->get('rsme_present', $object->getPresent()) ? ' ghost' : '' ?>"><?php echo emt_label_for('rsme_edate', __('Ending')) ?></dt>
    <dd class="end-date<? echo $sf_params->get('rsme_present', $object->getPresent()) ? ' ghost' : '' ?>"><?php echo input_hidden_tag('rsme_edate') ?>
        <?php echo input_tag('rsme_edate_dp', $sf_params->get('rsme_edate_dp', $object->getDateTo('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('rsme_subjects', __('Subjects')) ?></dt>
    <dd><?php echo textarea_tag('rsme_subjects', $sf_params->get('rsme_subjects', $object->getSubjects()), array('cols' => 53, 'rows' => 4, 'max' => 5)) ?> 
        <em class="ln-example"><?php echo __('You may specify some subjects you have studied. (max. 900 characters)') ?></em></dd>
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