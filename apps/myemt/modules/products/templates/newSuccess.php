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
<?php if ($product->isNew()): ?>
                <h4><?php echo __('Add Product') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@add-product?hash={$company->getHash()}", 'novalidate=novalidate') ?>
<?php else: ?>
                <h4><?php echo __('Edit Product') ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag("@edit-product?hash={$company->getHash()}&id={$product->getId()}", 'novalidate=novalidate enctype=multipart/form-data') ?>
<?php endif ?>
<h5><?php echo __('Product Classification') ?></h5>
<dl class="_table">
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
        <span class="ln-example"><?php echo __('Select a suitable product category.') ?></span>
    </dd>
</dl>
<dl class="_table" id="pr-attrs">
    <?php if ($category): ?>
    <?php foreach ($category->getAttributes() as $attr): ?>
    <dt><?php echo emt_label_for("attr_{$attr->getId()}", $attr->getName()) ?></dt>
    <dd><?php echo select_tag("attr_{$attr->getId()}", options_for_select($attr->getOptions(true), $sf_params->get("attr_{$attr->getId()}", isset($attrmatrix['qualified'][$attr->getId()]) ? (is_object($attrmatrix['qualified'][$attr->getId()]) ? $attrmatrix['qualified'][$attr->getId()]->getValue() : $attrmatrix['qualified'][$attr->getId()]) : null))) ?></dd>
    <?php endforeach ?>
    <?php else: ?>
    <dt class="pc-none"></dt>
    <dd class="pc-none"><div style="border: solid 1px #ff5555; background-color: #ffaaaa; padding: 10px;"><?php echo __('Select a Product Category to specify attributes') ?></div></dd>
    <?php endif ?>
</dl>
<dl class="_table">
    <dt><?php echo label_for('attr_val[]', __('Custom Attributes')) ?></dt>
    <dd class="custom-att-wrap">
        <div class="custom-att ghost" style="padding: 0px 0px 6px 0px;"><?php echo input_tag('tmp.attr_key[]', '', array('style' => 'width:150px;display:inline-block;', 'max-length' => 255, 'watermark' => 'Name (e.g. "Color")')) ?>
        <?php echo input_tag('tmp.attr_val[]', '', array('style' => 'width:150px;display:inline-block;', 'max-length' => 255, 'watermark' => 'Value (e.g. "Yellow")')) ?>
        <?php echo link_to_function('&nbsp;', "$(this).closest('.custom-att').remove();", array('class' => 'led delete-11px', 'title' => __('Remove Attribute'))) ?></div>
    <?php if ($sf_request->getMethod() == sfRequest::POST): ?>
    <?php foreach ($attrmatrix['unqualified'] as $key => $val): ?>
        <div class="custom-att" style="padding: 0px 0px 6px 0px;"><?php echo input_tag('attr_key[]', $key, 'style=width:150px;') ?>
        <?php echo input_tag('attr_val[]', $val, 'style=width:150px;') ?>
        <?php echo link_to_function('&nbsp;', "$(this).closest('.custom-att').remove();", 'class="led delete-11px"') ?></div>
    <?php endforeach ?>
    <?php else: ?>
    <?php foreach ($attrmatrix['unqualified'] as $attr): ?>
        <div class="custom-att" style="padding: 0px 0px 6px 0px;"><?php echo input_tag('attr_key[]', $attr->getName(), 'style=width:150px;') ?>
        <?php echo input_tag('attr_val[]', $attr->getValue(), 'style=width:150px;') ?>
        <?php echo link_to_function('&nbsp;', "$(this).closest('.custom-att').remove();", 'class="led delete-11px"') ?></div>
    <?php endforeach ?>
    <?php endif ?>
        <?php if (count($attrmatrix['unqualified']) == 0): ?>
        <div class="custom-att" style="padding: 0px 0px 6px 0px;"><?php echo input_tag('attr_key[]', '', array('style' => 'width:150px;display:inline-block;', 'max-length' => 255, 'watermark' => 'Name (e.g. "Color")')) ?>
        <?php echo input_tag('attr_val[]', '', array('style' => 'width:150px;display:inline-block;', 'max-length' => 255, 'watermark' => 'Value (e.g. "Yellow")')) ?></div>
        <?php endif ?>
        <?php echo link_to_function(__('Add Attribute'), "if ($('.custom-att-wrap').find('.custom-att').length < 11) $('.custom-att.ghost').first().clone().removeClass('ghost').insertBefore($(this)).find('input').each(function(i,p){ $(p).attr('name', $(p).attr('name').replace(/^tmp./, ''));$(p).attr('id', $(p).attr('id').replace(/^tmp./, ''));});", 'class="greenspan led add-11px"') ?>
        <span class="ln-example"><?php echo __('Specify up to 10 custom attributes for your product.') ?></span></dd>
    <dt><?php echo emt_label_for('product_keyword', __('Product Keyword')) ?></dt>
    <dd><?php echo input_tag('product_keyword',$sf_params->get('product_keyword', $product->getKeyword()), 'size=20 maxlength=50') ?>
        <span class="ln-example"><?php echo __('Enter only one keyword (e.g.: "Car Tire", max: 50 chars)') ?></span></dd>
    <dt><?php echo emt_label_for('product_origin', __('Product Origin')) ?></dt>
    <dd><?php echo select_country_tag('product_origin', $sf_params->get('product_origin', $product->getOrigin() ? $product->getOrigin() : $company->getContact()->getWorkAddress()->getCountry())) ?>
        <span class="ln-example"><?php echo __('Select the origin of the product.') ?></span></dd>
    <dt><?php echo emt_label_for('product_brand', __('Brand')) ?></dt>
    <dd><?php echo select_tag('product_brand_owner', options_for_select(CompanyBrandPeer::$typeNames, $sf_params->get('product_brand_owner', $product->getBrandName() ? CompanyBrandPeer::BRND_HOLDED_BY_ELSE : CompanyBrandPeer::BRND_HOLDED_BY_COMPANY), array('use_i18n' => true))) ?>
        <div id="swother" style="display: inline;"><?php echo input_tag('product_brand_name',$sf_params->get('product_brand_name', $product->getBrandName()), 'maxlength=200 style=width:130px;') ?></div>
        <?php $brands = $company->getOrderedBrands(true); $brands['new'] = __('Add New') ?>
        <div id="swour" style="display: inline;"><?php echo select_tag('product_brand_id', options_for_select($brands, $sf_params->get('product_brand_id', $product->getBrandId()), 'include_blank=true')) ?>
        <?php echo input_tag('product_new_brand', $sf_params->get('product_new_brand'), 'maxlength=200 style=width:130px;') ?></div>
        <span class="ln-example"><?php echo __('Specify the brand name related to your product if applicable.') ?></span></dd>
    <dt><?php echo emt_label_for('product_model', __('Model No')) ?></dt>
    <dd><?php echo input_tag('product_model',$sf_params->get('product_model', $product->getModelNo()), 'size=20 maxlength=100 style=width:100px;') ?></dd>
    <dt><?php echo emt_label_for('product_group_id', __('Display in Group')) ?></dt>
    <dd><?php $groups = $company->getOrderedGroups(true); $groups['new'] = __('New') ?>
        <?php echo select_tag('product_group_id', options_for_select($groups, $sf_params->get('product_group_id', $product->getGroupId()), 'include_blank=true')) ?>
        <?php echo input_tag('product_new_group', $sf_params->get('product_new_group'), array('maxlength' => 255, 'style' => 'width: 200px;'.($sf_params->get('product_group_id', $product->getGroupId()) == 'new' ? '' : 'display: none;'))) ?>
        <span class="ln-example"><?php echo __('Select existing product group or create new to display your products organized.') ?></span></dd>
