<?php use_helper('EmtAjaxTable') ?>
<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('products/products', array('company' => $company)) ?>
        </div>
    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Product Groups') ?></h4>
                <div class="clear">
<table class="data-table list">
    <thead>
        <tr>
            <th><?php echo __('Product Group Name') ?></th>
            <th colspan="2"><?php echo __('Products in Group') ?></th>
        </tr>
    </thead>
<?php foreach ($groups as $group): ?>
    <tr>
        <td><?php echo link_to($group->getNameByPriority(), $group->getEditUrl()) ?></td>
        <td><?php echo link_to(format_number_choice(__('[0]No products|[1]1 product|(1,+Inf]%1 products'), array('%1' => $group->countProducts()), $group->countProducts()), "@list-products?hash={$company->getHash()}&group={$group->getId()}") ?></td>
        <td><?php echo link_to(image_tag('layout/icon/delete-icon-16px.png'), url_for($sf_context->getRouting()->getCurrentInternalUri()) . "?act=rmg&gid={$group->getId()}", array('class' => 'frmhelp', 'title' => __('Delete Product Group'))) ?></td>
    </tr>
<?php endforeach ?>
</table>
<div class="hrsplit-1"></div>
<?php echo link_to(__('Add Product Group'), "@new-product-group?hash={$company->getHash()}", 'class=led add-11px') ?>
                </div>
            </section>

        </div>
        
    </div>

    <div class="col_180">
    </div>
</div>