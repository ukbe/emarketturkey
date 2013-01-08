<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php include_partial('global/subNav_hr') ?>
<?php end_slot() ?>

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
            <h4><?php echo __('My Jobs') ?></h3>
            <div class="_noBorder">
                    <span class="btn_container _right" style="position: relative; right: auto; top: auto;">
                        <?php echo link_to(__('Applied Jobs'), '@myjobs-applied', array('class' => $group=='applied' ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('Bookmarked Jobs'), '@myjobs-bookmarked', array('class' => $group=='bookmarked' ? 'ui-state-selected' : ''))?>
                        <?php echo link_to(__('Viewed Jobs'), '@myjobs-viewed', array('class' => $group=='viewed' ? 'ui-state-selected' : ''))?>
                    </span>
                    <div class="hrsplit-1"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="clear">
                        <?php include_partial("layout_extended_job_$group", array('pager' => $pager, '_here' => $_here)) ?>
                    </div>
                    <div class="hrsplit-2"></div>
                    <div class="_right">
                    <?php echo pager_links($pager, array('pname' => 'page')) ?>
                    </div>
                
            </div>
        </div>

    </div>

    <div class="col_180">
        
    </div>
</div>