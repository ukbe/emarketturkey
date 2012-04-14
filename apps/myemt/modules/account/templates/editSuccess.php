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
                <h4><?php echo __('Account Settings') ?></h4>

 <?php echo form_errors() ?>
<?php echo form_tag("account/edit", 'novalidate=novalidate') ?>
<?php echo input_hidden_tag('_ref', $sf_params->get('_ref', $_referer)) ?>

<dl class="_table">
    <dt><?php echo emt_label_for('user_account_email', __('Account E-mail')) ?></dt>
    <dd id="view-email" class="_noInput<?php echo $sf_params->get('user_account_email') && $sf_params->get('user_account_email') != $login->getEmail() ? ' ghost' : '' ?>"><b id="user_current_email" class="t_green"><?php echo $login->getEmail() ?></b>&nbsp;
        <?php echo link_to_function('('. __('change') . ')', "$('dd#view-email').slideUp('fast'); $('dd#change-email').slideDown('normal');", 'class=bluelink hover')?>
        <em class="ln-example"><?php echo __('This e-mail is used while logging into eMarketTurkey.') ?></em></dd>
    <dd id="change-email"<?php echo $sf_params->get('user_account_email') && $sf_params->get('user_account_email') != $login->getEmail() ? '' : ' class="ghost"' ?>><?php echo input_tag('user_account_email',$sf_params->get('user_account_email', $login->getEmail()), 'size=40 maxlength=50 style=width: 200px;') ?>&nbsp;
        <?php echo link_to_function('('. __('cancel') . ')', "$('dd#change-email').slideUp('fast'); $('dd#view-email').slideDown('normal'); $('#user_account_email').val($('#user_current_email').text());", 'class=bluelink hover')?>
        <em class="ln-example t_red"><?php echo __('If you change your account email, your profile (including companies, groups and assets) will be invisible to others until you verify your e-mail address.') ?></em></dd>
    <dt><?php echo emt_label_for('user_name', __('Your Name')) ?></dt>
    <dd><?php echo input_tag('user_name',$sf_params->get('user_name', $sesuser->getDisplayName()), 'size=30 maxlength=50 style=width: 150px;') ?></dd>
    <dt><?php echo emt_label_for('user_lastname', __('Your Lastname')) ?></dt>
    <dd><?php echo input_tag('user_lastname',$sf_params->get('user_lastname', $sesuser->getDisplayLastname()), 'size=30 maxlength=50 style=width: 150px;') ?></dd>
    <dt><?php echo emt_label_for('user_alternative_email', __('Alternative E-mail')) ?></dt>
    <dd><?php echo input_tag('user_alternative_email', $sf_params->get('user_alternative_email', $sesuser->getAlternativeEmail()), 'size=40 maxlength=50 style=width: 200px;') ?></dd>
    <dt><?php echo emt_label_for('user_username', __('Username')) ?></dt>
    <dd><?php echo input_tag('user_username', $sf_params->get('user_username', $login->getUsername()), 'size=40 maxlength=50 style=width: 200px;'.($login->hasUsername()==true?" disabled=disabled":"")) ?>
        <em class="ln-example"><?php echo __('Once you set your username, you cannot change it.') ?></em></dd>
    <dt></dt>
    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?>&nbsp;<?php echo link_to(__('Cancel'), $origin, 'class=inherit-font bluelink hover')?></dd>
</dl>
</form>
            </section>
        </div>
        
    </div>

    <div class="col_180">

    </div>
    
</div>