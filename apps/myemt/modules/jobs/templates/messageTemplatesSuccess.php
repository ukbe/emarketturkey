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
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            
            <section>
                <h4 style="border-bottom: none;">
                    <?php echo __('Message Templates') ?>
                </h4>
                <span class="btn_container ui-smaller">
                </span>
                <div class="_right view_select">
                </div>
                <div class="hor-filter">
                    <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "$route&action=manage&status=$status&page=$page&ipp=$ipp&view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_mes_temp_{$view}", array('pager' => $pager, 'route' => $route, 'profile' => $profile, 'query' => "status=$status&page=$page&ipp=$ipp"  . ($keyword ? "&jfunc=".urlencode($keyword) : "") . "&view=$view")) ?>
                </div>
            </section>
        </div>
    </div>
</div>                    