<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('account/settings', array('sesuser' => $sesuser)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Privacy Preferences') ?></h4>

                <?php echo form_errors() ?>
                <?php echo form_tag('account/changePassword') ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for('old_pass', __('Old Password')) ?></dt>
                    <dd><?php echo input_password_tag('old_pass', $sf_params->get('old_pass'), 'size=20') ?></dd>
                    <dt><?php echo emt_label_for('new_pass', __('New Password')) ?></dt>
                    <dd><?php echo input_password_tag('new_pass', $sf_params->get('new_pass'), 'size=20') ?></dd>
                    <dt><?php echo emt_label_for('new_pass_repeat', __('New Password (repeat)')) ?></dt>
                    <dd><?php echo input_password_tag('new_pass_repeat', $sf_params->get('new_pass_repeat'), 'size=20') ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Set Password'), 'class=action-button') ?></dd>
                </dl>
                </form>
            </section>

        </div>

    </div>

    <div class="col_180">
    </div>
</div>
