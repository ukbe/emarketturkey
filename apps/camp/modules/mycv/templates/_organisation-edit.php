<?php use_helper('DateForm') ?>
<div id="editrecord" class="cvRecordBlock">
<div>
<?php if ($object->isNew()): ?>
<h2><?php echo __('Add New Education Item') ?></h2>
<?php else: ?>
<h2><?php echo __('Editing Education Information') ?></h2>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=education', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsmo_name', __('Organisation Name')) ?></dt>
    <dd><?php echo input_tag('rsmo_name', $sf_params->get('rsmo_name', $object->getName()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmo_country_code', __('Country')) ?></dt>
    <dd><?php echo select_country_tag('rsmo_country_code', $sf_params->get('rsmo_country_code', $object->getCountryCode())) ?></dd>
    <dt><?php echo emt_label_for('rsmo_state', __('State')) ?></dt>
    <dd><?php echo input_tag('rsmo_state', $sf_params->get('rsmo_state', $object->getState()), 'size=25') ?></dd>
    <dt><?php echo emt_label_for('rsmo_city', __('City')) ?></dt>
    <dd><?php echo input_tag('rsmo_city', $sf_params->get('rsmo_city', $object->getCity()), 'size=25') ?></dd>
    <dt><?php echo emt_label_for('rsmo_activity_id', __('Activity Level')) ?></dt>
    <dd><?php echo select_tag('rsmo_activity_id', options_for_select(ResumeOrganisationPeer::$typeAttNames, $sf_params->get('rsmo_activity_id', $object->getActivityId()))) ?></dd>
    <dt><?php echo emt_label_for('rsmo_joined_in_year', __('Joined In')) ?></dt>
    <dd><?php echo select_year_tag('rsmo_joined_in_year', $sf_params->get('rsmo_joined_in_year', $object->getJoinedInYear()), array('year_start' => date('Y'), 'year_end' => date('Y')-50, 'include_custom' => __('year'))) ?></dd>
</dl>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), "@mycv-action?action=education", 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
</div>