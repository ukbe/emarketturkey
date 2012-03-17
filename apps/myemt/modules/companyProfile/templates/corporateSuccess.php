<?php use_helper('DateForm', 'Object') ?>

<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('companyProfile/editProfile', array('company' => $company)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section id="boxContent">
                <h4><?php echo __('Edit Corporate Information') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@company-corporate?hash={$company->getHash()}", 'novalidate=novalidate') ?>
<dl class="_table">
    <dt><?php echo emt_label_for('company_name', __('Company Name')) ?></dt>
    <dd><?php echo input_tag('company_name',$sf_params->get('company_name', $company->getName()), 'size=50 maxlength=255') ?><br />
                                         <span class="hint"><em><?php echo __('Example: Best Sellers Trading Co.') ?></em></span></dd>
    <dt><?php echo emt_label_for('business_sector', __('Sector')) ?></dt>
    <dd><?php echo select_tag('business_sector', options_for_select(BusinessSectorPeer::getOrderedNames(true), $sf_params->get('business_sector', $company->getSectorId()))) ?></dd>
    <dt><?php echo emt_label_for('business_type', __('Business Type')) ?></dt>
    <dd><?php echo select_tag('business_type', options_for_select(BusinessTypePeer::getOrderedNames(true), $sf_params->get('business_type', $company->getBusinessTypeId())), array('include_custom' => __('select a business type'))) ?></dd>
</dl>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get('comp_lang') : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(__('remove'), '', "class=ln-removelink") ?></div></dd>
    <dt><?php echo emt_label_for("comp_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("comp_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'comp_lang[]', 'include_blank' => true)) ?></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt><?php echo emt_label_for("introduction_$key", __('Introduction')) ?></dt>
    <dd><?php echo textarea_tag("introduction_$key", $sf_params->get("introduction_$key", $profile->getIntroduction($lang)), 'cols=52 rows=4 maxlength=2000') ?></dd>
    <dt><?php echo emt_label_for("productservice_$key", __('Products and Services')) ?></dt>
    <dd><?php echo textarea_tag("productservice_$key", $sf_params->get("productservice_$key", $profile->getProductService($lang)), 'cols=52 rows=4 maxlength=2000') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
    <dt><?php echo emt_label_for('founded_in_dp', __('Founded In')) ?></dt>
    <dd><?php echo input_hidden_tag('founded_in') ?>
        <?php echo input_tag('founded_in_dp', $sf_params->get('founded_in', $profile->getFoundedIn('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('employees', __('Number of Employees')) ?></dt>
    <dd><?php echo input_tag('employees',$sf_params->get('employees', $profile->getNoOfEmployees()), 'size=20 maxlength=200') ?></dd>
    <dt><?php echo emt_label_for('qc_staff', __('Number of Quality Control Staff')) ?></dt>
    <dd><?php echo input_tag('qc_staff',$sf_params->get('qc_staff', $profile->getNoOfQcStaff()), 'size=20 maxlength=200') ?></dd>
    <dt><?php echo emt_label_for('rd_staff', __('Number of R&D Staff')) ?></dt>
    <dd><?php echo input_tag('rd_staff',$sf_params->get('rd_staff', $profile->getNoOfRdStaff()), 'size=20 maxlength=200') ?></dd>
    <dt><?php echo emt_label_for('prod_line', __('Number of Production Lines')) ?></dt>
    <dd><?php echo input_tag('prod_line',$sf_params->get('prod_line', $profile->getNoOfProdLine()), 'size=20 maxlength=200') ?></dd>
    <dt><?php echo emt_label_for('certifications', __('Certifications')) ?></dt>
    <dd><?php echo textarea_tag('certifications',$sf_params->get('certifications', $profile->getCertifications()), 'cols=50 rows=3 maxlength=1000') ?></dd>
    <dt><?php echo emt_label_for('factory_size', __('Factory Size')) ?></dt>
    <dd><?php echo input_tag('factory_size',$sf_params->get('factory_size', $profile->getFactorySize()), 'size=15 maxlength=10 style=width:150px;').select_tag('factory_size_unit', options_for_select(CompanyProfilePeer::$fsTypeNames, $sf_params->get('factory_size_unit', $profile->getFactorySizeUnit()))) ?></dd>
    <dt><?php echo emt_label_for('export_percent_span', __('Export Percentage')) ?></dt>
    <dd><?php echo select_tag('export_percent_span', options_for_select(CompanyProfilePeer::$epTypeNames, $sf_params->get('export_percent_span', $profile->getExportPercentSpan()))) ?></dd>
    <dt></dt>
    <dd><?php echo submit_tag(__('Save'), 'class=green-button') ?></dd>
</dl>
</form>
            </section>
        </div>
        
    </div>

    <div class="col_180">

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
$('#boxContent').langform();

$.tools.dateinput.localize('{$sf_user->getCulture()}', $json);
$('#founded_in_dp').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#founded_in').val(isoDate);
    },
    yearRange: [-100, 100], selectors: true, min: '1900-01-01', max: '2023-01-01', firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});
") ?>