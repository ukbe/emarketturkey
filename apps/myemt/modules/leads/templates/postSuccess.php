<?php use_helper('DateForm') ?>

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
<?php if (!$lead->isNew()): ?>
                <h4><?php echo __('Edit Lead') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@edit-lead?hash={$company->getHash()}&id={$lead->getId()}", 'novalidate=novalidate enctype=multipart/form-data') ?>
<?php elseif ($lead->getTypeId() == B2bLeadPeer::B2B_LEAD_BUYING): ?>
                <h4><?php echo __('Post Buying Lead') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@post-buying-lead?hash={$company->getHash()}", 'novalidate=novalidate enctype=multipart/form-data') ?>
<?php elseif ($lead->getTypeId() == B2bLeadPeer::B2B_LEAD_SELLING): ?>
                <h4><?php echo __('Post Selling Lead') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@post-selling-lead?hash={$company->getHash()}", 'novalidate=novalidate enctype=multipart/form-data') ?>
<?php else: ?>
                <h4><?php echo __('Post Lead') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@post-lead?hash={$company->getHash()}", 'novalidate=novalidate enctype=multipart/form-data') ?>
<?php endif ?>
<h5><?php echo __('Lead Details') ?></h5>
<dl class="_table">
<?php if (!$lead->getTypeId()): ?>
    <dt class="_req"><?php echo emt_label_for('lead_type_id', __('Select Lead Type')) ?></dt>
    <dd class="L-floater">
        <?php echo radiobutton_tag("lead_type_id", B2bLeadPeer::B2B_LEAD_BUYING, $sf_params->get("lead_type_id", $lead->getTypeId()) == B2bLeadPeer::B2B_LEAD_BUYING, 'id=lead_type_id_1') ?>
        <?php echo emt_label_for("lead_type_id_1", __(B2bLeadPeer::$typeNames[B2bLeadPeer::B2B_LEAD_BUYING]), ($sf_params->get("lead_type_id", $lead->getTypeId()) == B2bLeadPeer::B2B_LEAD_BUYING ? 'class=selected' : '')) ?>
        <?php echo radiobutton_tag("lead_type_id", B2bLeadPeer::B2B_LEAD_SELLING, $sf_params->get("lead_type_id", $lead->getTypeId()) == B2bLeadPeer::B2B_LEAD_SELLING, 'id=lead_type_id_2') ?>
        <?php echo emt_label_for("lead_type_id_2", __(B2bLeadPeer::$typeNames[B2bLeadPeer::B2B_LEAD_SELLING]), ($sf_params->get("lead_type_id", $lead->getTypeId()) == B2bLeadPeer::B2B_LEAD_SELLING ? 'class=selected' : '')) ?>
    </dd>
<?php else: ?>
    <dt><?php echo emt_label_for('lead_type_id', __('Lead Type')) ?></dt>
    <dd>
        <strong><?php echo __(B2bLeadPeer::$typeNames[$lead->getTypeId()]) ?></strong>
        <?php echo input_hidden_tag('lead_type_id', $lead->getTypeId()) ?>
    </dd>
<?php endif ?>
    <dt class="_req"><?php echo emt_label_for('category_id', __('Product Category')) ?></dt>
    <dd>
        <ul id="pcat" class="hs-group" style="margin: 0px; padding: 0px;">
            <?php if (count($categorytree)): ?>
            <?php $cat = array_pop($categorytree) ?>
            <?php $parent_key = '' ?>
                <?php while ($cat !== null): ?>
            <li class="hs-part" id="<?php echo "lcategory_id_item" . ($parent_key == '' ? "" : "_") . "$parent_key" ?>">
                <?php $keys = array_keys($cat);
                      $key = array_pop($keys);
                      echo select_tag($parent_key !== '' ? "lcategory_id_$parent_key" : "lcategory_id", options_for_select($cat[$key], $key, array('include_custom' => __('Please Select'), 'class' => 'column first')), array('class' => 'hs-selector', 'name' => count($categorytree) > 0 ? ($parent_key !== '' ? "lcategory_id_.$parent_key" : "lcategory_id") : "category_id")); ?>
            </li>
                <?php $parent_key = $key ?>
                <?php $cat = array_pop($categorytree) ?>
                <?php endwhile ?>
            <?php endif ?>
          </ul>
    </dd>
