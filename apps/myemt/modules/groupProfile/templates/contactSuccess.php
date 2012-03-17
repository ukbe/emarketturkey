<?php use_helper('DateForm', 'Object') ?>

<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('groupProfile/editProfile', array('group' => $group)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Edit Contact Information') ?></h4>
                <?php echo form_errors() ?>
                <?php echo form_tag("@group-contact?hash={$group->getHash()}") ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for('group_email', __('Email')) ?></dt>
                    <dd><?php echo input_tag('group_email', $sf_params->get('group_email', $contact->getEmail()), 'maxlength=50 style=width:200px;') ?></dd>
                    <dt><?php echo emt_label_for('group_country', __('Country')) ?></dt>
                    <dd><?php echo select_country_tag('group_country', $sf_params->get('group_country', $work_address->getCountry()), array('include_custom' => __('select country'))) ?></dd>
                    <dt><?php echo emt_label_for('group_street', __('Street Address')) ?></dt>
                    <dd><?php echo input_tag('group_street', $sf_params->get('group_street', $work_address->getStreet()), 'maxlength=250 style=width:350px;') ?>
                             <em class="ln-example"><?php echo __('54th Hallway Rd.') ?></em></dd>
                    <dt><?php echo emt_label_for('group_state', __('State/Province')) ?></dt>
                    <dd><?php echo select_tag('group_state', options_for_select($contact_cities, $sf_params->get('group_state', $work_address->getState()), array('include_custom' => count($contact_cities)?__('select state/province'):__('select country')))) ?></dd>
                    <dt><?php echo emt_label_for('group_postalcode', __('Postal Code')) ?></dt>
                    <dd><?php echo input_tag('group_postalcode', $sf_params->get('group_postalcode', $work_address->getPostalCode()), 'maxlength=20 style=width:60px;') ?>
                             <em class="ln-example"><?php echo __('54367') ?></em></dd>
                    <dt><?php echo emt_label_for('group_city', __('City/Town')) ?></dt>
                    <dd><?php echo input_tag('group_city', $sf_params->get('group_city', $work_address->getCity()), 'maxlength=50 style=width:100px;') ?>
                             <em class="ln-example"><?php echo __('Arlington') ?></em></dd>
                    <dt><?php echo emt_label_for('group_phone', __('Phone Number')) ?></dt>
                    <dd><?php echo input_tag('group_phone', $sf_params->get('group_phone', $work_phone->getPhone()), 'maxlength=30 style=width:130px;') ?>
                             <em class="ln-example"><?php echo __('+66 666 6666666') ?></em></dd>
                    <dt><?php echo emt_label_for('group_fax', __('Fax Number')) ?></dt>
                    <dd><?php echo input_tag('group_fax', $sf_params->get('group_fax', $fax_number->getPhone()), 'maxlength=30 style=width:130px;') ?>
                             <em class="ln-example"><?php echo __('+66 666 6666666') ?></em></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?>&nbsp;&nbsp;<?php echo link_to(__('Cancel Changes'), "@edit-group-profile?hash={$group->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
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
    $('#group_country').location({url: '".url_for('@location-query')."'});
") ?>