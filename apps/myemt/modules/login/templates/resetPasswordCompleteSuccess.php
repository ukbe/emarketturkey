<?php slot('subNav') ?>
<?php include_partial('login/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">

    <div class="col_180">&nbsp;
    </div>

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <h4><?php echo __('Your New Password Set') ?></h4>
            <div class="_noBorder">
                <p class="pad-3">
                <?php if (!$error_msg): ?>
                    <p><?php echo __('Your new password has been set. You should use your new password while logging in.') ?></p>
                    <div class="hrsplit-3"></div>
                    <p><?php echo link_to('Log In Now', '@login') ?></p>
                <?php else: ?>
                <?php echo $error_msg ?>
                <?php endif ?>
                </p>
            </div>
        </div>
    </div>
</div>