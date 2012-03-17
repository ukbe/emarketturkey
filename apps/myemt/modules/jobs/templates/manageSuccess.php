<?php use_helper('Date') ?>
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

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Manage Jobs') ?></h4>
                <span class="btn_container ui-smaller">
                <?php foreach (JobPeer::$typeNames as $stat => $label): ?>
                    <?php echo link_to(__($label), "$route&action=manage&page=$page&ipp=$ipp&view=$view&status=$stat" . ($jfunc ? "&jfunc={$jfunc->getId()}" : ""), $status == $stat ? 'class=ui-state-selected' : '') ?>
                <?php endforeach ?>
                </span>
                <div class="_right view_select">
                    <?php echo link_to('&nbsp;', "$route&action=manage&status=$status&page=$page&ipp=$ipp"  . ($jfunc ? "&jfunc={$jfunc->getId()}" : "") . "&view=list", array('title' => __('List View'), 'class' => 'list-view frmhelp' . ($view == 'list' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&action=manage&status=$status&page=$page&ipp=$ipp"  . ($jfunc ? "&jfunc={$jfunc->getId()}" : "") . "&view=extended", array('title' => __('Extended View'), 'class' => 'extended-view frmhelp' . ($view == 'extended' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&action=manage&status=$status&page=$page&ipp=$ipp"  . ($jfunc ? "&jfunc={$jfunc->getId()}" : "") . "&view=thumbs", array('title' => __('Thumbnails View'), 'class' => 'thumbs-view frmhelp' . ($view == 'thumbs' ? ' _selected' : ''))) ?>
                </div>
                <div class="hor-filter">
                    <?php echo $jfunc ? __('Function:') . ' ' . link_to($jfunc, "$route&action=manage&status=$status&page=$page&ipp=$ipp&view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Job Function Filter'))) : "" ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_{$view}", array('pager' => $pager, 'route' => $route, 'query' => "status=$status&page=$page&ipp=$ipp"  . ($jfunc ? "&jfunc={$jfunc->getId()}" : "") . "&view=$view")) ?>
                </div>
            </section>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_Transparent">
            <h3><?php echo __('Post Job') ?></h3>
            <div class="_center">
                <?php if ($purchased_items > 0): ?>
                <?php $level = ($purchased_items - $used_items) / $purchased_items * 100 ?>
                <div class="frmhelp" title="<?php echo __("You have used %1 out of %2 posts", array('%1' => $used_items, '%2' => $purchased_items)) ?>">
                    <div class="quotabar <?php echo $level > 50 ? 'high' : ($level > 33 ? 'fair' : 'low') ?>"></div>
                    <?php echo __('%1 posts left', array('%1' => ($purchased_items - $used_items))) ?>
                </div>
                <?php use_javascript('jquery.ui-1.8.14.progressbar.js'); ?>
                <?php echo javascript_tag("$('.quotabar').progressbar({value: $level});") ?>
                <?php if ($level <= 33): ?>
                <div class="hrsplit-1"></div>
                <?php echo link_to(__('Purchase Job Posts'), "$route&action=purchase") ?>
                <?php endif ?>
                <?php else: ?>
                <?php echo __('Start using right away.') ?>
                <?php endif ?>
                <div class="hrsplit-2"></div>
                <?php echo link_to(__('Post Job'), "$route&action=post", 'class=green-button') ?>
            </div>
        </div>

        <div class="box_180 _titleBG_Transparent">
            <h3><?php echo $owner->getHRProfile() ? __('Edit HR Profile') : __('Create HR Profile') ?></h3>
            <div class="_center">
                <?php echo __("You can specify basic settings for your job posts.") ?>
                <div class="hrsplit-2"></div>
                <?php echo link_to($owner->getHRProfile() ? __('Edit HR Profile') : __('Create HR Profile'), "$route&action=profile&act=edit", 'class=green-button') ?>
            </div>
        </div>
    </div>
    
</div>
