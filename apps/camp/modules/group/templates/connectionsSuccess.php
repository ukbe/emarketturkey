<div class="col_948 cmGroup">

    <div class="col_180" style="z-index: 1;">
        <div class="photoBox">
        <?php echo link_to(image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_MEDIUM)), $group->getProfileUrl()) ?>
        </div>
<?php include_partial('leftmenu', array('group' => $group))?>
        
    </div>

<?php include_partial('profile_top', array('group' => $group, 'nums' => $nums, 'sesuser' => $sesuser, 'userprops' => $userprops, '_here' => $_here))?>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576">
                <h4><?php echo __("Group's Connections") ?></h4>
                <div class="_noBorder">
                    <span class="btn_container _right" style="position: relative; right: auto; top: auto;">
                        <?php echo link_to(__('Linked Groups'), $group->getProfileActionUrl('connections'), array('query_string' => 'relation=linked', 'class' => $role_name=='linked' ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('Companies'), $group->getProfileActionUrl('connections'), array('query_string' => 'relation=companies', 'class' => $role_name=='companies' ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('People'), $group->getProfileActionUrl('connections'), array('query_string' => 'relation=people', 'class' => $role_name=='people' ? 'ui-state-selected' : ''))?>
                    </span>
                    <div class="hrsplit-1"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="clear">
                        <?php include_partial("layout_extended_$partial_name", array('pager' => $pager)) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                
                </div>
            </div>
        </div>

        <div class="col_180">
            <?php if ($own_group): ?>
            <?php include_partial('owner_actions', array('group' => $group)) ?>
            <?php endif ?>
            
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $group)) ?>
                </div>
            </div>

        </div>

    </div>


</div>