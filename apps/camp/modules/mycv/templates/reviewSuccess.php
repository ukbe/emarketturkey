<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php include_partial('global/subNav_hr') ?>
<?php end_slot() ?>

<?php slot('footer') ?>
<?php include_partial('global/footer_hr') ?>
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
<?php include_partial('mycareer/leftmenu', array('sesuser' => $sesuser))?>
        </div>

    </div>

    <div class="col_576">

        <div class="box_576">
            <h4><?php echo __('My CV') ?></h4>
            <div class="_noBorder">
                <?php include_partial('preview-cv', array('resume' => $resume)) ?>
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