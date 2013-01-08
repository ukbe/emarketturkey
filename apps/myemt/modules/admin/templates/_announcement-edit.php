<?php use_helper('DateForm') ?>
<?php if ($object->isNew()): ?>
<?php
    $i18ns = array();
?>
<h4><?php echo __('New Announcement') ?></h4>
<?php else: ?>
<?php
    $i18ns = $object->getExistingI18ns();
?>
<h4><?php echo __('Editing: %1s', array('%1s' => $object->__toString())) ?></h4>
<?php endif ?>
<div class="hrsplit-3"></div>
<div id="boxContent">
<?php echo form_errors() ?>
<?php echo form_tag($object->getEditUrl(), 'multipart=true') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt class="_req"><?php echo emt_label_for('ann_title', __('Title')) ?></dt>
    <dd><?php echo input_tag('ann_title', $sf_params->get('ann_title', $object->getTitle()), 'style=') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 255)) ?></em></dd>
    <dt class="_req"><?php echo emt_label_for('ann_channel', __('Channel')) ?></dt>
    <dd><?php echo select_tag('ann_layout_pick', options_for_select(array('1' => __('Existing'), '2' => __('Create New')))) ?>
        <?php echo select_tag('ann_channel', options_for_select(AnnouncementPeer::$chnlLabels, $sf_params->get('ann_channel', $object->getChannelId()), array('use_i18n' => true, 'include_custom' => '-- '.__('select channel').' --'))) ?></dd>
    <dt class="_req"><?php echo emt_label_for('ann_email_layout', __('Layout')) ?></dt>
    <dd><?php echo select_tag('ann_email_layout', options_for_select(EmailLayoutPeer::getLayoutsFor($object->getOwnerId(), $object->getOwnerTypeId(), true), $sf_params->get('ann_email_layout', $object->getLayoutId()), array('include_custom' => '-- '.__('select existing layout').' --'))) ?></dd>
    <dt class="_req"><?php echo emt_label_for('ann_recipient_class', __('Recipient Class')) ?></dt>
    <dd><?php echo select_tag('ann_recipient_class', options_for_select(AnnouncementPeer::$recipLabels, $sf_params->get('ann_recipient_class', $object->getRecipientClass()), array('use_i18n' => true, 'include_custom' => '-- '.__('select class').' --'))) ?></dd>
    <dt class="_req"><?php echo emt_label_for('ann_relation_subject', __('Relation Subject')) ?></dt>
    <dd><div id="ann_subject" style="width: 400px;"></div>
        <em class="ln-example"><?php echo __('Start typing name of company or group which recipients of this announcement are in relation with.') ?></em></dd>
    <dt class="_req"><?php echo emt_label_for('ann_relation_role', __('Relation Role')) ?></dt>
    <dd><?php echo select_tag('ann_relation_role', options_for_select(array(), $sf_params->get('ann_relation_role', $object->getRecRoleId()), array('include_custom' => '-- '.__('select relation role').' --'))) ?></dd>
    <dt class="_req"><?php echo emt_label_for('ann_feed_type', __('Feed Type')) ?></dt>
    <dd><?php echo select_tag('ann_feed_type', options_for_select(array(0 => __('Static Feed'), 1 => __('Dynamic Feed')), $sf_params->get('ann_feed_type', $object->getDynamicFeed()), array('include_custom' => '-- '.__('select feed type').' --'))) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Language Specific Details') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("ann_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part _wideInput">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("ann_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("ann_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'ann_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("ann_display_title_$key", __('Display Title')) ?></dt>
    <dd><?php echo input_tag("ann_display_title_$key",$sf_params->get("ann_display_title_$key", $object->getDisplayTitle($lang)), 'size=50 maxlength=255') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 255)) ?></em></dd>
    <dt><?php echo emt_label_for("ann_simple_message_$key", __('Simple Message')) ?></dt>
    <dd><?php echo textarea_tag("ann_simple_message_$key", $sf_params->get("ann_simple_message_$key", $object->getSimpleMessage($lang)), 'cols=52 rows=3') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
