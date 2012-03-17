<?php use_helper('DateForm', 'Object') ?>
<div class="column span-137 pad-2 prepend-4" style="padding-top: 30px;">
<?php echo image_tag("layout/background/group/create-group.{$sf_user->getCulture()}.png") ?>
<div class="hrsplit-3"></div>
<p class="prepend-4"><?php echo __('Please fill in the form below in order to create your group.') ?></p>
<div class="hrsplit-1"></div>

<?php if (form_errors() || (isset($errorWhileSaving) && $errorWhileSaving == true)): ?>
<div class="column span-127 pad-2 prepend-3">
<?php if (isset($errorWhileSaving) && $errorWhileSaving == true): ?>
<div id="error" class="tipbox">
<?php echo __('An error occurred while creating your group.<br />We are sorry for the inconvenience and working to work out the problem yet.') ?>
</div>
<?php endif ?>
 <?php if (form_errors()): ?>
<?php echo form_errors() ?>
<?php endif ?>
 </div>
<?php endif ?>
<div class="hrsplit-1"></div>

 <?php echo form_tag('@group-start') ?>
  <ol class="column span-137" style="margin: 0px;">
      <li class="column span-35 right append-2"><?php echo emt_label_for('group_name', __('Group Name')) ?></li>
      <li class="column span-100"><?php echo input_tag('group_name', $sf_params->get('group_name'), 'size=50 maxlength=255') ?><br />
                                           <span class="hint"><em><?php echo __('(required)') ?></em></span></li>
      <li class="column span-35 right append-2"><?php echo emt_label_for('group_type_id', __('Group Type')) ?></li>
      <li class="column span-100"><?php echo object_select_tag($sf_params->get('group_type_id'), 'group_type_id', array(
  'include_custom' => __('select a group type'),
  'related_class' => 'GroupType',
  'peer_method' => 'getOrderedNames',
  'onchange' => "if (this.value==".GroupTypePeer::GRTYP_ONLINE.") {jQuery('.official').slideUp();} else {jQuery('.official').slideDown();}"
  )) ?><br />
                                           <span class="hint"><em><?php echo __('(required)') ?></em></span></li>
<?php /*         <li class="column span-35 right append-2"><?php echo emt_label_for('group_interest_area_id', __('Interest Area')) ?></li>
      <li class="column span-100"><?php echo object_select_tag($sf_params->get('group_iterest_area_id'), 'group_interest_area_id', array(
  'include_custom' => __('select an interest area'),
  'related_class' => 'GroupInterestArea',
  'peer_method' => 'getOrderedNames'
  )) ?><br />
                                           <span class="hint"><em><?php echo __('(required)') ?></em></span></li>
*/ ?>
      <li class="column span-35 right append-2 first official"><?php echo emt_label_for('group_abbreviation', __('Group Abbreviation')) ?></li>
      <li class="column span-100 official"><?php echo input_tag('group_abbreviation', $sf_params->get('group_abbreviation'), 'size=10 maxlength=50') ?><br />
                                           <span class="hint"><em><?php echo __('Example: NASA (optional)') ?></em></span></li>
      <li class="column span-35 right append-2 first official"><?php echo emt_label_for('group_founded_in', __('Founded In')) ?></li>
      <li class="column span-100 official"><?php echo select_year_tag('group_founded_in', $sf_params->get('group_founded_in'), array('year_start' => date('Y'), 'year_end' => date('Y')-100, 'include_custom' => __('year'))) ?><br />
                                           <span class="hint"><em><?php echo __('Select the year which your organisation was founded in.(optional)') ?></em></span></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('group_introduction', __('Introduction')) ?></li>
      <li class="column span-100"><?php echo textarea_tag('group_introduction', $sf_params->get('group_introduction'), 'cols=52 rows=4 maxlength=2000') ?><br />
                                           <span class="hint"><em><?php echo __('Tell us about your group.(optional)') ?></em></span></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('group_member_profile', __('Member Profile')) ?></li>
      <li class="column span-100"><?php echo textarea_tag('group_member_profile', $sf_params->get('group_member_profile'), 'cols=52 rows=4 maxlength=2000') ?><br />
                                           <span class="hint"><em><?php echo __("Describe your members' profile.(optional)") ?></em></span></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('group_events', __('Events Description')) ?></li>
      <li class="column span-100"><?php echo textarea_tag('group_events', $sf_params->get('group_events'), 'cols=52 rows=4 maxlength=2000') ?><br />
                                           <span class="hint"><em><?php echo __("Provide some information about your organisation's events, if available.(optional)") ?></em></span></li>
      <li class="column span-35 right append-2 first"><?php echo emt_label_for('group_url', __('Group Web Site')) ?></li>
      <li class="column span-100"><?php echo input_tag('group_url', $sf_params->get('group_url'), 'size=30 maxlength=255') ?><br />
                                           <span class="hint"><em><?php echo __('Example: http://www.groupsite.com (optional)') ?></em></span></li>
      <li class="column span-137" style="height:30px;"></li>
      <li class="column span-137"><?php echo image_tag("layout/background/group/contact-details.{$sf_user->getCulture()}.png") ?></li>
      <li class="column span-137" style="height:15px;"></li>
      <li class="column span-132" style="padding: 10px 10px 10px 30px;"><?php echo __('Please provide contact information of your organisation, if available.(optional)') ?></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('group_phone', __('Phone Number')) ?></li>
      <li class="column span-100"><?php echo input_tag('group_phone', $sf_params->get('group_phone'), 'size=20 maxlength=50') ?></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('group_country', __('Country')) ?></li>
      <li class="column span-100"><?php echo select_country_tag('group_country', $sf_params->get('group_country'), array('include_custom' => __('select country'))) ?></li>
