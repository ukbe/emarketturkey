<?php use_helper('DateForm', 'Number') ?>
<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_576" style="margin: 0px 90px;">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4 class="cart-icon"><?php echo __('Check Out') ?></h4>
                <div class="hrsplit-1"></div>
                <h5><?php echo __('Invoice Details') ?></h5>
                <dl class="_table">
                    <dt><?php echo emt_label_for('co_bill_to', __('Bill To')) ?></dt>
                    <dd><?php echo input_tag('co_bill_to', $sf_params->get('co_bill_to'), 'maxlength=250') ?></dd>
                    <dt><?php echo emt_label_for('co_country', __('Country')) ?></dt>
                    <dd><?php echo select_country_tag('co_country', $sf_params->get('co_country')) ?></dd>
                    <dt><?php echo emt_label_for('co_street_address', __('Street Address')) ?></dt>
                    <dd class="floattail"><?php echo input_tag('co_street_address', $sf_params->get('co_street_address'), 'maxlength=250 style=width:220px;') ?></dd>
                    <dt class="floattail"><?php echo emt_label_for('co_city', __('City')) ?></dt>
                    <dd class="floattail"><?php echo input_tag('co_city', $sf_params->get('co_city'), 'maxlength=50 style=width:100px;') ?></dd>
                    <dt><?php echo emt_label_for('co_state', __('State')) ?></dt>
                    <dd class="floattail"><?php echo input_tag('co_state', $sf_params->get('co_state'), 'maxlength=50 style=width:100px;') ?></dd>
                    <dt class="floattail"><?php echo emt_label_for('co_zip', __('Zip')) ?></dt>
                    <dd class="floattail"><?php echo input_tag('co_zip', $sf_params->get('co_zip'), 'maxlength=20 style=width:60px;') ?></dd>
                    <dt><?php echo emt_label_for('co_phone', __('Phone Number')) ?></dt>
                    <dd class="floattail"><?php echo input_tag('co_phone', $sf_params->get('co_phone'), 'maxlength=30 style=width:130px;') ?></dd>
                    <dt class="floattail"><?php echo emt_label_for('co_fax', __('Fax Number')) ?></dt>
                    <dd class="floattail"><?php echo input_tag('co_fax', $sf_params->get('co_fax'), 'maxlength=30 style=width:130px;') ?></dd>
                    <dt class="reg-info"></dt>
                    <dd class="reg-info"><?php echo link_to_function(__('Include Registration Information'), "$('.reg-info').toggleClass('ghost');", 'class=bluelink expcoll') ?></dt>
                    <dt class="reg-info ghost"><?php echo emt_label_for('co_tax_reg_party', __('Tax Registrar')) ?></dt>
                    <dd class="reg-info ghost floattail"><?php echo input_tag('co_tax_reg_party', $sf_params->get('co_tax_reg_party'), 'maxlength=100 style=width:130px;') ?></dd>
                    <dt class="reg-info ghost floattail"><?php echo emt_label_for('co_tax_reg_id', __('Tax Registration ID')) ?></dt>
                    <dd class="reg-info ghost floattail"><?php echo input_tag('co_tax_reg_id', $sf_params->get('co_tax_reg_id'), 'maxlength=50 style=width:100px;') ?></dd>
                    <dt class="reg-info ghost"><?php echo emt_label_for('co_reg_id', __('Registration ID')) ?></dt>
                    <dd class="reg-info ghost"><?php echo input_tag('co_reg_id', $sf_params->get('co_reg_id'), 'maxlength=30 style=width:100px;') ?></dd>
                    <dt class="reg-info ghost"></dt>
                    <dd class="reg-info ghost"><?php echo link_to_function(__('Remove Registration Information'), "$('.reg-info').toggleClass('ghost');", 'class=bluelink expcoll on') ?></dt>
                </dl>
                <br class="clear" />
                <h5><?php echo __('Payment Details') ?></h5>
                <dl class="_table">
                    <dt><?php echo emt_label_for('amount', __('Amount')) ?></dt>
                    <dd style="font: bold 16px helvetica">
                        <?php foreach ($totals as $curr => $amount): ?>
                        <?php echo format_currency($amount) . ' ' . $curr ?>
                        <?php endforeach ?>
                    </dd>
                    <dt><?php echo emt_label_for('currency', __('Currency')) ?></dt>
                    <dd style="font: bold 16px helvetica">
                        <?php $sfc = sfCultureInfo::getInstance() ?>
                        <?php foreach ($totals as $curr => $amount): ?>
                        <?php echo $sfc->getCurrency($curr) ?>
                        <?php endforeach ?>
                    </dd>
                </dl>
                <br class="clear" />
                <?php echo __('Please select a payment method') ?>
                <div class="hrsplit-1"></div>
