<?php use_helper('Date', 'DateForm') ?>
<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map' => array(__('MyEMT') => '@homepage', 
                                                                   __('Profile') => $user->getProfileUrl(),
                                                                   __('Edit') => null
                                                                   )
                                                                   
                                                   )) ?> 
<?php end_slot() ?>

<?php echo form_tag('profile/edit') ?>
<?php echo input_hidden_tag('redir', $sf_params->get('redir')) ?>
<ol class="column span-100">
<li class="column span-100 first"><h2><?php echo __('General Information') ?></h2></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_hometown_country', __('Home Country')) ?></li>
<li class="column span-70"><?php echo select_country_tag('profile_hometown_country', $sf_params->get('profile_hometown_country', $profile?$profile->getHomeCountry():null), array('include_custom' => __('please select your home country'))) ?></li>
<?php echo observe_field('profile_hometown_country', array('update' => 'hometown_city_div',
                'url' => 'profile/findlocation', 'with' => "'country_code=' + value + '&ID=D5KL23FB04'")) ?>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_hometown_state', __('Hometown')) ?></li>
<li class="column span-70"><div id="hometown_city_div"><?php echo select_tag('profile_hometown_state', options_for_select($local_cities, $profile->getHomeTownId(), array('include_custom' => __('select city')))) ?></div>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_preferred_lang', __('Preferred Language')) ?></li>
<li class="column span-70"><?php echo select_language_tag('profile_preferred_lang', $sf_user->getCulture()) ?></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_birthdate', __('Birthdate')) ?></li>
<li class="column span-70 "><?php echo format_date($user->getBirthdate('U'), 'D') ?></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_marital_stat', __('Marital Status')) ?></li>
<li class="column span-70"><?php echo select_tag('profile_marital_stat', options_for_select(UserProfilePeer::$MaritalStatus, $profile?$profile->getMaritalStatus():null)) ?></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_gender', __('Gender')) ?></li>
<li class="column span-70"><span class="vralign">
<?php echo radiobutton_tag('profile_gender', 'male', $user->getGender()===UserProfilePeer::GENDER_MALE)."&nbsp;".emt_label_for('profile_gender_male', __(UserProfilePeer::$Gender[UserProfilePeer::GENDER_MALE])) ?>&nbsp;&nbsp;
<?php echo radiobutton_tag('profile_gender', 'female', $user->getGender()===UserProfilePeer::GENDER_FEMALE)."&nbsp;".emt_label_for('profile_gender_female', __(UserProfilePeer::$Gender[UserProfilePeer::GENDER_FEMALE])) ?></span></li>
<li class="column span-28 append-2 right"></li>
<li class="column span-100"><h2><?php echo __('Contact Information') ?></h2></li>
<li class="column span-28 append-2 right"><?php echo emt_label_for('profile_contact_country', __('Residential Country')) ?></li>
<li class="column span-70"><?php echo select_country_tag('profile_contact_country', $home_address->getCountry(), array('include_custom' => __('please select your residential country'))) ?></li>
<?php echo observe_field('profile_contact_country', array('update' => 'profile_home_state_div',
                'url' => 'profile/findlocation', 'with' => "'country_code=' + value + '&ID=OG53NK62J6'")) ?>
<?php echo observe_field('profile_contact_country', array('update' => 'profile_work_state_div',
                'url' => 'profile/findlocation', 'with' => "'country_code=' + value + '&ID=PW4GMK64L5'")) ?>
<li class="column span-94 prepend-6 first"><b><?php echo __('Home Contact Information') ?> :</b></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_home_phone', __('Phone')) ?></li>
<li class="column span-70"><?php echo input_tag('profile_home_phone', $home_phone->getPhone(), 'size=20') ?></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_home_street', __('Street Address')) ?></li>
<li class="column span-70"><?php echo input_tag('profile_home_street', $home_address->getStreet(), 'size=50') ?></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_home_state', __('State/Province')) ?></li>
<li class="column span-70"><div id="profile_home_state_div"><?php echo select_tag('profile_home_state', options_for_select($contact_cities, $home_address->getState(), array('include_custom' => __('select country')))) ?></div></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_home_city', __('City/Town')) ?></li>
<li class="column span-28"><?php echo input_tag('profile_home_city', $home_address->getCity(), 'size=17') ?></li>
<li class="column span-15 append-2 right"><?php echo emt_label_for('profile_home_postalcode', __('Postal Code')) ?></li>
<li class="column span-25"><?php echo input_tag('profile_home_postalcode', $home_address->getPostalcode(), 'size=10') ?></li>
<li class="column span-94 prepend-6 first"><b><?php echo __('Work Contact Information') ?> :</b></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_work_phone', __('Phone')) ?></li>
<li class="column span-70"><?php echo input_tag('profile_work_phone', $work_phone->getPhone(), 'size=20') ?></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_work_street', __('Street Address')) ?></li>
<li class="column span-70"><?php echo input_tag('profile_work_street', $work_address->getStreet(), 'size=50') ?></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_work_state', __('State/Province')) ?></li>
<li class="column span-70"><div id="profile_work_state_div"><?php echo select_tag('profile_work_state', options_for_select($contact_cities, $work_address->getState(), array('include_custom' => __('select country')))) ?></div></li>
<li class="column span-28 append-2 right first"><?php echo emt_label_for('profile_work_city', __('City/Town')) ?></li>
<li class="column span-28"><?php echo input_tag('profile_work_city', $work_address->getCity(), 'size=17') ?></li>
<li class="column span-15 append-2 right"><?php echo emt_label_for('profile_work_postalcode', __('Postal Code')) ?></li>
<li class="column span-25"><?php echo input_tag('profile_work_postalcode', $work_address->getPostalcode(), 'size=10') ?></li>
<li class="column span-28 append-2 right first"></li>
<li class="column span-70"><?php echo submit_tag(__('Save Changes')) ?></li>
</ol>
</form>