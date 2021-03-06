<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('people') ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('Browse People in Your Network') ?></h4>
            <div class="hor-filter margin-t1">
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@people-action?action=connected&page=$page&country=$country", array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
                <?php echo $country ? __('Country:') . ' ' . link_to(format_country($country), "@people-action?action=featured&page=$page&keyword=$keyword", array('class' => 'filter-remove-link', 'title' => __('Remove Country Filter'))) : "" ?>
            </div>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <div class="hrsplit-2"></div>
            <div class="clear">
                <?php include_partial("layout_extended", array('pager' => $pager, 'query' => "keyword=$keyword&page=$page&country=$country", 'sesuser' => $sesuser, '_here' => $_here)) ?>
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