<div class="col_948">
    <div class="col_180">

<?php include_partial('tradeexperts') ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('Browse Trade Experts in Your Network') ?></h4>
            <div class="hor-filter">
                <?php echo $industry ? __('Industry:') . ' ' . link_to($industry, "@tradeexperts-action?action=connected&keyword=$keyword&page=$page&country=$country", array('class' => 'filter-remove-link', 'title' => __('Remove Industry Filter'))) : "" ?>
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@tradeexperts-action?action=connected&page=$page&p_country=$country" . ($industry ? "&industry={$industry->getId()}" : ""), array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
                <?php echo $country ? __('Country:') . ' ' . link_to(format_country($country), "@tradeexperts-action?action=connected&page=$page&keyword=$keyword" . ($industry ? "&industry={$industry->getId()}" : ""), array('class' => 'filter-remove-link', 'title' => __('Remove Country Filter'))) : "" ?>
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