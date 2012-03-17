<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Product') ?></th>
            <th><?php echo __('Category') ?></th>
            <th><?php echo __('Published') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $product): ?>
    <tr>
        <td><?php echo link_to(image_tag($product->getThumbUri()), $product->getManageUrl()) ?></td>
        <td><?php echo link_to($product->getName($product->getDefaultLang()), $product->getManageUrl()) ?></td>
        <td><?php echo link_to($product->getProductCategory(), $product->getManageUrl()) ?></td>
        <td><?php echo link_to(time_ago_in_words($product->getCreatedAt('U')), $product->getManageUrl()) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>