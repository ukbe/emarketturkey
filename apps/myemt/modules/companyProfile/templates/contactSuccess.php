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
            <section>
                <h4><?php echo __('Edit Contact Information') ?></h4>
                <?php echo form_errors() ?>
                <?php echo form_tag("@company-contact?hash={$company->getHash()}") ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for('work_country', __('Country')) ?></dt>
                    <dd><?php echo select_country_tag('work_country', $sf_params->get('work_country', $work_address->getCountry()), array('include_custom' => __('select country'))) ?></dd>
                    <dt><?php echo emt_label_for('work_street', __('Street Address')) ?></dt>
                    <dd><?php echo input_tag('work_street', $sf_params->get('work_street', $work_address->getStreet()), 'size=50') ?><br />
                             <em class="ln-example"><?php echo __('54th Hallway Rd.') ?></em></dd>
                    <dt><?php echo emt_label_for('work_state', __('State/Province')) ?></dt>
                    <dd><?php echo select_tag('work_state', options_for_select($contact_cities, $sf_params->get('work_state', $work_address->getState()), array('include_custom' => count($contact_cities)?__('select state/province'):__('select country')))) ?></dd>
                    <dt><?php echo emt_label_for('work_postalcode', __('Postal Code')) ?></dt>
                    <dd><?php echo input_tag('work_postalcode', $sf_params->get('work_postalcode', $work_address->getPostalCode()), 'size=10') ?><br />
                             <em class="ln-example"><?php echo __('54367') ?></em></dd>
                    <dt><?php echo emt_label_for('work_city', __('City/Town')) ?></dt>
                    <dd><?php echo input_tag('work_city', $sf_params->get('work_city', $work_address->getCity()), 'size=25') ?><br />
                             <em class="ln-example"><?php echo __('Arlington') ?></em></dd>
                    <dt><?php echo emt_label_for('work_phone', __('Phone Number')) ?></dt>
                    <dd><?php echo input_tag('work_phone', $sf_params->get('work_phone', $work_phone->getPhone()), 'size=20') ?><br />
                             <em class="ln-example"><?php echo __('+66 666 6666666') ?></em></dd>
                    <dt><?php echo emt_label_for('fax_number', __('Fax Number')) ?></dt>
                    <dd><?php echo input_tag('fax_number', $sf_params->get('fax_number', $fax_number->getPhone()), 'size=20') ?><br />
                             <em class="ln-example"><?php echo __('+66 666 6666666') ?></em></dd>
                    <dt><?php echo emt_label_for('web_url', __('Web Site')) ?></dt>
                    <dd><?php echo input_tag('web_url', $sf_params->get('web_url', $company->getUrl()), 'size=30') ?><br />
                             <em class="ln-example"><?php echo __('http://www.companysite.com') ?></em></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?>&nbsp;&nbsp;<?php echo link_to(__('Cancel Changes'), "@edit-company-profile?hash={$company->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
                </dl>
                </form>
            </section>
        </div>
        
    </div>

    <div class="col_180">

    </div>
    
</div>
<?php use_javascript('emt-location-1.0.js') ?>
<?php echo javascript_tag("
    $('#work_country').location({url: '".url_for('@location-query')."'});
") ?>