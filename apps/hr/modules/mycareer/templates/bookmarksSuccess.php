<?php use_helper('Date') ?>
<div class="col_948">

    <div class="col_180">
    <?php if ($photo = $resume->getPhoto()): ?>
        <div class="box_180 txtCenter">
            <a class="editable-image" href="<?php echo url_for('@mycv-action?action=materials') ?>">
                <?php echo image_tag($photo->getMediumUri()) ?>
                <span class="edittag"><?php echo __('Change Photo') ?></span>
            </a>
        </div>
    <?php endif ?>
        <div class="col_180">
<?php include_partial('leftmenu', array('sesuser' => $sesuser))?>
        </div>

    </div>

    <div class="col_576">

        <div class="box_576">
            <h4><?php echo __('Bookmarks') ?></h3>
        </div>

        <div class="box_576">
            <strong><?php echo __('Applied Jobs') ?></strong>
            <div class="_noBorder pad-0 overview-list">
                <?php if (count($app_ujobs)): ?>
                <table class="margin-b2 margin-t2">
                <tr>
                    <th><?php echo __('Job Title') ?></td>
                    <th><?php echo __('Employer Name') ?></td>
                    <th><?php echo __('Status') ?></td>
                </tr>
                <?php foreach ($app_ujobs as $ujob): ?>
                <tr>
                    <td><?php echo $ujob->getJob() . link_to('&nbsp;', $ujob->getJob()->getUrl(), 'class=popup-link-10px target=blank') ?></td>
                    <td><?php echo link_to($ujob->getJob()->getOwner()->getHRProfile()->getName(), $ujob->getJob()->getOwner()->getProfileActionUrl('jobs')) ?></td>
                    <td><?php echo link_to(UserJobPeer::$statusLabels[$ujob->getStatusId()], "@myjobs-applied-view?guid={$ujob->getJob()->getGuid()}", 'class=bluelink hover') ?></td>
                </tr>
                <?php endforeach?>
                </table>
                <div class="pad-l2"><?php echo link_to(__('See All'), "@myjobs-applied", 'class=inherit-font bluelink hover') ?></div>
                <?php else: ?>
                <span class="t_grey"><?php echo __('No Items') ?></span>
                <?php endif ?>
            </div>
        </div>

        <div class="box_576 margin-t2">
            <strong><span class="bookmarked sub"></span><?php echo __('Bookmarked Jobs') ?></strong>
            <div class="_noBorder pad-0 overview-list">
                <?php if (count($fav_ujobs)): ?>
                <table class="margin-t2 margin-b2">
                    <tr><th><?php echo __('Job Title') ?></th>
                        <th><?php echo __('Employer') ?></th>
                        <th><?php echo __('Deadline') ?></th>
                        <th></th></tr>
                <?php foreach ($fav_ujobs as $ujob): ?>
                <?php $job = $ujob->getJob() ?>
                    <tr>
                        <td><?php echo $ujob->getJob() . link_to('&nbsp;', $ujob->getJob()->getUrl(), 'class=popup-link-10px target=blank') ?>
                            <?php echo count($tx = $job->getTopSpecsText(true, null)) ? '<span class="clear t_grey margin-t1">'.implode(', ', $tx)."</span>" : "" ?></td>
                        <td><?php echo link_to($job->getOwner()->getHRProfile()->getName(), $job->getOwner()->getProfileActionUrl('jobs')) ?></td>
                        <td><?php echo format_date($job->getDeadline('U'), 'p') ?></td>
                        <td><?php echo link_to(__('Remove'), $job->getUrl()."&act=rem&_ref=$_here", 'class=led delete-11px') ?></td>
                    </tr>
                <?php endforeach ?>
                </table>
                <div class="margin-t2 pad-l2"><?php echo link_to(__('See All'), "@myjobs-bookmarked", 'class=inherit-font bluelink hover') ?></div>
                <?php else: ?>
                <span class="t_grey"><?php echo __('No Items') ?></span>
                <?php endif ?>
            </div>
        </div>
        <div class="box_576">
            <h4><span class="bookmarked sub"></span><?php echo __('Bookmarked Companies') ?></h3>
            <div class="_noBorder pad-2">
                <?php if (count($fav_books)): ?>
                <ul class="horizontal">
                <?php foreach ($fav_books as $fav_book): ?>
                    <li class="margin-r2"><?php echo link_to(image_tag($fav_book->getObject()->getHRProfile()->getHRLogo()->getThumbnailUri(), array('title' => $fav_book->getObject()->getHRProfile()->getName())), $fav_book->getObject()->getProfileUrl()) ?></li>
                <?php endforeach ?>
                </ul>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="col_180">
        
    </div>
</div>