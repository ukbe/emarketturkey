<div class="col_948 cmGroup">

    <div class="col_180" style="z-index: 1;">
        <div class="photoBox">
        <?php echo link_to(image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_MEDIUM)), $group->getProfileUrl()) ?>
        </div>
<?php include_partial('leftmenu', array('group' => $group))?>
        
    </div>

<?php include_partial('profile_top', array('group' => $group, 'nums' => $nums, 'sesuser' => $sesuser, 'userprops' => $userprops, '_here' => $_here))?>

    <div class="col_762" style="z-index: 0;">
        <div class="col_576">
            <div class="box_576 _title_BoldColor">
                <h3><?php echo __('<strong>Posts</strong>') ?></h3>
                <div>
                <?php if (count($posts)): ?>
                <dl>
                <?php foreach ($posts as $post): ?>
                    <dt><?php echo image_tag($post->getPoster()->getProfilePictureUri()) ?></dt>
                    <dd><?php echo $post->getHtml() ?></dd>
                <?php endforeach ?>
                </dl>
                <?php else: ?>
                <div class="t_grey"><?php echo __("It's sad. No posts at this time.") ?></div>
                <?php endif ?>
                </div>
            </div>

        </div>

        <div class="col_180">
            <?php if ($own_group): ?>
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $group)) ?>
                </div>
            </div>
            <?php endif ?>

            <?php if (count($photos)): ?>
            <div class="box_180 _noBordered profile-photos">
                <h3><?php echo link_to(__('Photos'), $group->getProfileActionUrl('photos')) ?></h3>
                <div class="profile-photos-180">
                <?php foreach ($photos as $photo): ?>
                <?php echo link_to(image_tag($photo->getMediumUri()), $photo->getUrl()) ?>
                <?php endforeach ?>
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