</dl>
<h5 class="clear"><?php echo __('Product Details') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("product_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("product_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("product_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'product_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("product_name_$key", __('Product Name')) ?></dt>
    <dd><?php echo input_tag("product_name_$key",$sf_params->get("product_name_$key", $product->getName($lang)), 'size=50 maxlength=400') ?></dd>
    <dt class="_req"><?php echo emt_label_for("product_introduction_$key", __('Introduction')) ?></dt>
    <dd><?php echo textarea_tag("product_introduction_$key", $sf_params->get("product_introduction_$key", $product->getIntroduction($lang)), 'cols=52 rows=4 maxlength=1800') ?></dd>
    <dt><?php echo emt_label_for("packaging_$key", __('Packaging')) ?></dt>
    <dd><?php echo input_tag("packaging_$key", $sf_params->get("packaging_$key", $product->getPackaging($lang)), 'size=50 maxlength=200') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Ordering Details') ?></h5>
<dl class="_table">
    <dt><?php echo emt_label_for("product_min_order", __('Minimum Order')) ?></dt>
    <dd><?php echo input_tag("product_min_order", $sf_params->get('product_min_order', $product->getMinOrderQuantity()), array('style' => 'width:100px;', 'maxlength' => 16, 'watermark' => 'Numberic Value')) ?>
        <?php echo select_tag('product_min_order_unit', options_for_select(ProductQuantityUnitPeer::getOrderedQuantities(true), $sf_params->get('product_min_order_unit', $product->getQuantityUnit()), array('include_custom' => __('Select Unit')))) ?></dd>
    <dt><?php echo emt_label_for(array('product_price_currency', 'product_price_start', 'product_price_end', 'product_price_unit'), __('FOB Price')) ?></dt>
    <dd><?php echo select_currency_tag('product_price_currency', $sf_params->get('product_price_currency', $product->getPriceCurrency()), array('display' => 'code', 'include_custom' => __('Currency'), '')) ?>
        <?php echo input_tag('product_price_start', $sf_params->get('product_price_start', $product->getPriceStart()), array('style' => 'width:100px;', 'maxlength' => 16, 'watermark' => 'Numberic Value')) ?>
        <?php echo input_tag('product_price_end', $sf_params->get('product_price_end', $product->getPriceEnd()), array('style' => 'width:100px;', 'maxlength' => 16, 'watermark' => 'Numberic Value')) ?>
        <?php echo __('per %1', array('%1' => select_tag('product_price_unit', options_for_select(ProductQuantityUnitPeer::getOrderedQuantities(true), $sf_params->get('product_price_unit', $product->getPriceUnit()), array('include_custom' => __('Select Unit')))))) ?>
        </dd>
    <dt><?php echo emt_label_for('payment_term', __('Payment Terms')) ?></dt>
    <dd class="two_columns" style="width:580px;">
        <?php foreach (PaymentTermPeer::getOrderedPaymentTerms() as $pt): ?>
        <?php echo checkbox_tag("payment_terms[]", $pt->getId(), in_array($pt->getId(), $payment_terms) === true, array('id' => "payment_terms_{$pt->getId()}"))  ?>
        <?php echo emt_label_for("payment_terms_{$pt->getId()}", $pt->getName(), 'class=checkbox-label') ?>
        <?php endforeach ?>
    </dd>
    <dt><?php echo emt_label_for("product_capacity", __('Production Capacity')) ?></dt>
    <dd><?php echo input_tag("product_capacity", $sf_params->get('product_capacity', $product->getCapacity()), array('style' => 'width:100px;', 'maxlength' => 16, 'watermark' => 'Numberic Value')) ?>
        <?php echo select_tag('product_capacity_unit', options_for_select(ProductQuantityUnitPeer::getOrderedQuantities(true), $sf_params->get('product_capacity_unit', $product->getCapacityUnit()), array('include_custom' => __('Select Unit')))) ?>
        <?php echo __('per %1', array('%1' => select_tag('product_capacity_period', options_for_select(TimePeriodPeer::getOrderedPeriods(true), $sf_params->get('product_capacity_period', $product->getCapacityPeriodId()), array('include_custom' => __('Select Period')))))) ?>
        </dd>
</dl>
<h5 class="clear"><?php echo __('Product Photo') ?></h5>
<dl class="_table">
    <dt><?php echo emt_label_for("product_photo", __('Select File')) ?></dt>
    <dd><?php echo input_file_tag("product_photo", '') ?></dd>
    <dt></dt>
<?php if ($product->isNew()): ?>
    <dd><?php echo submit_tag(__('Save Product'), 'class=green-button') ?></dd>
<?php else: ?>
    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?></dd>
<?php endif ?>
</dl>
</form>
            </section>
        </div>
    </div>
</div>
<dl id="attr_sample" class="ghost">
    <dt><?php echo emt_label_for("attr__ID_", '_NAME_') ?></dt>
    <dd><?php echo select_tag("attr__ID_", '') ?></dd>
</dl>

<?php echo javascript_tag("
$(function() {
    $('span.btn_container').buttonset();

    $('#boxContent').langform({afterAdd: function(){\$('.frmhelp').tooltip();}});

    $('.hs-group').hierarchyselector({
        queryUrl: '".url_for('products/productCategories')."', 
        paramKey: 'category_id', 
        sendKey: 'pcategory_id', 
        selectComplete: function(c,d){
            if (!isNaN(c)) {
                $('.pc-none').hide();
                $('#pr-attrs:visible').html('');
                var items = d.ATTRIBUTES;
                $(items).each(function(a,pl){
                    var attr = $('#attr_sample').clone();
                    var sel = attr.find('select');
                    var label = attr.find('label');
                    
                    label.text(pl['NAME']); 
                    label.attr('for', label.attr('for').replace('_ID_', pl['ID']));
                    sel.attr('id', sel.attr('id').replace('_ID_', pl['ID']));
                    sel.attr('name', sel.attr('name').replace('_ID_', pl['ID']));

                    var opt = pl.OPTIONS;
                    
                    for (key in opt) {sel.append($('<option value='+key+'>'+opt[key]+'</option>'));}
                    $('#pr-attrs').append(attr.html());
                });
            };
        }, 
        staticParams: {attr: 'yes'}
    });
    
    //$('input, textarea').watermark();
    
    $('#product_brand_owner').branch({map: {1: '#swour', 2: '#swother'}})
    $('#product_brand_id').branch({map: {'new': '#product_new_brand'}})
    $('#product_group_id').branch({map: {'new': '#product_new_group'}})
    
    $('dl._table input').customInput();
    
});
") ?>