<?php echo observe_field('group_country', array('update' => 'group_state_div',
                'url' => '@find-city', 'with' => "'country_code=' + value + '&ID=PR3K6N332K'")) ?>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('group_street', __('Street Address')) ?></li>
      <li class="column span-100"><?php echo input_tag('group_street', $sf_params->get('group_street'), 'size=50 maxlength=255') ?></li>
      <li class="column span-35 append-2 right first"><div class="group_state_div"><?php echo emt_label_for('group_state', __('State/Province')) ?></div></li>
      <li class="column span-100"><div id="group_state_div"><?php echo select_tag('group_state', options_for_select($contact_cities, $sf_params->get('group_state'), array('include_custom' => __('select state/province')))) ?></div></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('group_postalcode', __('Postal Code')) ?></li>
      <li class="column span-100"><?php echo input_tag('group_postalcode', $sf_params->get('group_postalcode'), 'size=10') ?></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('group_city', __('City/Town')) ?></li>
      <li class="column span-100"><?php echo input_tag('group_city', $sf_params->get('group_city'), 'size=25') ?></li>
      <li class="column span-35 append-2 right first"><?php echo emt_label_for('group_email', __('E-mail')) ?></li>
      <li class="column span-100"><?php echo input_tag('group_email', $sf_params->get('group_email'), 'size=30 maxlength=50') ?><br />
                                           <span class="hint"><em><?php echo __("Group's public e-mail address.(optional)") ?></em></span></li>
      <li class="column span-137" style="height:30px;"></li>
      <li class="column span-137"><?php echo image_tag("layout/background/group/group-settings.{$sf_user->getCulture()}.png") ?></li>
      <li class="column span-137" style="height:15px;"></li>
      <li class="column span-132" style="padding: 10px 10px 10px 30px;"><?php echo __('Please select membership settings for your group :') ?></li>
      <li class="column span-10 append-2 right first"></li>
      <li class="column span-125"><?php echo emt_label_for('group_attandence', __('Membership Confirmation'), 'style=font-weight:bold') ?></li>
      <li class="column span-20 append-2 right first"></li>
      <li class="column span-115">
                    <?php echo radiobutton_tag('group_member_confirm', '0', ($sf_params->get('group_member_confirm')==='1'), 'id=group_member_join') ?>&nbsp;
                    <?php echo emt_label_for('group_member_join', __('Anyone can join')) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo radiobutton_tag('group_member_confirm', '1', ($sf_params->get('group_member_confirm')==='0' || !$sf_params->get('group_member_confirm')), 'id=group_approval_required') ?>&nbsp;
                    <?php echo emt_label_for('group_approval_required', __('Approval required')) ?>&nbsp;&nbsp;&nbsp;
      <li class="column span-137" style="height:20px;"></li>
      <li class="column span-20 append-2 right first"></li>
      <li class="column span-115"><br /><?php echo checkbox_tag('confirm') ?>&nbsp;
 <?php echo __('I accept %1$s and %2$s.', array('%1$s' => link_to(__('Terms of Use'),'@lobby.terms','target=emt_terms'), '%2$s' => link_to(__('Privacy Policy'),'@lobby.privacy','target=emt_privacy'))) ?></li>
      <li class="column span-100 last" style="text-align: center;"><br /><?php echo submit_image_tag("layout/button/group/start-group.{$sf_user->getCulture()}.png") ?></li>
  </ol>
</form>
</div>
<div class="column span-53">
<?php echo image_tag('layout/background/group/community.jpg', 'style=padding: 30px;') ?>
</div>