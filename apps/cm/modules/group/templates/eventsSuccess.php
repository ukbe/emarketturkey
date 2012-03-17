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
                <h4><?php echo __("Events") ?></h4>
                <div class="_noBorder">
                    <?php if (count($events)): ?>
                    <?php foreach ($events as $event): ?>
                    <?php include_partial('event/event', array('event' => $event)) ?>
                    <?php endforeach?>
                    <?php else: ?>
                    <?php echo __('There is no event participation for the group.') ?>
                    <?php endif ?>

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