<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Edit Information') => '@group-manage?action=edit&stripped_name='.$group->getStrippedName(),
                                                                  __('Basic Information') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuEdit', array('group' => $group)) ?>
<?php end_slot() ?>
<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/group/basic-info.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('@group-manage?action=basic&stripped_name='.$group->getStrippedName()) ?>
<?php echo input_hidden_tag('id', $group->getId()) ?>
<ol class="column span-120">
      <li class="column span-36 first right"><?php echo emt_label_for('group_name', __('Group Name')) ?></li>
      <li class="column span-82 prepend-2"><?php echo input_tag('group_name', $sf_params->get('group_name', $group->getName()), 'size=50 maxlength=255') ?><br />
                                           <span class="hint"><em><?php echo __('(required)') ?></em></span></li>
      <li class="column span-36 first right"><?php echo emt_label_for('group_type_id', __('Group Type')) ?></li>
      <li class="column span-82 prepend-2"><?php echo object_select_tag($sf_params->get('group_type_id', $group->getTypeId()), 'group_type_id', array(
  'include_custom' => __('select a group type'),
  'related_class' => 'GroupType',
  'peer_method' => 'getOrderedNames',
  'onchange' => "if (this.value==".GroupTypePeer::GRTYP_ONLINE.") {jQuery('.official').slideUp().addClass('ghost-sub');} else {jQuery('.official').removeClass('ghost-sub').slideDown();}"
  )) ?><br />
                                           <span class="hint"><em><?php echo __('(required)') ?></em></span></li>
<?php /*         <li class="column span-36 first right"><?php echo emt_label_for('group_interest_area_id', __('Interest Area')) ?></li>
      <li class="column span-82 prepend-2"><?php echo object_select_tag($sf_params->get('group_iterest_area_id'), 'group_interest_area_id', array(
  'include_custom' => __('select an interest area'),
  'related_class' => 'GroupInterestArea',
  'peer_method' => 'getOrderedNames'
  )) ?><br />
                                           <span class="hint"><em><?php echo __('(required)') ?></em></span></li>
*/ ?>
      <li class="column span-36 first right official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost-sub':'' ?>"><?php echo emt_label_for('group_founded_in', __('Founded In')) ?></li>
      <li class="column span-82 prepend-2 official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost-sub':'' ?>"><?php echo select_year_tag('group_founded_in', $sf_params->get('group_founded_in', $group->getFoundedIn('Y')), array('year_start' => date('Y'), 'year_end' => date('Y')-100, 'include_custom' => __('year'))) ?><br />
                                           <span class="hint"><em><?php echo __('Select the year which your organisation was founded in.(optional)') ?></em></span></li>
      <li class="column span-36 first right"><?php echo emt_label_for('group_url', __('Group Web Site')) ?></li>
      <li class="column span-82 prepend-2"><?php echo input_tag('group_url', $sf_params->get('group_url', $group->getUrl()), 'size=30 maxlength=255') ?><br />
                                           <span class="hint"><em><?php echo __('Example: http://www.groupsite.com (optional)') ?></em></span></li>
</ol>
<?php echo image_tag('layout/background/products/product-lsi.'.$sf_user->getCulture().'.png') ?>
<ol class="column span-120">
    <?php include_partial('groupmanage/group_lsi_form', array('culture' => 'en', 'group' => $group)) ?>
    <?php include_partial('groupmanage/group_lsi_form', array('culture' => 'tr', 'group' => $group)) ?>
    <li class="column span-36 first right"></li>
    <li class="column span-82 prepend-2"><?php echo submit_tag(__('Save')) ?></li>
</ol>
</form>
</fieldset>