</dl>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get('lead_lang') : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("lead_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("lead_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'lead_lang[]', 'include_blank' => true)) ?></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<span class="redspan">Attention:</span> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("product_name_$key", __('Product Name')) ?></dt>
    <dd><?php echo input_tag("product_name_$key", $sf_params->get("product_name_$key", $lead->getName($lang)), 'size=50 maxlength=128') ?></dd>
    <dt><?php echo emt_label_for("product_description_$key", __('Lead Description')) ?></dt>
    <dd><?php echo textarea_tag("product_description_$key", $sf_params->get("product_description_$key", $lead->getDescription($lang)), 'cols=52 rows=4 maxlength=1800') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'act greenspan plus-13px ln-addlink')) ?></dd>
    <dt><?php echo emt_label_for('expires_at_dp', __('Expires At')) ?></dt>
    <dd><?php echo input_hidden_tag('expires_at') ?>
        <?php echo input_tag('expires_at_dp', $sf_params->get('expires_at', $lead->getExpiresAt('Y-m-d'))) ?></dd>
    <dt><?php echo emt_label_for('payment_term', __('Payment Terms')) ?></dt>
    <dd class="two_columns" style="width:580px;">
        <?php foreach (PaymentTermPeer::getOrderedPaymentTerms() as $pt): ?>
        <?php echo checkbox_tag("payment_terms[]", $pt->getId(), in_array($pt->getId(), $payment_terms) === true, array('id' => "payment_terms_{$pt->getId()}"))  ?>
        <?php echo emt_label_for("payment_terms_{$pt->getId()}", $pt->getName(), 'class=checkbox-label') ?>
        <?php endforeach ?>
    </dd>
</dl>

<h5 class="clear"><?php echo __('Product Photos') ?></h5>
<dl class="_table">
    <dt></dt>
    <dd><?php if (count($photos)): ?>
            <div class="four_columns" style="width: 580px;">
            <?php foreach ($photos as $photo): ?>
            <div>
            <?php echo link_to(image_tag($photo->getThumbnailUri(), 'class=bordered-image'), $photo->getUri()) ?><br />
            <?php echo link_to(__('Remove'), "@edit-lead?hash={$company->getHash()}&id={$lead->getId()}&act=rmp&pid={$photo->getGuid()}") ?>&nbsp;|&nbsp;<?php echo link_to(__('View'), $photo->getUri(), 'target=blank') ?>
            </div>
            <?php endforeach ?>
            </div>
            <div class="hrsplit-1"></div>
        <?php endif ?>
            <div class="hrsplit-3 clear"></div>
        <?php echo input_file_tag('lead_file') ?></dd>
    <dt></dt>
<?php if ($lead->isNew()): ?>
    <dd><?php echo submit_tag(__('Save Lead'), 'class=green-button') ?></dd>
<?php else: ?>
    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?></dd>
<?php endif ?>
</dl>
</form>
            </section>
        </div>
    </div>
</div>
<?php
$data = sfDateTimeFormatInfo::getInstance('tr');

$json = json_encode(array('months' => implode(',', $data->getMonthNames()), 
                          'shortMonths' => implode(',', $data->getAbbreviatedMonthNames()), 
                          'days' => implode(',', $data->getDayNames()),
                          'shortDays' => implode(',', $data->getAbbreviatedDayNames())
                    )
        );
  ?>
<?php echo javascript_tag("
$('#boxContent').langform();
$('.hs-group').hierarchyselector({queryUrl: '".url_for('products/productCategories')."', paramKey: 'category_id', sendKey: 'category_id'});

$('dl._table input').customInput();

$.tools.dateinput.localize('{$sf_user->getCulture()}', $json);
$('#expires_at_dp').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#expires_at').val(isoDate);
    },
    min: 6, max: '2023-01-01', firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});
") ?>