<?php use_helper('Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Corporate Representative'), 'representative/index') ?></li>
<li class="last"><?php echo __('Add New Company') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('rightcolumn') ?>
<div class="column pad-2" style="background: #FFDBDB;">
<b><?php echo __('Attention') ?></b>
<p style="font: 11px verdana"><?php echo __('You are about to register a new company to eMarketTurkey on behalf of Candidate Company\'s legal administrator(s).') ?></p>
<p style="font: 11px verdana"><?php echo __('It\'s strongly recommended that you should have reached a consensus with Candidate Company\'s legal administration about registering to eMarketTurkey.') ?></p>
<p style="font: 11px verdana"><?php echo __('In case of any future complaints, Candidate Company\'s record will be removed from eMarketTurkey.') ?></p>
<p style="font: 11px verdana"><?php echo __('If you need more information on registering a company on behalf of it\'s administrator(s), see %1.', array('%1' => link_to(__('Corporate Representative Guidelines'), 'representative/guidelines'))) ?></p>
</div>
<?php end_slot() ?>
<div class="column span-137 pad-2 prepend-4">
<?php echo image_tag('layout/background/register-company/register.company.en.png') ?>
<p class="prepend-4"><?php echo __('Please fill in the form below.') ?></p>
<div class="hrsplit-3"></div>
 <?php if (form_errors()): ?>
