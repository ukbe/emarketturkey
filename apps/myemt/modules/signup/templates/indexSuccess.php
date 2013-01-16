<?php use_helper('Cryptographp', 'DateForm') ?>
<?php slot('subNav') ?>
<?php include_partial('signup/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">
    <div class="box_948 _titleBG_Transparent">
        <div class="_noBorder">
            <?php if ($sf_params->get('keepon')==url_for('@hr.mycv-action?action=basic', true)): ?>
            <div class="txtCenter"><?php echo image_tag('layout/background/create-cv-step-1.'.$sf_user->getCulture().'.png') ?></div>
            <h4><?php echo __('Step 1 - Create Your Personal Account') ?></h4>
            <div class="pad-2"><?php echo __('Please fill in the form below to have your login account created.<br /><br />Once your login account is created, you will be redirected to CV creating page.') ?></div>
            <?php elseif ($sf_params->get('keepon')==url_for('@register-comp', true)): ?>
            <div class="txtCenter"><?php echo image_tag('layout/background/register-company-step-1.'.$sf_user->getCulture().'.png') ?></div>
            <h4><?php echo __('Step 1 - Create Your Personal Account') ?></h4>
            <div class="pad-2"><?php echo __('Please fill in the form below to have your login account created.<br /><br />Once your login account is created, you will be redirected to Company registration page.') ?></div>
            <?php else: ?>
            <h4><?php echo __('Sign Up') ?></h4>
            <div class="pad-2"><?php echo __('Please fill in the form below to have your login account created.') ?></div>
            <?php endif ?>
        </div>
    </div>

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <div class="_noBorder">
                <?php echo form_tag(url_for('@signup' . ($sf_params->get('keepon') ? '?keepon='.$sf_params->get('keepon') : ''), true)) ?>
                <?php echo $sf_params->get('invite') ? input_hidden_tag('invite', $sf_params->get('invite')) : '' ?>
                <dl class="_table signup">
                    <dt><?php echo emt_label_for('name', __('Your Name')) ?></dt>
                    <dd><?php echo input_tag('name', $sf_params->get('name', isset($invite)?$invite->getName():''), 'size=30 style=width:150px;') ?></dd>
                    <dt><?php echo emt_label_for('lastname', __('Your Lastname')) ?></dt>
                    <dd><?php echo input_tag('lastname', $sf_params->get('lastname', isset($invite)?$invite->getLastname():''), 'size=30 style=width:150px;') ?></dd>
                    <dt><?php echo emt_label_for('email_first', __('Email address')) ?></dt>
                    <dd><?php echo input_tag('email_first', $sf_params->get('email_first', isset($invite)?$invite->getEmail():''), 'size=30 style=width:240px;') ?></dd>
                    <dt><?php echo emt_label_for('email_repeat', __('Email address (repeat)')) ?></dt>
                    <dd><?php echo input_tag('email_repeat', $sf_params->get('email_repeat', isset($invite)?$invite->getEmail():''), 'size=30 style=width:240px;') ?></dd>
                    <dt><?php echo emt_label_for('gender', __('Gender')) ?></dt>
                    <dd><?php echo select_tag('gender', options_for_select(array('female' => __('Female'), 'male' => __('Male')), $sf_params->get('gender'), array('include_custom' => __('Please Select')))) ?></dd>
                    <dt><?php echo emt_label_for(array('bd_day', 'bd_month', 'bd_year'), __('Birthdate')) ?></dt>
                    <dd><?php echo select_day_tag('bd_day', $sf_params->get('bd_day') ? $sf_params->get('bd_day') : '', array('include_custom' => __('day'))) . '&nbsp;' . select_month_tag('bd_month', $sf_params->get('bd_month') ? $sf_params->get('bd_month') : '', array('include_custom' => __('month'))) . '&nbsp;' . select_year_tag('bd_year', $sf_params->get('bd_year') ? $sf_params->get('bd_year') : '', array('year_start' => date('Y'), 'year_end' => date('Y')-90, 'include_custom' => __('year'))) ?></dd>
                </dl>
                <dl class="_table signup">
                    <dt></dt>
                    <dd><?php echo cryptographp_picture(); ?>&nbsp;
                    <?php echo cryptographp_reload(); ?><br /><em class="tip"><?php echo __('Type the code you see above into Security Code field.') ?></em></dd>
                    <dt><?php echo emt_label_for('captcha', __('Security Code')) ?></dt>
                    <dd><?php echo input_tag('captcha', '', array('style' => 'border:solid 1px #CCCCCC; width: 60px;')); ?></dd>
                    <dt>&nbsp;</dt>
                    <dd><?php echo __('By clicking Sign Up, you are indicating that you have read and agree to the %1s and %2s.', array('%1s' => link_to(__('Terms of Use'), '@camp.terms', 'target=emt_terms class=inherit-font bluelink t_hover'), '%2s' => link_to(__('Privacy Policy'), '@camp.privacy', 'target=emt_privacy class=inherit-font bluelink t_hover'))) ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Sign Up'), 'class=green-button') ?></dd>
                </dl>
                </form>
            </div>
        </div>
    </div>

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <div class="_noBorder">
                <?php if (isset($errorWhileSaving) && $errorWhileSaving == true): ?>
                <div id="error">
                    <h3><?php echo __('Error Occured!') ?></h3>
                    <div class="t_red pad-2">
                    <?php echo __('An error occurred while creating your account.<br />We are sorry for the inconvenience and still working to work out the problem.') ?>
                    </div>
                </div>
                <div class="hrsplit-2"></div>
                <?php elseif (form_errors()): ?>
                <div><?php echo form_errors() ?></div>
                <div class="hrsplit-2"></div>
                <?php endif ?>

                <table class="_secured">
                    <tr>
                        <td><?php echo __('You are secured with:')?></td>
                        <td class="margin-r2"><a href="//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_s" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_s.png" alt="TRUSTe online privacy certification"/></a></td>
                        <td><!-- BEGIN DigiCert Site Seal Code --><div id="digicertsitesealcode"><script language="javascript" type="text/javascript" src="https://www.digicert.com/custsupport/sealtable.php?order_id=00246390&amp;seal_type=a&amp;seal_size=small&amp;seal_color=blue&amp;new=1&amp;newsmall=1"></script><a href="http://www.digicert.com/">SSL Certificate</a><script language="javascript" type="text/javascript">coderz();</script></div><!-- END DigiCert Site Seal Code --></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222;
margin: 0px; padding: 5px 10px; border-bottom: none; }
dl._table.signup dt { width: 30%; }
dl._table.signup dd { width:  65%;}
dl._table.signup input { width:  80%;}
</style>
