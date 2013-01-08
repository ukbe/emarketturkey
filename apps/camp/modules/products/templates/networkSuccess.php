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
            <h4 style="border-bottom:none;"><?php echo __('Browse Products from Your Network') ?></h4>
            <div class="hor-filter">
                <?php echo $category ? __('Category:') . ' ' . link_to($category->__toString(), "@products-action?action=network&keyword=$keyword&page=$page&country=$country", array('class' => 'filter-remove-link', 'title' => __('Remove Category Filter'))) : "" ?>
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@products-action?action=network&page=$page&country=$country" . ($category ? "&category={$category->getId()}" : ""), array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
            </div>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <div class="hrsplit-2"></div>
            <div class="clear">
                <?php include_partial("layout_extended", array('pager' => $pager)) ?>
            </div>
            <div class="hrsplit-2"></div>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>