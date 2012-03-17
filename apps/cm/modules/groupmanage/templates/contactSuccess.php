<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Edit Information') => '@group-manage?action=edit&stripped_name='.$group->getStrippedName(),
                                                                  __('Contact Information') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuEdit', array('group' => $group)) ?>
<?php end_slot() ?>
<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/group/contact-info.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@group-manage?action=contact&stripped_name='.$group->getStrippedName()) ?>
<?php echo input_hidden_tag('id', $group->getId()) ?>
<ol class="column span-110">
    <li class="column span-36 first right"><?php echo emt_label_for('group_country', __('Country')) ?></li>
    <li class="column span-72 prepend-2"><?php echo select_country_tag('group_country', $sf_params->get('group_country', $work_address->getCountry()), array('include_custom' => __('select country'))) ?></li>
<?php echo observe_field('group_country', array('update' => 'group_state_div',
                'url' => 'profile/findlocation', 'with' => "'country_code=' + value + '&ID=PR3K6N332K'")) ?>
    <li class="column span-36 first right"><?php echo emt_label_for('group_street', __('Street Address')) ?></li>
    <li class="column span-72 prepend-2"><?php echo input_tag('group_street', $sf_params->get('group_street', $work_address->getStreet()), 'size=50') ?><br />
                                         <span class="hint"><em><?php echo __('Example: 54th Hallway Rd.') ?></em></span></li>
    <li class="column span-36 first right"><?php echo emt_label_for('group_state', __('State/Province')) ?></li>
    <li class="column span-72 prepend-2"><div id="group_state_div"><?php echo select_tag('group_state', options_for_select($contact_cities, $sf_params->get('group_state', $work_address->getState()), array('include_custom' => count($contact_cities)?__('select state/province'):__('select country')))) ?></div></li>
    <li class="column span-36 first right"><?php echo emt_label_for('group_postalcode', __('Postal Code')) ?></li>
    <li class="column span-72 prepend-2"><?php echo input_tag('group_postalcode', $sf_params->get('group_postalcode', $work_address->getPostalCode()), 'size=10') ?><br />
                                         <span class="hint"><em><?php echo __('Example: 54367') ?></em></span></li>
    <li class="column span-36 first right"><div class="comp_city_div"><?php echo emt_label_for('group_city', __('City/Town')) ?></div></li>
    <li class="column span-72 prepend-2"><?php echo input_tag('group_city', $sf_params->get('group_city', $work_address->getCity()), 'size=25') ?><br />
                                         <span class="hint"><em><?php echo __('Example: Arlington') ?></em></span></li>
    <li class="column span-36 first right"><?php echo emt_label_for('group_phone', __('Phone Number')) ?></li>
    <li class="column span-72 prepend-2"><?php echo input_tag('group_phone', $sf_params->get('group_phone', $work_phone->getPhone()), 'size=20') ?><br />
                                         <span class="hint"><em><?php echo __('Example: +66 342 5445332') ?></em></span></li>
    <li class="column span-36 first right"><?php echo emt_label_for('fax_number', __('Fax Number')) ?></li>
    <li class="column span-72 prepend-2"><?php echo input_tag('fax_number', $sf_params->get('fax_number', $fax_number->getPhone()), 'size=20') ?><br />
                                         <span class="hint"><em><?php echo __('Example: +66 342 6534522') ?></em></span></li>
    <li class="column span-36 first right"><?php echo emt_label_for('group_email', __('E-mail')) ?></li>
    <li class="column span-72 prepend-2"><?php echo input_tag('group_email', $sf_params->get('group_email', $contact->getEmail()), 'size=30 maxlength=50') ?><br />
                                         <span class="hint"><em><?php echo __("Group's public e-mail address.(optional)") ?></em></span></li>
    <li class="column span-36 first"></li>
    <li class="column span-72 prepend-2"><?php echo submit_tag(__('Save')) ?></li>
</ol>
</form>
</fieldset>