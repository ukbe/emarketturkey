<?php use_helper('DateForm') ?>
<emtAjaxResponse>
<emtInit>
<?php echo "
$('#ajx-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });

$('dl._table input').customInput();
" ?>
</emtInit>
<emtHeader>
<?php if ($object->isNew()): ?>
<?php echo __('Add New Organisation Item') ?>
<?php else: ?>
<?php echo __('Editing Organisation Information') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=organisations', 'id=ajx-form') ?>
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
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Save'), "", 'id=ajx-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>