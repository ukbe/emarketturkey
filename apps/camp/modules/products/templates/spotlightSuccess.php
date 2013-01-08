<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">

<?php include_partial('products') ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('Products Spotlight') ?></h4>
            <div class="clear">
                <?php foreach ($spot_products as $product): ?>
                <?php include_partial('product/product', array('product' => $product)) ?>
                <?php endforeach ?>
            </div>
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>