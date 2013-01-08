<?php slot('subNav') ?>
<?php include_partial('global/subNav_cm') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('people') ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('People You May Know') ?></h4>
            <noscript>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <div class="hrsplit-2"></div>
            </noscript>
            <div class="clear">
                <?php include_partial("layout_extended", array('pager' => $pager, 'query' => "page=$page")) ?>
            </div>
            <div class="hrsplit-2"></div>
            <noscript>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            </noscript>
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>
<?php use_javascript('emt-feeder-1.0.js') ?>
<?php echo javascript_tag("
$(function(){

    $('table.data-table').emtfeeder({bookmark: $page, replace: true, paramName: 'bookmark'}); 

});

") ?>