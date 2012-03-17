<div class="col_948 cmUser">

    <div class="col_180" style="z-index: 1;">
        <div class="photoBox">
        <?php echo link_to(image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_MEDIUM)), $user->getProfileUrl()) ?>
        </div>
<?php include_partial('leftmenu', array('user' => $user))?>

    </div>

<?php include_partial('profile_top', array('user' => $user, 'nums' => $nums, 'sesuser' => $sesuser, '_here' => $_here))?>

    <div class="col_762" style="z-index: 0;">
        <div class="col_576">
            <div class="box_576 _title_BoldColor">
                <h3><div class="_right">
                        <span class="btn_container" style="position: relative; right: auto; top: auto;">
                            <?php echo link_to(__('Friends'), $user->getProfileActionUrl('connections'), array('query_string' => 'relation=friend', 'class' => $role_name=='friend' ? 'ui-state-selected' : ''))?>
                            <?php echo link_to(__('Groups'), $user->getProfileActionUrl('connections'), array('query_string' => 'relation=group', 'class' => $role_name=='group' ? 'ui-state-selected' : ''))?>
                            <?php echo link_to(__('Following'), $user->getProfileActionUrl('connections'), array('query_string' => 'relation=following', 'class' => $role_name=='following' ? 'ui-state-selected' : ''))?>
                        </span>
                    </div>
                    <?php echo __('<strong>Connections</strong>') ?></h3>
                <div>
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
            <?php if ($sesuser->getId() != $user->getId()): ?>
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $user)) ?>
                </div>
            </div>
            <?php endif ?>

        </div>

    </div>

</div>
<?php use_javascript('jquery.ticker.js') ?>
<?php use_stylesheet('ticker-style.css') ?>
<?php echo javascript_tag("
    $(function () {
        $('#js-news').ticker({displayType: 'fade', pauseOnItems: 5000, titleText: '".__('UPDATES:')."', controls: false});
    });
") ?>