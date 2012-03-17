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
            <h4><?php echo __('Products Overview') ?></h4>
        </div>
        
    <div class="box_285 _titleBG_White overview-list">
        <h3><?php echo __('Approved Products') ?></h3>
        <div class="boxContent">
        <?php if (count($active_products)): ?>
        <ul class="overview-list">
            <?php foreach (array_slice($active_products, 0, 5) as $product): ?>
            <li><?php echo link_to($product->getName(), $product->getManageUrl()) ?></li>
            <?php endforeach ?>
        </ul>
        <?php if (count($active_products) > 5): ?>
        <?php echo link_to(__('see all'), "@list-products?hash={$company->getHash()}&status=".ProductPeer::PR_STAT_APPROVED) ?>
        <?php endif ?>
        <?php else: ?>
        <p><?php echo __('No products') ?></p>
        <?php endif ?>
        </div>
    </div>
    
    <div class="box_285 _titleBG_White overview-list">
        <h3><?php echo __('Editing Required') ?></h3>
        <div class="boxContent">
        <?php if (count($must_edit_products)): ?>
        <ul class="overview-list">
            <?php foreach (array_slice($must_edit_products, 0, 5) as $product): ?>
            <li><?php echo $product->getName() ?></li>
            <?php endforeach ?>
        </ul>
        <?php if (count($must_edit_products) > 5): ?>
        <?php echo link_to(__('see all'), "@list-products?hash={$company->getHash()}&status=".ProductPeer::PR_STAT_EDITING_REQUIRED) ?>
        <?php endif ?>
        <?php else: ?>
        <p><?php echo __('No products') ?></p>
        <?php endif ?>
        </div>
    </div>

    <div class="box_285 _titleBG_White overview-list">
        <h3><?php echo __('Pending Approval') ?></h3>
        <div class="boxContent">
        <?php if (count($pending_products)): ?>
        <ul class="overview-list">
            <?php foreach (array_slice($pending_products, 0, 5) as $product): ?>
            <li><?php echo $product->getName() ?></li>
            <?php endforeach ?>
        </ul>
        <?php if (count($pending_products) > 5): ?>
        <?php echo link_to(__('see all'), "@list-products?hash={$company->getHash()}&status=".ProductPeer::PR_STAT_PENDING_APPROVAL) ?>
        <?php endif ?>
        <?php else: ?>
        <p><?php echo __('No products') ?></p>
        <?php endif ?>
        </div>
    </div>

    </div>

    <div class="box_180">
    <h3><?php echo __('Get your products listed') ?></h3>
    <div>
    <?php echo link_to(__('Add Product'), "@add-product?hash={$company->getHash()}", 'class=green-button') ?>
    </div>
    </div>
    
</div>

<script type="text/javascript">


$(function() {

    $('ul.tabs').tabs('div.panes > div');
    
    $("span.btn_container").buttonset();
});
</script>