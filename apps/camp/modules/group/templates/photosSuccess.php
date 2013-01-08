<?php slot('subNav') ?>
<?php include_partial('global/subNav_cm') ?>
<?php end_slot() ?>

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
            <?php if ($album || $unclassified): ?>
                <h4><?php echo __("Photo Album:") ?>&nbsp;<span class="t_green"><?php echo $album ? $album->getName() : __('Unclassified') ?></span></h4>
                <div class="_noBorder">
                    <?php echo link_to(__('Back to Albums'), $group->getProfileActionUrl('photos'), array('class' => 'inherit-font bluelink hover')) ?>
                    <div class="hrsplit-2"></div>
            <?php else:?>
                <h4><?php echo count($albums) ? __("Photo Albums") : __('Group Photos') ?></h4>
                <div class="_noBorder">
            <?php endif ?>
                <?php if (!$album && !$unclassified && count($albums) == 0 && $pager->getNbResults() == 0): ?>
                    <div class="pad-3">
                        <?php echo __('No Photos') ?>
                    </div>
                    <?php if ($own_group): ?>
                    <h5><?php echo __('Upload New Photo') ?></h5>
                    <div class="pad-3">
                        <?php echo form_errors() ?>
                        <?php echo form_tag($group->getProfileActionUrl('upload'), 'multipart=true') ?>
                        <?php echo input_hidden_tag('act', 'upl')?>
                        <?php echo input_file_tag('photo') ?>
                        <div class="hrsplit-2"></div>
                        <?php echo submit_tag(__('Upload Photo'), 'class=green-button') ?>
                        </form>
                    </div>
                    <?php endif ?>
                <?php endif ?>
                <?php if (!$album && !$unclassified): ?>
                    <?php if (count($albums)): ?>
                    <div class="photoGallery _noBorder">
                        <dl>
                            <dt><?php echo __('Photo Albums') ?></dt>
                            <?php foreach ($albums as $album): ?>
                            <?php $first = $album->getItems(1) ?>
                            <?php $first = $first ? $first->getMediumUri() : 'layout/background/nologo.png' ?>
                            <dd>
                                <?php echo link_to(image_tag($first) . "<em>{$album->getName()}</em>", $album->getUrl()) ?>
                                <span class="num"><?php echo __('%1 photos', array('%1' => $album->countMediaItems())) ?></span>
                            </dd>
                            <?php endforeach ?>
                            <?php if ($unclassified_num > 0): ?>
                            <?php $first = MediaItemPeer::retrieveItemsFor($group->getId(), $group->getObjectTypeId(), MediaItemPeer::MI_TYP_ALBUM_PHOTO, null, false, false, 1, 1, false, MediaItemPeer::MI_NO_FOLDER) ?>
                            <?php $first = (count($first) ? $first[0]->getMediumUri() : 'layout/background/nologo.png') ?>
                            <dd>
                                <?php echo link_to(image_tag($first) . "<em>".__('Unclassified')."</em>", $group->getProfileActionUrl('photos'), array('query_string' => 'album=uc')) ?>
                                <span class="num"><?php echo __('%1 photos', array('%1' => $unclassified_num)) ?></span>
                            </dd>
                            <?php endif ?>
                        </dl>
                    </div>
                    <?php endif ?>
                <?php else: ?>
                    <?php if ($pager->getNbResults() > 0): ?>
                    <div class="photoGallery _noBorder">
                        <ul>
                            <li class="pageNumButtons">
                            <?php echo pager_links($pager, array('pname' => 'page')) ?>
                            </li>
                            <li><?php echo form_tag(myTools::remove_querystring_var($sf_request->getUri(), array('ipp', 'album')), 'method=get') ?>
                            <?php echo input_hidden_tag('album', $unclassified ? 'uc' : ($album ? $album->getId() : '')) ?>
                            <?php echo __('%1 items per page', array('%1' => select_tag('ipp', options_for_select(array_combine($ipps['thumbs'], $ipps['thumbs']), $ipp), array('onchange' => "$(this).closest('form').submit();")))) ?>
                            <noscript><?php echo submit_tag(__('refresh')) ?></noscript>
                            </form></li>
                        </ul>
                        <dl>
                            <dt><?php echo __('Photos') ?></dt>
                            <?php foreach ($pager->getResults() as $photo): ?>
                            <dd>
                                <?php echo link_to(image_tag($photo->getMediumUri()) . "<em>{$photo->getTitle()}</em>", $photo->getUrl()) ?>
                            </dd>
                            <?php endforeach ?>
                        </dl>
                        <ul>
                            <li class="pageNumButtons">
                            <?php echo pager_links($pager, array('pname' => 'page'))?>
                            </li>
                            <li><?php echo form_tag(myTools::remove_querystring_var($sf_request->getUri(), array('ipp', 'album')), 'method=get') ?>
                            <?php echo input_hidden_tag('album', $unclassified ? 'uc' : ($album ? $album->getId() : '')) ?>
                            <?php echo __('%1 items per page', array('%1' => select_tag('ipp', options_for_select(array_combine($ipps['thumbs'], $ipps['thumbs']), $ipp), array('onchange' => "$(this).closest('form').submit();")))) ?>
                            <noscript><?php echo submit_tag(__('refresh')) ?></noscript>
                            </form></li>
                        </ul>
                    </div>
                    <?php endif ?>
                <?php endif?>
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