<?php use_helper('DateForm', 'Object') ?>

<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('groupProfile/editProfile', array('group' => $group)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section id="boxContent">
                <h4><?php echo __('Edit Basic Information') ?></h4>
                <?php echo form_errors() ?>
                <?php echo form_tag("@group-basic?hash={$group->getHash()}", 'novalidate=novalidate') ?>
                <dl class="_table">
                      <dt class="_req"><?php echo emt_label_for('group_name', __('Group Name')) ?></dt>
                      <dd><?php echo input_tag('group_name', $sf_params->get('group_name', $group->getName()), 'size=50 maxlength=255') ?></dd>
                      <dt class="_req"><?php echo emt_label_for('group_type_id', __('Group Type')) ?></li>
                      <dd><?php echo object_select_tag($sf_params->get('group_type_id', $group->getTypeId()), 'group_type_id', array(
                  'include_custom' => __('select a group type'),
                  'related_class' => 'GroupType',
                  'peer_method' => 'getOrderedNames',
                  'onchange' => "if (this.value==".GroupTypePeer::GRTYP_ONLINE.") {jQuery('.official').slideUp().addClass('ghost-sub');} else {jQuery('.official').removeClass('ghost-sub').slideDown();}"
                  )) ?></dd>
                      <dt class="official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost':'' ?>"><?php echo emt_label_for('group_founded_in', __('Founded In')) ?></dt>
                      <dd class="official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost-sub':'' ?>"><?php echo select_year_tag('group_founded_in', $sf_params->get('group_founded_in', $group->getFoundedIn('Y')), array('year_start' => date('Y'), 'year_end' => date('Y')-100, 'include_custom' => __('year'))) ?>
                           <em class="ln-example"><?php echo __('Select the year which your organisation was founded in.') ?></em></dd>
                      <dt><?php echo emt_label_for('group_url', __('Group Web Site')) ?></dt>
                      <dd><?php echo input_tag('group_url', $sf_params->get('group_url', $group->getUrl()), 'size=30 maxlength=255') ?>
                          <em class="ln-example"><?php echo __('Example: http://www.groupsite.com') ?></em></dd>
                </dl>
                <?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get('group_lang') : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
                <dl class="_table ln-part">
                    <dt></dt>
                    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(__('remove'), '', "class=ln-removelink") ?></div></dd>
                    <dt><?php echo emt_label_for("group_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
                    <dd><?php echo select_language_tag("group_lang_$key", $lang, array('languages' => sfConfig::get('app_i18n_cultures'), 'class' => 'ln-select', 'name' => 'group_lang[]', 'include_blank' => true)) ?></dd>
                    <dt></dt>
                    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
                    <dt><?php echo emt_label_for("group_displayname_$key", __('Display Name')) ?></dt>
                    <dd><?php echo input_tag("group_displayname_$key", $sf_params->get("group_displayname_$key", $group->getDisplayName($lang)), 'size=50 maxlength=255') ?>
                        <em class="ln-example"><?php echo __('Enter group name in selected language. Leave empty to keep original.') ?></em></dd>
                    <dt class="official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost':'' ?>"><?php echo emt_label_for("group_abbreviation_$key", __('Abbreviation')) ?></dt>
                    <dd class="official<?php echo ($group->getTypeId()==GroupTypePeer::GRTYP_ONLINE)?' ghost':'' ?>"><?php echo input_tag("group_abbreviation_$key", $sf_params->get("group_abbreviation_$key", $group->getAbbreviation($lang)), 'size=10 maxlength=50') ?></dd>
                    <dt><?php echo emt_label_for("group_introduction_$key", __('Introduction')) ?></dt>
                    <dd><?php echo textarea_tag("group_introduction_$key", $sf_params->get("group_introduction_$key", $group->getIntroduction($lang)), 'cols=52 rows=4 maxlength=2000') ?>
                        <em class="ln-example"><?php echo __('Tell us about your group.') ?></em></dd>
                    <dt><?php echo emt_label_for("group_member_profile_$key", __('Member Profile')) ?></dt>
                    <dd><?php echo textarea_tag("group_member_profile_$key", $sf_params->get("group_member_profile_$key", $group->getMemberProfile($lang)), 'cols=52 rows=4 maxlength=2000') ?>
                        <em class="ln-example"><?php echo __("Describe your group's member profile.") ?></em></dd>
                    <dt><?php echo emt_label_for("group_events_$key", __('Events Description')) ?></dt>
                    <dd><?php echo textarea_tag("group_events_$key", $sf_params->get("group_events_$key", $group->getEventsIntroduction($lang)), 'cols=52 rows=4 maxlength=2000') ?>
                        <em class="ln-example"><?php echo __("Describe your group's event profile.") ?></em></dd>
                </dl>
                <?php endforeach ?>
                <dl class="_table">
                    <dt></dt>
                    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?>&nbsp;&nbsp;<?php echo link_to(__('Cancel Changes'), "@edit-group-profile?hash={$group->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
                </dl>
                </form>
            </section>
        </div>
        
    </div>

    <div class="col_180">

    </div>
    
</div>
<?php echo javascript_tag("
$('#boxContent').langform();

") ?>