<?php use_helper('Date') ?>
<table class="data-table extended">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Product Details') ?></th>
            <th><?php echo __('') ?></th>
            <th><?php echo __('Published') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $product): ?>
    <tr>
        <td><?php echo link_to(image_tag($product->getThumbUri()), $product->getManageUrl()) ?></td>
        <td><strong><?php echo link_to($product->getName($product->getDefaultLang()), $product->getManageUrl()) ?></strong>
            <em><?php echo __('Category: ') . link_to($product->getProductCategory(), "@list-products?$query&category={$product->getCategoryId()}") ?></em>
            <em><?php echo $product->getProductGroup() ? __('Group: ') . link_to($product->getProductGroup(), "@list-products?$query&group={$product->getGroupId()}") : '' ?></em>
            </td>
        <td></td>
        <td><?php echo link_to(format_datetime($product->getCreatedAt('U'), 'F'), $product->getManageUrl()) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>