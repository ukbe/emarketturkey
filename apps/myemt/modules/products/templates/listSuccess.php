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
            <section>
                <h4><?php echo __('Products') ?></h4>
                <span class="btn_container ui-smaller">
                    <?php echo link_to(__('Approved'), "@list-products?hash={$company->getHash()}&page=$page&ipp=$ipp&view=$view&status=".ProductPeer::PR_STAT_APPROVED, $status == ProductPeer::PR_STAT_APPROVED ? 'class=ui-state-selected' : '') ?>
                    <?php echo link_to(__('Pending Approval'), "@list-products?hash={$company->getHash()}&page=$page&ipp=$ipp&view=$view&status=".ProductPeer::PR_STAT_PENDING_APPROVAL, $status == ProductPeer::PR_STAT_PENDING_APPROVAL ? 'class=ui-state-selected' : '') ?>
                    <?php echo link_to(__('Editing Required'), "@list-products?hash={$company->getHash()}&page=$page&ipp=$ipp&view=$view&status=".ProductPeer::PR_STAT_EDITING_REQUIRED, $status == ProductPeer::PR_STAT_EDITING_REQUIRED ? 'class=ui-state-selected' : '') ?>
                </span>
                <div class="_right view_select">
                    <?php echo link_to('&nbsp;', "@list-products?hash={$company->getHash()}&status=$status&page=$page&ipp=$ipp&" . ($group ? "group={$group->getId()}&" : "") . ($category ? "category={$category->getId()}&" : "") . "view=list", array('title' => __('List View'), 'class' => 'list-view frmhelp' . ($view == 'list' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "@list-products?hash={$company->getHash()}&status=$status&page=$page&ipp=$ipp&" . ($group ? "group={$group->getId()}&" : "") . ($category ? "category={$category->getId()}&" : "") . "view=extended", array('title' => __('Extended View'), 'class' => 'extended-view frmhelp' . ($view == 'extended' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "@list-products?hash={$company->getHash()}&status=$status&page=$page&ipp=$ipp&" . ($group ? "group={$group->getId()}&" : "") . ($category ? "category={$category->getId()}&" : "") . "view=thumbs", array('title' => __('Thumbnails View'), 'class' => 'thumbs-view frmhelp' . ($view == 'thumbs' ? ' _selected' : ''))) ?>
                </div>
                <div class="hor-filter">
                    <?php echo $category ? __('Category:') . ' ' . link_to($category, "@list-products?hash={$company->getHash()}&status=$status&page=$page&ipp=$ipp&" . ($group ? "group={$group->getId()}&" : "") . "view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Category Filter'))) : "" ?>
                    <?php echo $group ? __('Group:') . ' ' . link_to($group, "@list-products?hash={$company->getHash()}&status=$status&page=$page&ipp=$ipp&" . ($category ? "category={$category->getId()}&" : "") . "view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Group Filter'))) : "" ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_{$view}", array('pager' => $pager, 'query' => "hash={$company->getHash()}&status=$status&page=$page&ipp=$ipp&view=$view")) ?>
                </div>
            </section>

        </div>
        
    </div>

    <div class="col_180">
    </div>
</div>