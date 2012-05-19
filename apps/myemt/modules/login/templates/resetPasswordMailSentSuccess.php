<?php slot('subNav') ?>
<?php include_partial('login/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">

    <div class="col_180">&nbsp;
    </div>

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <h4><?php echo __('Reset Password Mail Sent') ?></h4>
            <div class="_noBorder">
                <p class="pad-3">
                <?php if (!$error_msg): ?>
                <?php echo __('An email including information on how to reset your password has been sent to your email address.') ?>
                <div class="hrsplit-2"></div>
                <strong class="pad-3 t_red"><?php echo __('Please check your e-mail inbox.') ?></strong>
                <?php else: ?>
                <?php echo $error_msg ?>
                <?php endif ?>
                </p>
            </div>
        </div>
    </div>
</div>
<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222; margin: 0px; padding: 5px 10px; border-bottom: none; }
</style>