<?php if ($object->isNew()): ?>
<?php
    $i18ns = array();
?>
<h4><?php echo __('New Publication Category') ?></h4>
<?php else: ?>
<?php
    $i18ns = $object->getExistingI18ns();
?>
<h4><?php echo __('Editing: %1s', array('%1s' => $object)) ?></h4>
<?php endif ?>
<div class="hrsplit-3"></div>
<div id="boxContent">
<?php echo form_errors() ?>
<?php echo form_tag($object->getEditUrl($act), 'multipart=true') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt class="_req"><?php echo emt_label_for('pubc_parent_id', __('Parent Category')) ?></dt>
    <dd><?php echo select_tag('pubc_parent_id', options_for_select(PublicationCategoryPeer::getOrderedNames(true), $sf_params->get('pubc_parent_id', $object->getParentId()), array('include_custom' => __('(optional)')))) ?>
        <em class="ln-example"><?php echo __('This field is optional. Select none to add a new root category') ?></em></dd>
    <dt><?php echo emt_label_for('pubc_active', __('Online')) ?></dt>
    <dd><?php echo checkbox_tag('pubc_active', 1, $sf_params->get('pubc_active', $object->getActive())) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Language Specific Details') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("pubc_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part _wideInput">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("pubc_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("pubc_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'pubc_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("pubc_name_$key", __('Name')) ?></dt>
    <dd><?php echo input_tag("pubc_name_$key",$sf_params->get("pubc_name_$key", $object->getName($lang)), 'size=50 maxlength=255') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 255)) ?></em></dd>
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
    <dt><?php echo emt_label_for('pubc_file', __('Upload File'))?></dt>
    <dd><?php echo input_file_tag('pubc_file') ?></dd>
</dl>
<div class="hrsplit-3"></div>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), ($object->isNew() ? "@author-action?action=categories" : $object->getEditUrl('view')), 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>

<?php use_javascript("emt.langform-1.0.js") ?>
<?php use_javascript('jquery.customCheckbox.js') ?>
<?php echo javascript_tag("
    $('#boxContent').langform();

    $('dl._table input').customInput();

    $('.whoatt a[title!=\"\"]').tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });

") ?>