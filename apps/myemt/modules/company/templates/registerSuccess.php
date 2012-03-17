<?php use_helper('DateForm', 'Object') ?>
<div class="column span-198">
<div class="column span-39">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li class="last"><?php echo __('Register Company') ?></li>
</ol>
</div>
<ol class="column command-menu">
<li></li>
</ol>
<ol class="inline-form">
<li></li></ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-137 pad-2 prepend-4">
<h2 style="font: tahoma; color: #737373; border-bottom: solid 3px #A4A9A6; padding: 3px; margin-bottom: 20px;"><?php echo __('Register Company') ?></h2>
<p class="prepend-4"><?php echo __('Please fill in the form below.') ?></p>
<div class="hrsplit-1"></div>

<?php if (form_errors() || (isset($errorWhileSaving) && $errorWhileSaving == true)): ?>
<div class="column pad-2 prepend-3">
<?php if (isset($errorWhileSaving) && $errorWhileSaving == true): ?>
<div class="error">
<?php echo __('An error occurred while registering your company.<br />We are sorry for the inconvenience and working to work out the problem yet.') ?>
</div>
<?php endif ?>
 <?php if (form_errors()): ?>
<?php echo form_errors() ?>
<?php endif ?>
 </div>
<?php endif ?>
<div class="hrsplit-1"></div>

 <?php echo form_tag('company/register') ?>
 <?php echo input_hidden_tag('keepon', $sf_params->get('keepon')) ?>
  <ol class="column span-137" style="margin: 0px;padding: 0px;">
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('comp_name', __('Company Name')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_name', $sf_request->getParameter('comp_name'), 'size=50 maxlength=255') ?></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('comp_sector', __('Business Sector')) ?></li>
      <li class="column span-100"><?php echo object_select_tag($sf_request->getParameter('comp_sector'), 'comp_sector', array(
  'include_custom' => __('select a business sector'),
  'related_class' => 'BusinessSector',
  'peer_method' => 'getOrderedNames'
  )) ?></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('comp_busstype', __('Business Type')) ?></li>
      <li class="column span-100"><?php echo object_select_tag($sf_request->getParameter('comp_busstype'), 'comp_busstype', array(
  'include_custom' => __('select a business type'),
  'related_class' => 'BusinessType',
  'peer_method' => 'getOrderedNames'
  )) ?></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('comp_introduction', __('Introduction')) ?></li>
      <li class="column span-100"><?php echo textarea_tag('comp_introduction', $sf_params->get('comp_introduction'), 'cols=52 rows=4 maxlength=1000') ?></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('comp_productservices', __('Products and Services')) ?></li>
      <li class="column span-100"><?php echo textarea_tag('comp_productservices', $sf_params->get('comp_productservices'), 'cols=52 rows=4 maxlength=1000') ?></li>
      <li class="column span-137 first"><h3 style="font: tahoma; color: #737373; border-bottom: solid 3px #A4A9A6; padding: 3px; margin: 10px 0px;"><?php echo __('Contact Details') ?></h3></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('comp_phone', __('Phone Number')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_phone', $sf_params->get('comp_phone'), 'size=20 maxlength=50') ?></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('comp_country', __('Country')) ?></li>
      <li class="column span-100"><?php echo select_country_tag('comp_country', $sf_params->get('comp_country'), array('include_custom' => __('select country'))) ?></li>
<?php echo observe_field('comp_country', array('update' => 'comp_state_div',
                'url' => 'profile/findlocation', 'with' => "'country_code=' + value + '&ID=WP54MJ64L3'")) ?>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('comp_street', __('Street Address')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_street', $sf_params->get('comp_street'), 'size=50 maxlength=255') ?></li>
      <li class="column span-35 append-2 right first"><div class="comp_state_div"><?php echo emt_label_for('comp_state', __('State/Province')) ?></div></li>
      <li class="column span-100"><div id="comp_state_div"><?php echo select_tag('comp_state', options_for_select($contact_cities, $sf_params->get('comp_state'), array('include_custom' => __('select state/province')))) ?></div></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('comp_postalcode', __('Postal Code')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_postalcode', $sf_params->get('comp_postalcode'), 'size=10') ?></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('comp_city', __('City/Town')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_city', $sf_params->get('comp_city'), 'size=25 maxlength=50') ?></li>
      <li class="column span-137 first"><h3 style="font: tahoma; color: #737373; border-bottom: solid 3px #A4A9A6; padding: 3px; margin: 10px 0px;"><?php echo __('Service Preferences') ?></h3></li>
      <li class="column span-137 first" style="padding: 10px 10px 10px 30px;"><?php echo __('Please select the applications you are willing to use :') ?></li>
      <li class="column span-20 append-2 right first"><?php echo checkbox_tag('comp_services_b2b', '1', ($sf_params->get('comp_services_b2b')==='1')) ?></li>
      <li class="column span-115"><?php echo emt_label_for('comp_services_b2b', __('Business to Business Service'), 'style=font-weight:bold') ?></li>
      <li class="column span-20 append-2 right first"></li>
      <li class="column span-115">
                    <?php echo radiobutton_tag('comp_b2b_purpose', '1', ($sf_params->get('comp_b2b_purpose')==='1'), 'id=comp_b2b_seller') ?>&nbsp;
                    <?php echo emt_label_for('comp_b2b_seller', __('Expecting to Sell')) ?>&nbsp;&nbsp;&nbsp;
                    <?php echo radiobutton_tag('comp_b2b_purpose', '2', ($sf_params->get('comp_b2b_purpose')==='2'), 'id=comp_b2b_buyer') ?>&nbsp;
                    <?php echo emt_label_for('comp_b2b_buyer', __('Looking for Products')) ?>&nbsp;&nbsp;&nbsp;
                    <?php echo radiobutton_tag('comp_b2b_purpose', '3', ($sf_params->get('comp_b2b_purpose')==='3'), 'id=comp_b2b_sellerbuyer') ?>&nbsp;
                    <?php echo emt_label_for('comp_b2b_sellerbuyer', __('Wish to Sell and Buy')) ?>&nbsp;&nbsp;&nbsp;</li>
      <li class="column span-20 append-2 right first"><?php echo checkbox_tag('comp_services_hr', '1', ($sf_params->get('comp_services_hr')==='1')) ?></li>
      <li class="column span-115"><?php echo emt_label_for('comp_services_hr', __('Human Resources'), 'style=font-weight:bold') ?></li>
      <li class="column span-137 first" style="text-align: center;"><br /><em><?php echo __('By clicking Sign Up, you are indicating that you have read and agree to the %1s and %2s.', array('%1s' => link_to(__('Terms of Use'),'@lobby.terms','target=emt_terms'), '%2s' => link_to(__('Privacy Policy'),'@lobby.privacy','target=emt_privacy'))) ?></em></li>
      <li class="column span-100 last" style="text-align: center;"><br /><?php echo submit_image_tag('layout/button/register.company.' . $sf_user->getCulture() . '.png') ?></li>
  </ol>
</form>
</div>
