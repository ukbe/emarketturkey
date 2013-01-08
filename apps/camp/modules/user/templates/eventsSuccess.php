<?php slot('subNav') ?>
<?php include_partial('global/subNav_cm') ?>
<?php end_slot() ?>

<div class="col_948 cmUser">

    <div class="col_180" style="z-index: 1;">
        <div class="photoBox">
        <?php echo link_to(image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_MEDIUM)), $user->getProfileUrl()) ?>
        </div>
<?php include_partial('leftmenu', array('user' => $user))?>

    </div>

<?php include_partial('profile_top', array('user' => $user, 'nums' => $nums, 'sesuser' => $sesuser, '_here' => $_here))?>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576 _title_BoldColor">
                <h3><strong><?php echo __("Events") ?></strong></h3>
                <div>
                    <?php if (count($events)): ?>
                    <?php foreach ($events as $event): ?>
                    <?php include_partial('event/event', array('event' => $event)) ?>
                    <?php endforeach?>
                    <?php else: ?>
                    <div class="t_grey"><?php echo __("There is no event participation for the user.") ?></div>
                    <?php endif ?>

                </div>
            </div>
        </div>

        <div class="col_180">
            <?php if (!$thisIsMe): ?>
            <?php include_partial('connect_box', array('user' => $user, 'nums' => $nums)) ?>
            <?php endif ?>
            
            <?php if (!$thisIsMe): ?>
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $company)) ?>
                </div>
            </div>
            <?php endif ?>

        </div>

    </div>
</div>