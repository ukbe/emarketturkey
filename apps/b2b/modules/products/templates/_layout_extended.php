<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $product): ?>
    <tr>
        <td><?php echo link_to(image_tag($product->getPictureUri()), $product->getUrl()) ?></td>
        <td><strong><?php echo link_to($product, $product->getUrl()) ?></strong>
            <em><?php echo $product->getProductCategory() ?></em>
            <p><?php echo $product->getCompany() ?></p>
            </td>
        <td></td>
        <td><?php echo $product->getCompany()->getContact()->getWorkAddress()->getGeonameCity(). ', ' . format_country($product->getCompany()->getContact()->getWorkAddress()->getCountry()) . '' ?>
        <div>
        <?php if (isset($product->relevel)): ?><span class="relevel margin-t2">
        <?php if (isset($product->role_id)): ?><span class="role"><?php echo RolePeer::retrieveByPK($product->role_id) ?></span><?php endif ?>
        <?php echo $product->relevel ?></span>
        <?php endif ?></div></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>