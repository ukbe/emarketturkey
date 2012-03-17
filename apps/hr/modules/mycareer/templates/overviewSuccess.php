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
            <h4><?php echo __('My Career') ?></h3>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Recent Applications') ?></h5>
            <div class="_noBorder pad-0">
                <?php if (count($appliedujobs)): ?>
                <ul class="overview-list pad-0 margin-b2">
                <?php foreach ($appliedujobs as $ujob): ?>
                    <li>
                    <div class="_right"><?php echo link_to(__(UserJobPeer::$statusLabels[$ujob->getStatusId()]), "@myjobs-applied-view?guid={$ujob->getJob()->getGuid()}") ?></div>
                    <?php echo $ujob->getJob() . link_to('&nbsp;', $ujob->getJob()->getUrl(), 'class=popup-link-10px target=blank') ?>
                <?php endforeach?>
                </ul>
                <?php echo link_to(__('See all applications'), "@myjobs-applied", 'class=bluelink inherit-font hover') ?>
                <?php else: ?>
                <span class="t_grey"><?php echo __('No Items') ?></span>
                <?php endif ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Recently Viewed Jobs') ?></h5>
            <div class="_noBorder pad-0">
                <?php if (count($recentjobs)): ?>
                <ul class="overview-list pad-0 margin-b2">
                <?php foreach ($recentjobs as $job): ?>
                    <li><?php echo $job . link_to('&nbsp;', $job->getUrl(), 'class=popup-link-10px target=blank') ?>
                <?php endforeach?>
                </ul>
                <?php echo link_to(__('See all recently viewed jobs'), "@myjobs-viewed", 'class=bluelink inherit-font hover') ?>
                <?php else: ?>
                <span class="t_grey"><?php echo __('No Items') ?></span>
                <?php endif ?>
            </div>
        </div>
        <div class="box_576">
            <h4><?php echo __('My CV') ?></h3>
            <div class="_noBorder">
                <span class="t_smaller"><?php echo __('Last Update: <span class="t_grey">%1date</span>', array('%1date' => format_datetime($resume->getUpdatedAt('U')))) ?></span>
                <div class="hrsplit-1"></div>
                <ul class="sepdot">
                    <li><?php echo link_to(__('Edit CV'), '@mycv-action?action=edit', 'class=inherit-font bluelink hover act edit-13px') ?></li>
                    <li><?php echo link_to(__('Review CV'), '@mycv-action?action=review', 'class=inherit-font bluelink hover act profile-11px') ?></li>
                    <li><?php echo link_to_function(__('Export CV'), '', 'class=inherit-font hover act tag pdf-11px t_grey') ?></li>
                </ul>
                <div class="hrsplit-2"></div>
                <?php if (count($missingitems)): ?>
                <div class="t_bold"><?php echo __('Missing Information:') ?></div>
                <ul class="arrow-list">
                <?php foreach ($missingitems as $missing): ?>
                    <li><?php echo link_to(__($missing[0]), $missing[1], 'class=inherit-font bluelink hover') ?></li>
                <?php endforeach ?>
                </ul>
                <?php endif ?>
            </div>
            <div class="_noBorder pad-0">
                
            </div>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('CV Status') ?></h3>
            <div class="">
                <?php if ($resume->getActive()): ?>
                <?php echo __('Your CV is accessible.') ?>
                <div class="hrsplit-2"></div>
                <?php echo link_to(__('Deactivate'), '@mycv-action?action=status&act=deactivate', 'class=command pause') ?>
                <?php else: ?>
                <?php echo __('Your CV is inaccessible.') ?>
                <div class="hrsplit-2"></div>
                <?php echo link_to(__('Activate'), '@mycv-action?action=status&act=activate', 'class=command play') ?>
                <?php endif ?>
            </div>
        </div>
        
    </div>
</div>