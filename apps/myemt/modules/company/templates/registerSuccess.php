<?php slot('subNav') ?>
<?php include_partial('subNav-register', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">

    <div class="col_678" style="margin-left: 100px;">
        <div class="box_678 _titleBG_Transparent">
            <div id="boxContent" class="_noBorder">
                <div class="_right t_grey" style="border: solid 1px #eee; font-size: 11px; font-family: arial; background: #f5f5f5 url(/images/layout/asterix_red.png) no-repeat 4px center; padding: 0px 5px 0px 15px; border-radius: 2px;"><?php echo __('All fields are required') ?></div>
                <div class="hrsplit-3"></div>
                <?php if (isset($errorWhileSaving) && $errorWhileSaving == true): ?>
                <div id="error">
                    <h3><?php echo __('Error Occured!') ?></h3>
                    <div class="t_red pad-2">
                    <?php echo __('An error occurred while registering your company.<br />We are sorry for the inconvenience and working to work out the problem yet.') ?>
                    </div>
                </div>
                <div class="hrsplit-2"></div>
                <?php elseif (form_errors()): ?>
                <div><?php echo form_errors() ?></div>
                <div class="hrsplit-2"></div>
                <?php endif ?>
                <?php echo form_tag('company/register') ?>
                <?php echo input_hidden_tag('keepon', $sf_params->get('keepon')) ?>

                <dl class="_table signup">
                    <dt><?php echo emt_label_for('company_name', __('Company Name')) ?></dt>
                    <dd><?php echo input_tag('company_name', $sf_request->getParameter('company_name'), 'style=width:400px; maxlength=255') ?><br />
                            <em class="ln-example"><?php echo __('Best Sellers Trading Co.') ?></em></dd>
                    <dt><?php echo emt_label_for('company_industry', __('Business Sector')) ?></dt>
                    <dd><?php echo select_tag('company_industry', options_for_select(BusinessSectorPeer::getOrderedNames(true), $sf_params->get('company_industry'), array('include_custom' => '-- ' . __('select industry') . ' --'))) ?></dd>
                    <dt><?php echo emt_label_for('company_business_type', __('Business Type')) ?></dt>
                    <dd><?php echo select_tag('company_business_type', options_for_select(BusinessTypePeer::getOrderedNames(true), $sf_params->get('company_business_type'), array('include_custom' => '-- ' . __('select business type') . ' --'))) ?></dd>
                </dl>
                <?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get('company_lang') : array($sf_user->getCulture())) as $key => $lang): ?>
                <dl class="_table signup ln-part">
                    <dt></dt>
                    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(__('remove'), '', "class=ln-removelink") ?></div></dd>
                    <dt><?php echo emt_label_for("company_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
                    <dd><?php echo select_language_tag("company_lang_$key", $lang, array('languages' => sfConfig::get('app_i18n_cultures'), 'class' => 'ln-select', 'name' => 'company_lang[]', 'include_blank' => true)) ?></dd>
                    <dt></dt>
                    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
                    <dt><?php echo emt_label_for("company_introduction_$key", __('Introduction')) ?></dt>
                    <dd><?php echo textarea_tag("company_introduction_$key", $sf_params->get("company_introduction_$key"), 'cols=52 rows=4 maxlength=2000 style=width:400px;') ?></dd>
                    <dt><?php echo emt_label_for("company_productservice_$key", __('Products and Services')) ?></dt>
                    <dd><?php echo textarea_tag("company_productservice_$key", $sf_params->get("company_productservice_$key"), 'cols=52 rows=4 maxlength=2000 style=width:400px;') ?></dd>
                </dl>
                <?php endforeach ?>
                <dl class="_table signup">
                    <dt></dt>
                    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
                    <dt><?php echo emt_label_for('company_country', __('Country')) ?></dt>
                    <dd><?php echo select_country_tag('company_country', $sf_params->get('company_country'), array('include_custom' => '-- ' . __('select country') . ' --')) ?></dd>
                    <dt><?php echo emt_label_for('company_street', __('Street Address')) ?></dt>
                    <dd><?php echo input_tag('company_street', $sf_params->get('company_street'), 'style=width:400px; maxlength=255') ?>
                             <em class="ln-example"><?php echo __('54th Hallway Rd.') ?></em></dd>
                    <dt><?php echo emt_label_for('company_state', __('State/Province')) ?></dt>
                    <dd><?php echo select_tag('company_state', options_for_select($contact_cities, $sf_params->get('company_state'), array('include_custom' => '-- ' . __('select state/province') . ' --'))) ?></dd>
                    <dt><?php echo emt_label_for('company_postalcode', __('Postal Code')) ?></dt>
                    <dd><?php echo input_tag('company_postalcode', $sf_params->get('company_postalcode'), 'style=width:80px;') ?>
                             <em class="ln-example"><?php echo __('54367') ?></em></dd>
                    <dt><?php echo emt_label_for('company_city', __('City/Town')) ?></dt>
                    <dd><?php echo input_tag('company_city', $sf_params->get('company_city'), 'style=width:150px; maxlength=50') ?>
                             <em class="ln-example"><?php echo __('Arlington') ?></em></dd>
                    <dt><?php echo emt_label_for('company_phone', __('Phone Number')) ?></dt>
                    <dd><?php echo input_tag('company_phone', $sf_params->get('company_phone'), 'style=width:150px; maxlength=50') ?>
                             <em class="ln-example"><?php echo __('+66 666 6666666') ?></em></dd>
                    <dt>&nbsp;</dt>
                    <dd><?php echo __('By clicking Register Company, you are indicating that you have read and agree to the %1s and %2s.', array('%1s' => link_to(__('Terms of Use'), '@lobby.terms', 'target=emt_terms class=inherit-font bluelink t_hover'), '%2s' => link_to(__('Privacy Policy'), '@lobby.privacy', 'target=emt_privacy class=inherit-font bluelink t_hover'))) ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Register Company'), 'class=green-button') ?></dd>
                </dl>
                </form>
            </div>
            <table class="_secured" style="margin: 0 auto;">
                <tr>
                    <td><?php echo __('You are secured with:')?></td>
                    <td class="margin-r2"><a href="//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_s" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_s.png" alt="TRUSTe online privacy certification"/></a></td>
                    <td><!-- BEGIN DigiCert Site Seal Code --><div id="digicertsitesealcode"><script language="javascript" type="text/javascript" src="https://www.digicert.com/custsupport/sealtable.php?order_id=00246390&amp;seal_type=a&amp;seal_size=small&amp;seal_color=blue&amp;new=1&amp;newsmall=1"></script><a href="http://www.digicert.com/">SSL Certificate</a><script language="javascript" type="text/javascript">coderz();</script></div><!-- END DigiCert Site Seal Code --></td>
                </tr>
            </table>
        </div>
        <div class="box_678 _titleBG_Transparent">
            <div class="_noBorder">

            </div>
        </div>
    </div>
</div>

<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222;
margin: 0px; padding: 5px 10px; border-bottom: none; }
dl._table.signup dt { width: 25%; }
dl._table.signup dd { width:  65%;}
</style>
<?php use_javascript('emt-location-1.0.js') ?>
<?php use_javascript('emt.langform-1.0.js') ?>
<?php echo javascript_tag("
    $('#company_country').location({url: '".url_for('@location-query', true)."'});
    $('#boxContent').langform();
") ?>