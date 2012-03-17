<?php use_helper('Date', 'DateForm') ?>
<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>
<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section id="boxContent">
                <h4><?php echo $job->isNew() ? __('Post Job') : __('Edit Job') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("$route&action=post", 'novalidate=novalidate enctype=multipart/form-data') ?>
<h5><?php echo __('Job Details') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("job_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("job_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("job_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'job_lang[]', 'include_blank' => true)) ?></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("job_title_$key", __('Job Title')) ?></dt>
    <dd><?php echo input_tag("job_title_$key", $sf_params->get("job_title_$key"), 'maxlength=250') ?></dd>
    <dt class="_req"><?php echo emt_label_for("job_description_$key", __('Description')) ?></dt>
    <dd><?php echo textarea_tag("job_description_$key", $sf_params->get("job_description_$key"), 'maxlength=10000 rows=5') ?></dd>
    <dt><?php echo emt_label_for("job_responsibilities_$key", __('Responsibilities')) ?></dt>
    <dd><?php echo textarea_tag("job_responsibilities_$key", $sf_params->get("job_responsibilities_$key"), 'maxlength=10000 rows=5') ?></dd>
    <dt><?php echo emt_label_for("job_requirements_$key", __('Requirements')) ?></dt>
    <dd><?php echo textarea_tag("job_requirements_$key", $sf_params->get("job_requirements_$key"), 'maxlength=10000 rows=5') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'act greenspan plus-13px ln-addlink')) ?></dd>
    <dt><?php echo emt_label_for('job_function', __('Job Function')) ?></dt>
    <dd><?php echo select_tag('job_function', options_for_select(JobFunctionPeer::getSortedList(), $sf_params->get('job_function'), array('include_custom' => __('(optional)')))) ?></dd>
    <dt><?php echo emt_label_for('job_position_level', __('Position Level')) ?></dt>
    <dd><?php echo select_tag('job_position_level', options_for_select(JobGradePeer::getSortedList(), $sf_params->get('job_position_level'), array('include_custom' => __('(optional)')))) ?></dd>
    <dt><?php echo emt_label_for('job_working_scheme', __('Attendence')) ?></dt>
    <dd><?php echo select_tag('job_working_scheme', options_for_select(JobWorkingSchemePeer::getSortedList(), $sf_params->get('job_working_scheme'), array('include_custom' => __('(optional)')))) ?></dd>
    <?php $exp = array(1 => "1 " . __('Year')); for ($i=2; $i<11; $i++) $exp[$i] = "$i " . __('Years'); $exp['11'] = __('1..5 Years'); $exp['12'] = __('6..10 Years'); $exp['13'] = __('11..15 Years'); $exp['14'] = __('16..20 Years');  ?>
    <dt><?php echo emt_label_for('job_experience', __('Experience')) ?></dt>
    <dd><?php echo select_tag('job_experience', options_for_select($exp, $sf_params->get('job_experience'), array('include_custom' => __('(optional)')))) ?></dd>
    <dt><?php echo emt_label_for('job_education_level', __('Education Level')) ?></dt>
    <dd><div class="two_columns" style="width: 417px;">
        <?php foreach (ResumeSchoolDegreePeer::getSortedList(null, true, ResumeSchoolDegreePeer::RSC_DEG_SORT_LEVEL_SEQ) as $key => $label): ?>
        <?php echo checkbox_tag("job_education_level[$key]", 1, $sf_params->get("job_education_level[$key]")) ?>
        <?php echo emt_label_for("job_education_level[$key]", $label) ?>
        <?php endforeach ?></div>
        </dd>
    <dt><?php echo emt_label_for('job_gender', __('Gender')) ?></dt>
    <dd><?php echo select_tag('job_gender', options_for_select(array(0 => __("Doesn't matter"), 1 => __('Male'), 2 => __('Female')), $sf_params->get('job_gender'))) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Custom Details') ?></h5>
