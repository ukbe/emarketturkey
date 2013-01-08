<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">

<?php include_partial('leads', array('type_code' => $type_code, 'type_id' => $type_id)) ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo $type_id == B2bLeadPeer::B2B_LEAD_BUYING ? __('Browse Buying Leads from Your Network') : __('Browse Selling Leads from Your Network') ?></h4>
            <div class="hor-filter">
                <?php echo $category ? __('Category:') . ' ' . link_to($category, "@leads-action?action=network&keyword=$keyword&page=$page&p_country=$country", array('class' => 'filter-remove-link', 'title' => __('Remove Category Filter'))) : "" ?>
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@leads-action?action=network&page=$page&country=$country" . ($category ? "&category={$category->getId()}" : ""), array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
                <?php echo $country ? __('Country:') . ' ' . link_to(format_country($country), "@leads-action?action=network&page=$page&keyword=$keyword" . ($category ? "&category={$category->getId()}" : ""), array('class' => 'filter-remove-link', 'title' => __('Remove Country Filter'))) : "" ?>
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