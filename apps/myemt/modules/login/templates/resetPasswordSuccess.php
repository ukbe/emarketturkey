<?php use_helper('Cryptographp') ?>
<?php slot('subNav') ?>
<?php include_partial('login/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login" style="background-image: url(/images/layout/background/remember-back.jpg); background-repeat: no-repeat; background-position: right bottom;">

<?php if (!$sf_request->hasErrors()): ?>
    <div class="col_180">
    </div>
<?php endif ?>

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <h4><?php echo __('Reset Your Password') ?></h4>
            <div class="_noBorder">
                <div class="pad-3"><?php echo __('Please enter your email address in the form below in order to start resetting your password. We will send you an email containing a link to reset your password.') ?></div>
                <?php echo form_tag('login/resetPassword') ?>
                <dl class="_table forget">
                    <dt><?php echo emt_label_for('reset_email', __('Email')) ?></dt>
                    <dd><?php echo input_tag('reset_email', '', 'size=30 style=width:240px;') ?>
                        <em class="ln-example"><?php echo __('You should enter your registered email address here.') ?></em></dd>
                    <dt></dt>
                    <dd><?php echo cryptographp_picture(); ?>&nbsp;
                        <?php echo cryptographp_reload(); ?><br />
                        <em class="tip"><?php echo __('Type the code you see above into Security Code field.') ?></em></dd>
                    <dt><?php echo emt_label_for('captcha', __('Security Code')) ?></dt>
                    <dd><?php echo input_tag('captcha', '', array('style' => 'border:solid 1px #CCCCCC; width: 60px;')); ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Send E-mail'), 'class=green-button') ?></dd>
                </dl>
                </form>
            </div>
        </div>
    </div>

<?php if ($sf_request->hasErrors()): ?>
    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <div class="_noBorder">
                <?php echo form_errors() ?>
            </div>
        </div>
    </div>
<?php endif ?>
            
</div>

<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222;
margin: 0px; padding: 5px 10px; border-bottom: none; }
dl._table.forget dt { width: 25%; }
dl._table.forget dd { width:  65%;}
</style>