<div id="accordion">
    <h3><a href="#"><?php echo __('Credit Card') ?></a></h3>
    <div>
    <style>
        dl.narrow dd { width: auto !important; }
    </style>
        <?php echo form_tag('@checkout') ?>
        <?php echo input_hidden_tag('commit', 1) ?>
        <?php echo input_hidden_tag('pmeth', 1) ?>
        <dl class="_table narrow">
            <dt><?php echo emt_label_for('co_credit_type', __('Card Type')) ?></dt>
            <dd><?php echo select_tag('co_credit_type', options_for_select(array(1 => 'Mastercard', 2 => 'Visa'), $sf_params->get('co_credit_type'), array('include_custom' => __('Please Select')))) ?></dd>
            <dt><?php echo emt_label_for('co_credit_owner', __('Card Owner')) ?></dt>
            <dd><?php echo input_tag('co_credit_owner', $sf_params->get('co_credit_owner'), 'maxlength=40 style=width:240px;') ?></dd>
            <dt><?php echo emt_label_for('co_credit_number', __('Credit Card Number')) ?></dt>
            <dd><?php echo input_tag('co_credit_number', $sf_params->get('co_credit_number'), 'maxlength=16 style=width:116px;') ?></dd>
            <dt><?php echo emt_label_for(array('co_credit_exp_month', 'co_credit_exp_year'), __('Expiration Date')) ?></dt>
            <dd><?php echo select_tag('co_credit_exp_month', options_for_select(array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'), $sf_params->get('co_credit_exp_month'))) ?>
                <?php echo select_year_tag('co_credit_exp_year', $sf_params->get('co_credit_exp_year'), array('year_start' => date('Y'), 'year_end' => date('Y') + 15)) ?></dd>
            <dt><?php echo emt_label_for('co_credit_cv2', __('CV2')) ?></dt>
            <dd><?php echo input_tag('co_credit_cv2', $sf_params->get('co_credit_cv2'), 'maxlength=6 style=width:50px;') ?></dd>
            <dt></dt>
            <dd><?php echo checkbox_tag('co_confirm') ?><?php echo emt_label_for('co_confirm', __('I accept terms and conditions')) ?></dd>
            <dt></dt>
            <dd><?php echo submit_tag(__('Make Payment'), 'class=green-button') ?></dd>
        </dl>
        </form>
    </div>
    <h3><a href="#"><?php echo __('Paypal') ?></a></h3>
    <div>
    </div>
    <h3><a href="#"><?php echo __('Wire Transfer') ?></a></h3>
    <div>
    </div>
</div>
<?php use_javascript('jquery.ui-1.8.16.accordion.js') ?>
<?php echo javascript_tag("
$(document).ready(function() {
    $('#accordion').accordion({active: 'false', collapsible: 'true', change: function(e,ui){}});
  });
") ?>
                <?php echo __('') ?>
            </section>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
        <h3><?php echo __('Secure Check Out') ?></h3>
        <div class="smalltext t_grey">
            <?php echo image_tag('layout/ssl-your-safe.png') ?>
            <?php echo __('You are secured with high-level SSL encryption.') ?>
            <!-- BEGIN DigiCert Site Seal Code --><div id="digicertsitesealcode" class="txtLeft"><script language="javascript" type="text/javascript" src="https://www.digicert.com/custsupport/sealtable.php?order_id=00246390&amp;seal_type=a&amp;seal_size=medium&amp;seal_color=blue&amp;new=1&amp;newmedium=1"></script><a href="http://www.digicert.com/">SSL Certificate</a><script language="javascript" type="text/javascript">coderz();</script></div><!-- END DigiCert Site Seal Code -->
            <div class="hrsplit-2"></div>
        </div>
        </div>
    </div>
    
</div>
