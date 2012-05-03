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
                <h4><?php echo __('Welcome to eMarketTurkey Jobs!') ?></h4>
                <?php if (!$owner->getHRProfile()): ?>
                    <?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
                    <?php echo __("In order to use EMT Jobs, you should initially create your company's <b>HR Profile</b>.") ?><br /><br />
                    <?php echo __("You may create now by clicking the link below.") ?><br /><br />
                    <?php echo link_to(image_tag('layout/button/start-now.'.$sf_user->getCulture().'.png'), "@company-jobs-action?action=profile&hash=$own", array('query_string' => 'act=edit')) ?>
                    <?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
                    <?php echo __("In order to use EMT Jobs, you should initially create your group's <b>HR Profile</b>.") ?><br /><br />
                    <?php echo __("You may create now by clicking the link below.") ?><br /><br />
                    <?php echo link_to(image_tag('layout/button/start-now.'.$sf_user->getCulture().'.png'), "@group-jobs-action?action=profile&hash=$own", array('query_string' => 'act=edit')) ?>
                    <?php endif ?>
                <?php else: ?>
                <div style="font: bold 12px tahoma; color: #333333; margin: 10px 0px;">
                <?php echo image_tag('layout/icon/online-icon.png', 'style=float:left;margin:1px 7px 1px 0px;') ?>
                <?php echo __('Online Jobs') . ' ' . link_to(__('(see all)'), "$route&action=manage&status=".JobPeer::JSTYP_ONLINE."&page=1") ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_list", array('pager' => $online_pager, 'query' => "$route&action=manage&status=".JobPeer::JSTYP_ONLINE."&page=1")) ?>
                </div>

                <div style="font: bold 12px tahoma; color: #333333; margin: 10px 0px;">
                <?php echo image_tag('layout/icon/offline-icon.png', 'style=float:left;margin:1px 7px 1px 0px;') ?>
                <?php echo __('Offline Jobs') . ' ' . link_to(__('(see all)'), "$route&action=manage&status=".JobPeer::JSTYP_OFFLINE."&page=1") ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_list", array('pager' => $offline_pager, 'query' => "$route&status=".JobPeer::JSTYP_OFFLINE."&page=1")) ?>
                </div>
                <?php endif ?>
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
