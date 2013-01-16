<?php use_helper('Cryptographp', 'DateForm') ?>
<?php slot('subNav') ?>
<?php include_partial('login/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <div class="_noBorder">
                <div style="padding: 0px;">
                <h4><?php echo __('Login') ?></h4>
                <div style="padding: 10px;">
                <?php echo form_tag('@login') ?>
                <?php echo input_hidden_tag('_ref', $_ref) ?>
                <p style="padding: 10px 20px;"><?php echo __('If you already have an eMarketTurkey.com account, you can login to your account using your email address and password.') ?></p>
                <?php echo form_errors() ?>
                <div class="hrsplit-2"></div>
                <dl id="signup" class="_table large-form">
                    <dt><?php echo emt_label_for('email', __('E-mail')) ?></dt>
                    <dd><?php echo input_tag('email', '', 'id=email_p maxlength=50 style=width:150px;') ?></dd>
                    <dt><?php echo emt_label_for('password', __('Password')) ?></dt>
                    <dd><?php echo input_password_tag('password', '', 'id=password_p style=width:150px;') ?></dd>
                    <dt></dt>
                    <dd><?php echo checkbox_tag('remember', 1, $sf_user->getAttribute("remember"), 'id=remember_p name=remember') ?>
                                                        <?php echo emt_label_for('remember_p', __('Remember Me')) ?></dd>
                    <dt></dt>
                    <dd><?php echo submit_tag(__('Login'), 'class=green-button') ?></dd>
                    <dt></dt>
                    <dd><div class="hrsplit-1"></div>
                       <?php echo __('%1 or %2', array('%1' => link_to(__('Login Problems?'), "@homepage", 'class=inherit-font bluelink hover'),
                                                       '%2' => link_to(__('Forgot Password?'), "@forgot-password", 'class=inherit-font bluelink hover'))) ?></dd>
                </dl>
                </form>
                </div>
                </div>
                <div class="hrsplit-1"></div>
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

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <div class="_noBorder">
                <div style="">
                    <h4><?php echo __('Sign Up') ?></h4>
                    <div style="padding: 20px 10px;">
                    <p><?php echo __("Don't have an eMarketTurkey.com account, yet?<br /><b>You can sign up in seconds!</b>") ?></p>
                    <p><?php echo link_to(image_tag('layout/button/joinnow.'.$sf_user->getCulture().'.gif'), '@signup') ?></p>
                    <p><?php echo __('%1 how you can benefit for your career or your corporation.', array('%1' => link_to(__("Find out"), "@camp.services", 'class=inherit-font bluelink hover'))) ?></p>
                    <div class="hrsplit-1"></div>
                    <div> 
                    <ul class="t_smaller" style="padding-left: 60px; background: url(/images/layout/icon/faq-40px.png) left 10px no-repeat;">
                        <li><h3 class="pad-l0 margin-b1 t_underline"><?php echo __('Frequently Asked Questions') ?>:</h3></li>
                        <li><?php echo link_to (__('Who can register to eMarketTurkey?'), "@camp.faq#qTMMS", 'class=inherit-font hover target=_blank') ?></li>
                        <li><?php echo link_to (__('Is membership a paid service?'), "@camp.faq#qxMMS", 'class=inherit-font hover target=_blank') ?></li>
                        <li><?php echo link_to (__('more answers'), "@camp.faq", 'class=inherit-font bluelink hover target=_blank') ?></li>
                    </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222;
margin: 0px; padding: 5px 10px; border-bottom: none; }
dl._table.signup dt { width: 25%; }
dl._table.signup dd { width:  65%;}
dl._table.signup input { width:  80%;}

</style>