</dl>
<h5><?php echo __('Delivery Options') ?></h5>
<dl class="_table _noInput">
    <dt><?php echo emt_label_for("ann_deliver_from", __('Deliver From')) ?></dt>
    <dd class="_req"><?php echo input_tag("ann_deliver_from", $sf_params->get('ann_deliver_from', $object->getDeliverFrom('d M Y')), array('style' => 'width:100px;')) ?>
        <?php echo select_hour_tag('ann_deliver_from_time_hour', $sf_params->get('ann_deliver_from_time_hour', $object->getDeliverFrom('H'))) ?>
        <?php echo select_minute_tag('ann_deliver_from_time_min', $sf_params->get('ann_deliver_from_time_min', $object->getDeliverFrom('i'))) ?>
        <?php echo input_hidden_tag('ann_deliver_from_date', $object->getDeliverFrom()) ?></dd>
    <dt><?php echo emt_label_for("ann_deliver_by", __('Deliver By')) ?></dt>
    <dd><?php echo input_tag("ann_deliver_by", $sf_params->get('ann_deliver_by', $object->getDeliverBy('d M Y')), array('style' => 'width:100px;')) ?>
        <?php echo select_hour_tag('ann_deliver_by_time_hour', $sf_params->get('ann_deliver_by_time_hour', $object->getDeliverBy('H'))) ?>
        <?php echo select_minute_tag('ann_deliver_by_time_min', $sf_params->get('ann_deliver_by_time_min', $object->getDeliverBy('i'))) ?>
        <?php echo input_hidden_tag('ann_deliver_by_date', $object->getDeliverBy()) ?></dd>
    <dt><?php echo emt_label_for('ann_priority', __('Priority')) ?></dt>
    <dd><?php echo select_tag('ann_priority', options_for_select(AnnouncementPeer::$prioLabels, $object->getPriority(), array('include_custom' => '-- '.__('select priority'). ' --', 'use_i18n' => true))) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Photos') ?></h5>
<dl class="_table whoatt">
    <dt></dt>
    <dd><?php if (count($photos = $object->getPhotos())): ?>
        <?php foreach ($photos as $photo): ?>
        <div>
        <?php echo link_to(image_tag($photo->getThumbnailUri(), 'class=bordered-image'), $photo->getUri(), array('title' => __('Click to view'), 'target' => 'blank')) ?><br />
        </div>
        <?php endforeach ?>
        <div class="hrsplit-1"></div>
        <?php else: ?>
        <?php echo __('No photos') ?>
        <?php endif ?></dd>
    </dd>
</dl>
<dl class="_table">
    <dt><?php echo emt_label_for('ann_file', __('Upload File'))?></dt>
    <dd><?php echo input_file_tag('ann_file') ?></dd>
</dl>
<div class="hrsplit-3"></div>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), 
                ($object->isNew() ? 
                    (is_null($object->getOwnerTypeId()) ? 
                        "@admin-action?action=announcements" 
                        : ($object->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? 
                            "company-ann-action?action=list&hash={$this->getOwner()->getHash()}" 
                            : "group-ann-action?action=list&hash={$this->getOwner()->getHash()}"
                          )
                    )
                  : (is_null($object->getOwnerTypeId()) ? 
                        "admin-action?action=announcement&guid={$this->getGuid()}" 
                        : ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? 
                            "@company-ann-action?action=details&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}" 
                            : "@group-ann-action?action=details&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}"
                          )
                    )
                ) , 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
<?php $ann_relation_hashes = $sf_params->get('ann_relation_hash') ?>
<?php $unsaved_relation_subject = ($unverified = count($ann_relation_hashes) ? myTools::unplug($ann_relation_hashes[0]) : null) instanceof Company || $unverified instanceof Group ? $unverified : $object->getRecSubject(); ?>

<?php use_javascript("emt.langform-1.0.js") ?>
<?php use_javascript('jquery.customCheckbox.js') ?>
<?php use_javascript('emt-dynalist-1.0.js') ?>
<?php echo javascript_tag("
$(function() {

    $('#boxContent').langform();

    $('dl._table input').customInput();

    $('.whoatt a[title!=\"\"]').tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });

    $('#ann_subject').dynalist({
        data: [".($unsaved_relation_subject ? "{HASH: '{$unsaved_relation_subject->getPlug()}', LABEL: '{$unsaved_relation_subject}'}" : '')."], minChars: 4, maxAllowedItems: 1,
        autoCompleteConf: {url: '".url_for('@query-all', true)."', data: { object_type: [".PrivacyNodeTypePeer::PR_NTYP_COMPANY.", ".PrivacyNodeTypePeer::PR_NTYP_GROUP."] }},
        classMap: { TYPE_ID: {1: 'user-px', 2: 'company-px', 3: 'group-px'} },
        includeSpan: true, mapFields: {HASH: 'ann_relation_hash[]'}
    });
    
    $('#ann_layout_pick').branch({map: {1: '#layout-existing', 2: '#layout-new'}})

});
") ?>