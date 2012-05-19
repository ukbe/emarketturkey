<?php slot('subNav') ?>
<?php include_partial('login/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">

    <div class="col_180">&nbsp;
    </div>

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <h4><?php echo __('Set Your New Password') ?></h4>
            <div class="_noBorder">
                <p class="pad-3">
                    <p><?php echo __('Hi %1', array('%1' => $user)) ?></p>
                    <p><?php echo __('Please set a new password for your account. Make sure that it is not easily guessable by other people.') ?></p>
                </p>
                <?php if ($sf_request->hasErrors()): ?>
                <?php echo form_errors() ?>
                <div class="hrsplit-2"></div>
                <?php endif ?>
                <?php echo form_tag('login/resetPassword?log='.$sf_params->get('log').'&req='.$sf_params->get('req')) ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for('new_passwd', __('New Password')) ?></dt>
                    <dd><?php echo input_password_tag('new_passwd', '', 'size=30 style=width:240px;') ?>
                        <em class="ln-example"><?php echo __('Your password should include 6-14 chars. and <b>at least one</b> numerical character.') ?></em></dd>
                    <dt><?php echo emt_label_for('new_passwd_rpt', __('New Password (repeat)')) ?></dt>
                    <dd><?php echo input_password_tag('new_passwd_rpt', '', 'size=30 style=width:240px;') ?>
                        <em class="ln-example"><?php echo __('Re-type your new password.') ?></em></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Set New Password')) ?></dd>
                </dl>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222;
margin: 0px; padding: 5px 10px; border-bottom: none; }
dl._table.forget dt { width: 25%; }
dl._table.forget dd { width:  65%;}
</style>