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
            <div class="box_576">
                <h4><?php if ($photo->getMediaItemFolder()): ?>
                <?php echo __("Photo Album:") ?>&nbsp;<span class="t_green"><?php echo $photo->getMediaItemFolder()->getName() ?></span>
                <?php else:?>
                <?php echo __('User Photos')?>
                <?php endif ?></h4>
                <div class="_noBorder">
                <?php $links = array_filter(array(count($photos) ? link_to(__('Back to Photos'), $user->getProfileActionUrl('photos'), 'class=inherit-font bluelink hover') : null,
                                     count($albums) ? link_to(__('Back to Album'), $user->getProfileActionUrl('photos'), array('query_string' => 'album=' . ($photo->getMediaItemFolder() ? $photo->getMediaItemFolder()->getId() : 'uc'), 'class' => 'inherit-font bluelink hover')) : null)) ?>
                <?php echo count($links) ? '<ul class="_horizontal sepdot"><li>' . implode('</li><li>', $links) . '</li></ul>' : '' ?>
                <div class="hrsplit-2"></div>
                <div>
                <?php if ($photo->getNext(false)): ?>
                <div class="_right">
                    <?php echo link_to(__('Next'), $photo->getNext()->getUrl(), array('class' => 'basic', 'title' => __('Next Photo'))) ?>
                </div>
                <?php endif ?>
                <?php if ($photo->getPrevious(false)): ?>
                <div>
                    <?php echo link_to(__('Previous'), $photo->getPrevious()->getUrl(), array('class' => 'basic', 'title' => __('Previous Photo'))) ?>
                </div>
                <?php else: ?>
                <div class="clear"></div>
                <?php endif ?>
                </div>
                <div class="photoPreview">
                    <?php echo image_tag($photo->getUri()) ?>
                    <span><?php echo $photo->getTitle() ?></span>
                </div>
                <?php include_partial('global/comment_box', array('item' => $photo)) ?>
                </div>
            </div>
        </div>

        <div class="col_180">
            <?php if ($thisIsMe): ?>
            <div class="box_180 _titleBG_Black">
                <h3><?php echo __('Actions') ?></h3>
                <div>
                    <ul class="side-links">
                        <li><?php echo link_to(__('Delete Photo'), $user->getProfileActionUrl('photos'), array('query_string' => "pid={$photo->getId()}&act=rm", 'class' => 'inherit-font')) ?></li>
                        <li><?php echo link_to(__('Set as Profile Image'), $user->getProfileActionUrl('photos'), array('query_string' => "pid={$photo->getId()}&act=spl", 'class' => 'inherit-font')) ?></li>
                    </ul>
                </div>
            </div>
            <?php endif ?>
            
        </div>

    </div>
</div>