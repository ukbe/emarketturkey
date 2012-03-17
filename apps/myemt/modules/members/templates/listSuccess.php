<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('members/members', array('group' => $group)) ?>
        </div>
    </div>
<?php $route = "@group-members?hash={$group->getHash()}&action=list" ?>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('List Members') ?></h4>
                <span class="btn_container ui-smaller">
                    <?php echo link_to(__('Users'), "$route&page=$page&ipp=$ipp&view=$view&typ=user" . ($type_id==PrivacyNodeTypePeer::PR_NTYP_USER && $gender ? "&gn=$gender" : ""), $type_id == PrivacyNodeTypePeer::PR_NTYP_USER ? 'class=ui-state-selected' : '') ?>
                    <?php echo link_to(__('Companies'), "$route&page=$page&ipp=$ipp&view=$view&typ=company" . ($type_id==PrivacyNodeTypePeer::PR_NTYP_COMPANY &&  $sector ? "&sct={$sector->getId()}" : ""), $type_id == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? 'class=ui-state-selected' : '') ?>
                </span>
                <div class="_right view_select">
                    <?php echo link_to('&nbsp;', "$route&page=$page&ipp=$ipp&typ=$type" . ($type_id==PrivacyNodeTypePeer::PR_NTYP_USER && $gender ? "&gn=$gender" : "") . ($type_id==PrivacyNodeTypePeer::PR_NTYP_COMPANY && $sector ? "&sct={$sector->getId()}" : "") . "&view=list", array('title' => __('List View'), 'class' => 'list-view frmhelp' . ($view == 'list' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&page=$page&ipp=$ipp&typ=$type" . ($type_id==PrivacyNodeTypePeer::PR_NTYP_USER && $gender ? "&gn=$gender" : "") . ($type_id==PrivacyNodeTypePeer::PR_NTYP_COMPANY && $sector ? "&sct={$sector->getId()}" : "") . "&view=extended", array('title' => __('Extended View'), 'class' => 'extended-view frmhelp' . ($view == 'extended' ? ' _selected' : ''))) ?>
                    <?php echo link_to('&nbsp;', "$route&page=$page&ipp=$ipp&typ=$type" . ($type_id==PrivacyNodeTypePeer::PR_NTYP_USER && $gender ? "&gn=$gender" : "") . ($type_id==PrivacyNodeTypePeer::PR_NTYP_COMPANY && $sector ? "&sct={$sector->getId()}" : "") . "&view=thumbs", array('title' => __('Thumbnails View'), 'class' => 'thumbs-view frmhelp' . ($view == 'thumbs' ? ' _selected' : ''))) ?>
                </div>
                <div class="hor-filter">
                    <?php echo $type_id==PrivacyNodeTypePeer::PR_NTYP_USER && $gender ? __('Gender:') . ' ' . link_to(UserProfilePeer::$Gender[$gender], "$route&page=$page&ipp=$ipp&typ=$type&view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Gender Filter'))) : "" ?>
                    <?php echo $type_id==PrivacyNodeTypePeer::PR_NTYP_COMPANY && $sector ? __('Sector:') . ' ' . link_to($sector, "$route&page=$page&ipp=$ipp&typ=$type&view=$view", array('class' => 'filter-remove-link', 'title' => __('Remove Sector Filter'))) : "" ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_{$view}", array('pager' => $pager, 'route' => $route, 'group' => $group, 'type_id' => $type_id, 'backlink' => "page=$page&ipp=$ipp&typ=$type&view=$view". ($keyword != '' ? "&mkeyword=$keyword" : "") . ($type_id==PrivacyNodeTypePeer::PR_NTYP_USER && $gender ? "&gn=$gender" : "") . ($type_id==PrivacyNodeTypePeer::PR_NTYP_COMPANY && $sector ? "&sct={$sector->getId()}" : ""))) ?>
                </div>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <div class="box_180 _WhiteBox">
        <h3><?php echo __('Invite to Group') ?></h3>
        <div>
            <?php echo __('Send invitation to people or companies to join your group.') ?>
            <div class="hrsplit-1"></div>
            <?php echo link_to(__('Invite to Group'), "@group-members?action=invite&hash={$group->getHash()}", 'class=green-button margin-t2') ?>
        </div>
        </div>
        <?php /*?>
        <div class="clear pad-1">
        <a href="http://www.emarketturkey.com" class="hoverborder">
            <h3 style="background: url(/images/layout/icon/blue_circle_email.png) no-repeat left top; padding-left: 33px; font: 14px tahoma; height: 26px; color: #444; margin-top: 0px;">
                <?php echo __('Make Announcement') ?></h3>
            <div style="padding-left: 33px; font: 11px tahoma; color: #777; margin-top: 8px;">
                <?php echo __('Send message to all your group members at once.') ?>
            </div>
        </a>
        </div>
        */ ?>
        </div>
    </div>

</div>
    