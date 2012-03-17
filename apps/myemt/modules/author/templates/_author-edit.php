<?php if ($object->isNew()): ?>
<?php
    $i18ns = array();
?>
<h4><?php echo __('New Author') ?></h4>
<?php else: ?>
<?php
    $i18ns = $object->getExistingI18ns();
?>
<h4><?php echo __('Editing: %1s', array('%1s' => $object)) ?></h4>
<?php endif ?>
<div class="hrsplit-3"></div>
<div id="boxContent">
<?php echo form_errors() ?>
<?php echo form_tag($object->getEditUrl(), 'multipart=true') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('auth_account_hash', __('Author Account Owner')) ?></dt>
    <dd><div id="auth_account" style="width: 300px;"></div>
        <em class="ln-example"><?php echo __('Start typing name of registered user who you want to assign as owner of this author account.', array('%1num' => 50)) ?></em></dd>
    <dt><?php echo emt_label_for('auth_salutation', __('Salutation')) ?></dt>
    <dd><?php echo input_tag('auth_salutation', $sf_params->get('auth_salutation', $object->getSalutation()), 'style=width: 100px;') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 20)) ?></em></dd>
    <dt class="_req"><?php echo emt_label_for('auth_name', __('Name')) ?></dt>
    <dd><?php echo input_tag('auth_name', $sf_params->get('auth_name', $object->getName()), 'style=width: 200px;') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 50)) ?></em></dd>
    <dt class="_req"><?php echo emt_label_for('auth_lastname', __('Lastname')) ?></dt>
    <dd><?php echo input_tag('auth_lastname', $sf_params->get('auth_lastname', $object->getLastname()), 'style=width: 200px;') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 50)) ?></em></dd>
    <dt><?php echo emt_label_for('auth_is_columnist', __('Is Columnist')) ?></dt>
    <dd><?php echo checkbox_tag('auth_is_columnist', 1, $sf_params->get('auth_is_columnist', $object->getIsColumnist())) ?></dd>
    <dt><?php echo emt_label_for('auth_active', __('Online')) ?></dt>
    <dd><?php echo checkbox_tag('auth_active', 1, $sf_params->get('auth_active', $object->getActive())) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Language Specific Details') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("auth_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part _wideInput">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("auth_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("auth_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'auth_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("auth_display_name_$key", __('Display Name')) ?></dt>
    <dd><?php echo input_tag("auth_display_name_$key",$sf_params->get("auth_display_name_$key", $object->getDisplayName($lang)), 'size=50 maxlength=255') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 255)) ?></em></dd>
    <dt><?php echo emt_label_for("auth_title_$key", __('Title')) ?></dt>
    <dd><?php echo input_tag("auth_title_$key",$sf_params->get("auth_title_$key", $object->getTitle($lang)), 'size=50 maxlength=100') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 100)) ?></em></dd>
    <dt><?php echo emt_label_for("auth_introduction_$key", __('Introduction')) ?></dt>
    <dd><?php echo textarea_tag("auth_introduction_$key", $sf_params->get("auth_introduction_$key", $object->getIntroduction($lang)), 'cols=52 rows=3 maxlength=512') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 512)) ?></em></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Photos and Other Material') ?></h5>
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
    <dt><?php echo emt_label_for('auth_file', __('Upload File'))?></dt>
    <dd><?php echo input_file_tag('auth_file') ?></dd>
</dl>
<div class="hrsplit-3"></div>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), ($object->isNew() ? "@author-action?action=authors" : $object->getEditUrl('view')), 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
<?php $auth_hashes = $sf_params->get('auth_user_hash') ?>
<?php $unsaved_user = ($unverified = count($auth_hashes) ? myTools::unplug($auth_hashes[0]) : null) instanceof User ? $unverified : $object->getUser(); ?>

<?php use_javascript("emt.langform-1.0.js") ?>
<?php use_javascript('jquery.customCheckbox.js') ?>
<?php use_javascript('emt-dynalist-1.0.js') ?>
<?php echo javascript_tag("
    $('#boxContent').langform();

    $('dl._table input').customInput();

    $('.whoatt a[title!=\"\"]').tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });

    $('#auth_account').dynalist({
        data: [".($unsaved_user ? "{HASH: '{$unsaved_user->getPlug()}', LABEL: '{$unsaved_user}'}" : '')."], minChars: 4, maxAllowedItems: 1,
        autoCompleteConf: {url: '".url_for('@query-all', true)."', data: { object_type: [".PrivacyNodeTypePeer::PR_NTYP_USER."] }},
        classMap: { TYPE_ID: {1: 'user-px', 2: 'company-px', 3: 'group-px'} },
        includeSpan: true, mapFields: {HASH: 'auth_user_hash[]'}
    });
    
") ?>