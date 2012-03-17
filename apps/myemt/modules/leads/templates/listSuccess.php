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
                <h4><?php echo __('Leads') ?></h4>
                <span class="btn_container ui-smaller">
                    <?php echo link_to(__('Selling'), "@list-leads?hash={$company->getHash()}&page=$page&ipp=$ipp&view=$view&type=".B2bLeadPeer::B2B_LEAD_BUYING, $type == B2bLeadPeer::B2B_LEAD_BUYING ? 'class=ui-state-selected' : '') ?>
                    <?php echo link_to(__('Buying'), "@list-leads?hash={$company->getHash()}&page=$page&ipp=$ipp&view=$view&type=".B2bLeadPeer::B2B_LEAD_SELLING, $type == B2bLeadPeer::B2B_LEAD_SELLING ? 'class=ui-state-selected' : '') ?>
                </span>
                <div class="_right view_select">
                    <?php echo link_to('&nbsp;', "@list-leads?hash={$company->getHash()}&type=$type&page=$page&ipp=$ipp&view=list", array('title' => __('List View'), 'class' => 'list-view frmhelp' . ($view == 'list' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "@list-leads?hash={$company->getHash()}&type=$type&page=$page&ipp=$ipp&view=extended", array('title' => __('Extended View'), 'class' => 'extended-view frmhelp' . ($view == 'extended' ? ' _selected' : ''))) ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_{$view}", array('pager' => $pager, 'query' => "hash={$company->getHash()}&type=$type&page=$page&ipp=$ipp&view=$view")) ?>
                </div>
            </section>

        </div>
        
    </div>

    <div class="col_180">
    </div>
</div>
