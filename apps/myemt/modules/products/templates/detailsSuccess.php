<?php use_helper('DateForm', 'Number') ?>

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
                <h4>
                <div class="_right"><?php echo link_to(__('Edit Product'), "@edit-product?hash={$company->getHash()}&id={$product->getId()}", 'class=action-button') ?>
                                    <?php echo link_to(__('Delete Product'), "@delete-product?hash={$company->getHash()}&id={$product->getId()}", "class=action-button ajax-enabled id=rempit{$product->getId()}") ?></div>
                <?php echo __('Product Details: <span class="sparkle">%1</span>', array('%1' => $product->getName())) ?>
                <div><?php if ($product->isOnline()): ?><span class="tag online-11px"><?php echo __('Online') ?></span><?php else:  ?><span class="tag offline-11px"><?php echo __('Offline') ?></span><?php endif ?>
                     </div></h4>
<h5><?php echo __('Product Classification') ?></h5>
<dl class="_table _noInput">
    <dt><?php echo emt_label_for('category_id', __('Category')) ?></dt>
    <dd><?php echo $category ?></dd>
</dl>
<dl class="_table _noInput" id="pr-attrs">
    <?php foreach ($category->getAttributes() as $attr): ?>
    <dt><?php echo emt_label_for("attr_{$attr->getId()}", $attr->getName()) ?></dt>
    <dd><?php echo isset($attrmatrix['qualified'][$attr->getId()]) ? $attrmatrix['qualified'][$attr->getId()]->getProductAttrOption() : __('Not Set') ?></dd>
    <?php endforeach ?>
</dl>
<dl class="_table _noInput">
    <dt><?php echo label_for('attr_val[]', __('Custom Attributes')) ?></dt>
    <dd><?php if (count($attrmatrix['unqualified'])): ?>
    <table class="key-value-pairs">
        <tr><th><?php echo __('Attribute') ?></th><th><?php echo __('Value') ?></th></tr>
    <?php foreach ($attrmatrix['unqualified'] as $attr): ?>
        <tr><td><?php echo $attr->getName() ?></td><td><?php echo $attr->getValue() ?></td></tr>
    <?php endforeach ?>
    </table>
        <?php else: ?>
        <?php echo __('No Custom Attributes') ?>
        <?php endif ?>
        </dd>
    <dt><?php echo emt_label_for('product_keyword', __('Product Keyword')) ?></dt>
    <dd><?php echo $product->getKeyword() ?></dd>
    <dt><?php echo emt_label_for('product_origin', __('Product Origin')) ?></dt>
    <dd><?php echo format_country($product->getOrigin()) ?></dd>
    <dt><?php echo emt_label_for('product_brand', __('Brand')) ?></dt>
    <dd><?php echo $product->getAbsBrandName() ?></dd>
    <dt><?php echo emt_label_for('product_model', __('Model No')) ?></dt>
    <dd><?php echo $product->getModelNo() ?></dd>
    <dt><?php echo emt_label_for('product_group_id', __('Display in Group')) ?></dt>
    <dd><?php echo $product->getProductGroup() ? $product->getProductGroup()->getNameByPriority() . link_to('(' . __('Edit Group') . ')', "@edit-product-group?hash={$company->getHash()}&id={$product->getGroupId()}&_ref=$_here") : '' ?></dd>
</dl>
<h5 class="clear"><?php echo __('Product Details') ?></h5>
        <?php foreach ($i18ns as $key => $lang): ?>
        <h3<?php echo $cks = ($sf_user->getCulture() == $lang || (!in_array($sf_user->getCulture(), $i18ns) && $lang == $product->getDefaultLang()) ? ' class="current"' : '') ?>><?php echo format_language($lang) ?></h3>
        <dl class="_table ln-part _noInput">
            <dt></dt>
            <dd class="right"><div class="ghost"><?php echo link_to(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), "@edit-product?hash={$company->getHash()}&id={$product->getId()}&act=remi18n&ln=$lang") ?></div></dd>
            <dt><?php echo __('Product Name') ?></dt>
            <dd><?php echo $product->getName($lang) ?></dd>
            <dt><?php echo __('Introduction') ?></dt>
            <dd><?php echo format_text($product->getClob(ProductI18nPeer::INTRODUCTION, $lang)) ?></dd>
            <dt><?php echo __('Packaging') ?></dt>
            <dd><?php echo $product->getPackaging($lang) ?></dd>
        </dl>
        <div class="clear"></div>
        <?php endforeach ?>
    
        <?php if (count($i18ns) < count(sfConfig::get('app_i18n_cultures'))): ?>
        <?php echo link_to(__('Add Translation'), "@edit-product?hash={$company->getHash()}&id={$product->getId()}#addtrans", 'class=led add-11px') ?>
        <?php endif ?>
<h5 class="clear"><?php echo __('Ordering Details') ?></h5>
<dl class="_table _noInput">
    <dt><?php echo emt_label_for("product_min_order", __('Minimum Order')) ?></dt>
    <dd><?php echo $product->getMinOrderQuantity() ?>&nbsp;
        <?php echo $product->getProductQuantityUnitRelatedByQuantityUnit() ?></dd>
    <dt><?php echo emt_label_for("product_price_unit", __('FOB Price')) ?></dt>
    <dd><?php echo implode(' - ', array_filter(array($product->getPriceStart(), $product->getPriceEnd()))) ?>&nbsp;
        <?php echo $product->getPriceCurrency() ?>
        <?php echo __('per %1', array('%1' => $product->getProductQuantityUnitRelatedByPriceUnit())) ?></dd>
    <dt><?php echo emt_label_for('payment_term', __('Payment Terms')) ?></dt>
    <dd class="two_columns" style="width: 580px;">
        <?php foreach ($product->getPaymentTermList() as $pt): ?>
        <div><?php echo $pt->getName() ?></div>
        <?php endforeach ?>
    </dd>
    <dt><?php echo emt_label_for("product_capacity", __('Production Capacity')) ?></dt>
    <dd><?php echo $product->getCapacity() ?>&nbsp;
        <?php echo $product->getProductQuantityUnitRelatedByCapacityUnit() ?>
        <?php echo __('per %1', array('%1' => $product->getTimePeriod())) ?>
        </dd>
</dl>
<h5 class="clear"><?php echo __('Product Photos') ?></h5>
<dl class="_table whoatt">
    <dt></dt>
    <dd><?php if (count($photos)): ?>
        <?php foreach ($photos as $photo): ?>
        <div>
        <?php echo link_to(image_tag($photo->getThumbnailUri(), 'class=bordered-image'), $photo->getUri(), array('title' => __('Click to view'))) ?><br />
        <?php echo link_to('&nbsp;', "@edit-product?hash={$company->getHash()}&id={$product->getId()}&act=rmp&pid={$photo->getId()}&ref=$_here", array('class' => 'remove', 'title' => __('Remove Photo'))) ?>
        </div>
        <?php endforeach ?>
        <div class="hrsplit-1"></div>
        <?php else: ?>
        <?php echo __('No photos') ?>
        <?php endif ?></dd>
    </dd>
</dl>
            </section>
        </div>
    </div>
</div>
<?php echo javascript_tag("
$(function() {

    $('.flowpanes').scrollable({ circular: true, mousewheel: false }).navigator({
        navi: '#flowtabs',
        naviItem: 'a',
        activeClass: 'current',
        history: true
    });

    $('.whoatt a[title!=\"\"]').tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });
});
") ?>