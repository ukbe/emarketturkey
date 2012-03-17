<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('events/events', array('owner' => $owner, 'route' => $route)) ?>
        </div>
    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Events') ?></h4>
                <div class="_right view_select">
                    <?php echo link_to('&nbsp;', "$route&action=manage&status=$status&page=$page&ipp=$ipp&view=list", array('title' => __('List View'), 'class' => 'list-view frmhelp' . ($view == 'list' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&action=manage&status=$status&page=$page&ipp=$ipp&view=extended", array('title' => __('Extended View'), 'class' => 'extended-view frmhelp' . ($view == 'extended' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&action=manage&status=$status&page=$page&ipp=$ipp&view=thumbs", array('title' => __('Thumbnails View'), 'class' => 'thumbs-view frmhelp' . ($view == 'thumbs' ? ' _selected' : ''))) ?>
                </div>
                <div class="hor-filter">
                    </div>
                <div class="clear">
                    <?php include_partial("layout_{$view}", array('pager' => $pager, 'query' => "$route&status=$status&page=$page&ipp=$ipp&view=$view")) ?>
                </div>
            </section>

        </div>
        
    </div>

    <div class="col_180">
    </div>
</div>
