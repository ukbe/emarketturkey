<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('products/products', array('company' => $company)) ?>
        </div>
    </div>
    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            <section id="boxContent">
<?php if ($group->isNew()): ?>
                <h4><?php echo __('Add Product Group') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@new-product-group?hash={$company->getHash()}", 'novalidate=novalidate') ?>
<?php else: ?>
                <h4><?php echo __('Edit Product Group') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@edit-product-group?hash={$company->getHash()}&id={$group->getId()}", 'novalidate=novalidate') ?>
<?php endif ?>
<h5 class="clear"><?php echo __('Product Group Information') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("group_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("group_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("group_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'group_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("group_name_$key", __('Group Name')) ?></dt>
    <dd><?php echo input_tag("group_name_$key",$sf_params->get("group_name_$key", $group->getName($lang)), 'size=50 maxlength=255') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
    <dt></dt>
<?php if ($group->isNew()): ?>
    <dd><?php echo submit_tag(__('Save Product Group'), 'class=green-button') ?>&nbsp;&nbsp;<?php echo link_to(__('Cancel'), $refUrl ? $refUrl : "@list-product-groups?hash={$company->getHash()}") ?></dd>
<?php else: ?>
    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?>&nbsp;&nbsp;<?php echo link_to(__('Cancel'), $refUrl ? $refUrl : "@list-product-groups?hash={$company->getHash()}") ?></dd>
<?php endif ?>
</dl>
</form>
            </section>
        </div>
    </div>
</div>
<?php echo javascript_tag("
$(function() {
    $('#boxContent').langform({afterAdd: function(){\$('.frmhelp').tooltip();}});

    $('.frmhelp').tooltip();
    
    $('dl._table input').customInput();
    
});
") ?>