<?php echo form_errors() ?>
<div class="hrsplit-2"></div>
<?php endif ?>
<?php echo form_tag('representative/addCompany') ?>
  <ol class="column span-137" style="margin: 0px;">
      <li class="column span-35 right append-2"><?php echo emt_label_for('comp_name', __('Company Name')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_name', $sf_request->getParameter('comp_name'), 'size=50') ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('comp_sector', __('Business Sector')) ?></li>
      <li class="column span-100"><?php echo object_select_tag($sf_request->getParameter('comp_sector'), 'comp_sector', array(
  'include_custom' => __('select a business sector'),
  'related_class' => 'BusinessSector',
  'peer_method' => 'getOrderedNames'
  )) ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('comp_busstype', __('Business Type')) ?></li>
      <li class="column span-100"><?php echo object_select_tag($sf_request->getParameter('comp_busstype'), 'comp_busstype', array(
  'include_custom' => __('select a business type'),
  'related_class' => 'BusinessType',
  'peer_method' => 'getOrderedNames'
  )) ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('comp_introduction', __('Introduction')) ?></li>
      <li class="column span-100"><?php echo textarea_tag('comp_introduction', $sf_params->get('comp_introduction'), 'cols=52 rows=4 maxlength=1000') ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('comp_productservices', __('Products and Services')) ?></li>
      <li class="column span-100"><?php echo textarea_tag('comp_productservices', $sf_params->get('comp_productservices'), 'cols=52 rows=4 maxlength=1000') ?></li>

      <li class="column span-137"><h3><?php echo __("Contact Person Information") ?></h3></li>
      <li class="column span-137"><p><?php echo __("Please enter information about Company's Contact Person. An eMarketTurkey User Account will be created for this person.") ?></p></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('name', __("Contact Person's Name")) ?></li>
      <li class="column span-100"><?php echo input_tag('name', $sf_request->getParameter('name'), 'size=20') ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('lastname', __("Contact Person's Lastname")) ?></li>
      <li class="column span-100"><?php echo input_tag('lastname', $sf_request->getParameter('lastname'), 'size=20') ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('gender', __('Gender')) ?></li>
      <li class="column span-100"><?php echo radiobutton_tag('gender', 'male', $sf_request->getParameter('gender')=='male') ?>&nbsp;<?php echo emt_label_for('gender_male',__('Male'), null,true) ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo radiobutton_tag('gender', 'female', $sf_request->getParameter('gender')=='female') ?>&nbsp;<?php echo emt_label_for('gender_female',__('Female'), null,true) ?></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('email_first', __('Email address')) ?></li>
      <li class="column span-100"><?php echo input_tag('email_first', $sf_request->getParameter('email_first'), 'size=30') ?><br />
                                  <em><?php echo __('Access information will be sent to this email address') ?></em></li>

      <li class="column span-137"><?php echo image_tag('layout/background/register-company/contact.details.en.png') ?></li>
      <li class="column span-35 append-2 right"><?php echo emt_label_for('comp_phone', __('Phone Number')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_phone', $sf_params->get('comp_phone'), 'size=20') ?></li>
      <li class="column span-35 append-2 right"><?php echo emt_label_for('comp_country', __('Country')) ?></li>
      <li class="column span-100"><?php echo select_country_tag('comp_country', $sf_params->get('comp_country'), array('include_custom' => __('select country'))) ?></li>
<?php echo observe_field('comp_country', array('update' => 'comp_state_div',
                'url' => 'profile/findlocation', 'with' => "'country_code=' + value + '&ID=WP54MJ64L3'")) ?>
      <li class="column span-35 append-2 right"><?php echo emt_label_for('comp_street', __('Street Address')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_street', $sf_params->get('comp_street'), 'size=50') ?></li>
      <li class="column span-35 append-2 right"><div class="comp_state_div"><?php echo emt_label_for('comp_state', __('State/Province')) ?></div></li>
      <li class="column span-100"><div id="comp_state_div"><?php echo select_tag('comp_state', options_for_select($contact_cities, $sf_params->get('comp_state'), array('include_custom' => __('select state/province')))) ?></div></li>
      <li class="column span-35 append-2 right"><?php echo emt_label_for('comp_postalcode', __('Postal Code')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_postalcode', $sf_params->get('comp_postalcode'), 'size=10') ?></li>
      <li class="column span-35 append-2 right"><?php echo emt_label_for('comp_city', __('City/Town')) ?></li>
      <li class="column span-100"><?php echo input_tag('comp_city', $sf_params->get('comp_city'), 'size=25') ?></li>
      <li class="column span-137"><?php echo image_tag('layout/background/register-company/service.preferences.en.png') ?></li>
      <li class="column span-137" style="padding: 10px 10px 10px 30px;"><?php echo __('Please select the applications which Candidate Company plans to use :') ?></li>
      <li class="column span-20 append-2 right first"><?php echo checkbox_tag('comp_services_b2b', '1', ($sf_params->get('comp_services_b2b')==='1')) ?></li>
      <li class="column span-115"><?php echo emt_label_for('comp_services_b2b', __('Business to Business Service'), 'style=font-weight:bold') ?></li>
      <li class="column span-20 append-2 right"></li>
      <li class="column span-115">
                    <?php echo radiobutton_tag('comp_b2b_purpose', '1', ($sf_params->get('comp_b2b_purpose')==='1'), 'id=comp_b2b_seller') ?>&nbsp;
                    <?php echo emt_label_for('comp_b2b_seller', __('Expects to Sell')) ?>&nbsp;&nbsp;&nbsp;
                    <?php echo radiobutton_tag('comp_b2b_purpose', '2', ($sf_params->get('comp_b2b_purpose')==='2'), 'id=comp_b2b_buyer') ?>&nbsp;
                    <?php echo emt_label_for('comp_b2b_buyer', __('Searches for Products')) ?>&nbsp;&nbsp;&nbsp;
                    <?php echo radiobutton_tag('comp_b2b_purpose', '3', ($sf_params->get('comp_b2b_purpose')==='3'), 'id=comp_b2b_sellerbuyer') ?>&nbsp;
                    <?php echo emt_label_for('comp_b2b_sellerbuyer', __('Wishes to Sell and Buy')) ?>&nbsp;&nbsp;&nbsp;</li>
      <li class="column span-20 append-2 right first"><?php echo checkbox_tag('comp_services_hr', '1', ($sf_params->get('comp_services_hr')==='1')) ?></li>
      <li class="column span-115"><?php echo emt_label_for('comp_services_hr', __('Human Resources'), 'style=font-weight:bold') ?></li>
      <li class="column span-100 last" style="text-align: center;"><br /><?php echo submit_image_tag('layout/button/register.company.' . $sf_user->getCulture() . '.png') ?></li>
  </ol>
</form>
</div>
<br /><br />