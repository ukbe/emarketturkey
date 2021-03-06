<div class="col_948">
    <div class="col_180">
<?php include_partial('venues') ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('Browse Featured Venues') ?></h4>
            <div class="hor-filter">
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@venues-action?action=featured&page=$page&country=$country", array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
                <?php echo $country ? __('Country:') . ' ' . link_to(format_country($country), "@venues-action?action=featured&page=$page&keyword=$keyword", array('class' => 'filter-remove-link', 'title' => __('Remove Country Filter'))) : "" ?>
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