<dl class="_table">
    <dt><?php echo emt_label_for('job_special_case', __('Special Cases')) ?></dt>
    <dd class="two_columns"><?php foreach (JobSpecialCasesPeer::getSpecialCases() as $case): ?>
        <?php echo checkbox_tag("job_special_case[{$case->getId()}]", 1, $sf_params->get("job_special_case[{$case->getId()}]")) ?>
        <?php echo emt_label_for("job_special_case[{$case->getId()}]", $case->getName()) ?>
        <?php endforeach ?></dd>
    <dt><?php echo emt_label_for('job_smoker', __('Smoker/Non-Smoker')) ?></dt>
    <dd class="two_columns">
        <?php echo radiobutton_tag("job_smoker", 2, $sf_params->get("job_smoker") == 2, 'id=job_smoker_2') ?>
        <?php echo emt_label_for("job_smoker_2", __("Smoker")) ?>
        <?php echo radiobutton_tag("job_smoker", 3, $sf_params->get("job_smoker") == 3, 'id=job_smoker_3') ?>
        <?php echo emt_label_for("job_smoker_3", __("Non-Smoker")) ?>
        <?php echo radiobutton_tag("job_smoker", 1, $sf_params->get("job_smoker") == 1, 'id=job_smoker_1') ?>
        <?php echo emt_label_for("job_smoker_1", __("Doesn't matter")) ?>
    </dd>
    <dt><?php echo emt_label_for('job_dr_license', __("Driver's License Requirement")) ?></dt>
    <dd class="two_columns"><?php foreach (ResumePeer::$licenseLabels as $key => $label): ?>
        <?php echo checkbox_tag("job_dr_license[$key]", 1, $sf_params->get("job_dr_license[$key]")) ?>
        <?php echo emt_label_for("job_dr_license[$key]", __($label)) ?>
        <?php endforeach ?>
    </dd>
    <dt><?php echo emt_label_for('job_travel', __('Travel Percent')) ?></dt>
    <dd class="L-floater"> <?php echo input_hidden_tag('job_travel', $sf_params->get('job_travel', 0)) ?>
        <div id="job_travel_slider" style="width: 200px;"></div><span id="job_travel_label" class="slider-label-inline"><?php echo $sf_params->get('job_travel', 0) ?>%</span>
        <span class="ln-example"><?php echo __('Slide the disc to specify the maximum travel percentage.') ?></span>
    <?php use_javascript('jquery.ui-1.8.16.slider.js'); ?>
    <?php echo javascript_tag("
    $('#job_travel_slider').slider({
            range: 'min',
            value: {$sf_params->get('job_travel', 0)},
            min: 0,
            max: 100,
            step: 10,
            slide: function( event, ui ) {
                $('#job_travel_label').text(ui.value + '%');
                $('#job_travel').val(ui.value);
            }
        });
    ") ?></dd>
    <dt><?php echo emt_label_for(array('job_sallary_currency', 'job_sallary_type', 'job_sallary_exact', 'job_sallary_start_span', 'job_sallary_end_span'), __('Net Sallary')) ?></dt>
    <dd id="dd-sallary" class="L-floater">
        <?php echo select_currency_tag('job_sallary_currency', $sf_params->get('job_sallary_currency'), array('display' => 'code', 'include_custom' => __('Currency'))) ?>
        <?php echo select_tag('job_sallary_type', options_for_select(array(1 => __('Exact Value ..'), 2 => __('Between ..')), $sf_params->get('job_sallary_type'), array('include_custom' => __('Please Select')))) ?>
        <div id="sallary-exact-div">
        <?php echo input_tag('job_sallary_exact', $sf_params->get('job_sallary_exact'), 'style=width:60px maxlength=20') ?>
        </div>
        <div id="sallary-span-div">
            <?php echo input_tag('job_sallary_start_span', $sf_params->get('job_sallary_start_span'), 'style=width:60px maxlength=20') ?>-<?php echo input_tag('job_sallary_end_span', $sf_params->get('job_sallary_end_span'), 'style=width:60px maxlength=20') ?>
        </div>
        <div class="clear">
            <span id="sallary-exact-tip" class="ln-example"><?php echo __('Enter sallary amount.') ?></span>
            <span id="sallary-span-tip" class="ln-example"><?php echo __('Enter sallary lowest and highest amounts.') ?></span>
        </div></dd>
    <dt><?php echo emt_label_for(array('job_mservice', 'job_mservice_numyear'), __('Military Service')) ?></dt>
    <dd>
        <div class="two_columns">
            <?php echo radiobutton_tag("job_mservice", 1, $sf_params->get("job_mservice") == 1, 'id=job_mservice_1') ?>
            <?php echo emt_label_for("job_mservice_1", __("Doesn't matter")) ?>
            <?php echo radiobutton_tag("job_mservice", 2, $sf_params->get("job_mservice") == 2, 'id=job_mservice_2') ?>
            <?php echo emt_label_for("job_mservice_2", __("Performed")) ?>
            <div class="L-floater">
            <?php echo radiobutton_tag("job_mservice", 3, $sf_params->get("job_mservice") == 3, 'id=job_mservice_3') ?>
            <?php echo emt_label_for("job_mservice_3", __("Postponed ..")) ?>
            <?php echo select_tag('job_mservice_numyear', options_for_select(array(1 => __('1 year'), 2 => __('%1 years', array('%1' => 2)), 3 => __('%1 years', array('%1' => 3)), 4 => __('%1 years', array('%1' => 4)), 5 => __('%1 years', array('%1' => 5))), $sf_params->get('job_mservice_myear')), 'style=width:auto;') ?>
            </div>
        </div>
        <div class="clear">
            <span id="mservice-tip" class="ln-example ghost"><?php echo __('Select minimum allowed postponed year amount.') ?></span>
        </div>
    </dd>
</dl>
<h5 class="clear"><?php echo __('Location and Number of Personel') ?></h5>
<?php foreach ($sf_params->get("job_country", $countries) as $key => $country): ?>
<dl class="_table lc-part">
    <dt class="_req"><?php echo emt_label_for("job_country_$key", __('Country')) ?></dt>
    <dd><?php echo select_country_tag("job_country_$key", $country, array('name' => 'job_country[]', 'class' => 'lc-country', 'include_blank' => true)) ?><span class="error lc-st-error ghost"><?php echo __('Error Occured') ?></span></dd>
    <dt><?php echo emt_label_for("job_state_$key", __('Region')) ?></dt>
    <dd><?php echo select_tag("job_state_$key", options_for_select($this->cities = GeonameCityPeer::getCitiesFor($country), $sf_params->get("job_state_$key"), array('include_custom' => __('select state/province'))), array('class' => 'lc-state')) ?></dd>
    <dt class="_req"><?php echo emt_label_for("job_personel_$key", __('Number of Staff')) ?></dt>
    <dd><?php echo input_tag("job_personel_$key", $sf_params->get("job_personel_$key"), array('class' => 'lc-personel', 'style' => 'width: 50px;')) ?></dd>
    <dt class="ghost"></dt>
    <dd class="lc-view ghost"><ul>
            <li class="pin"></li>
            <li class="lc-info"><div class="personel"><?php echo __('%1 personel', array('%1' => '<span class="lc-personel"></span>')) ?></div><span class="lc-state"></span><span class="lc-country"></span></li>
            <li class="lc-removelink"><?php echo link_to_function('&nbsp;', '', 'class=lc-removelink') ?></li>
        </ul></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Another Location' ), '', array('class' => 'act greenspan plus-13px lc-addlink')) ?></dd>
    <dt></dt>
    <dd><div class="_right"><?php echo submit_tag(__('Continue'), 'class=green-button') ?></div></dd>
</dl>

</form>
            </section>
        </div>
    </div>
</div>
<style>
#dd-sallary select { margin-right: 5px; }
#dd-sallary input { margin: 0px 5px; }
</style>
<?php echo javascript_tag("

$(function() {
    
    $('#boxContent').langform();

    $('#boxContent').locform({queryUrl: '".url_for('profile/locationQuery')."'});

    $('dl._table input').customInput();
    
    $('#job_sallary_type').branch({method: 'class', map: {1: '#sallary-exact-div, #sallary-exact-tip', 2: '#sallary-span-div, #sallary-span-tip'}});
    
    $('input[type=\"radio\"][name=job_mservice]').click(function(){if (this.value == 3) $('#job_mservice_numyear, #mservice-tip').removeClass('ghost'); else $('#job_mservice_numyear, #mservice-tip').addClass('ghost');});
    if ($('#job_mservice_3').is(':checked')) $('#job_mservice_numyear, #mservice-tip').removeClass('ghost'); else $('#job_mservice_numyear, #mservice-tip').addClass('ghost');

});

") ?>