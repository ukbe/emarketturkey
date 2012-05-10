<?php use_helper('DateForm', 'Cryptographp') ?>
<?php slot('subNav') ?>
<?php include_partial('global/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="col_630">
        <div class="box_630 pad-t2">
            <ul class="home-tabs">
                <li id="tab1" class="active">
                    <h2><?php echo __('Join Global Network') ?></h2>
                    <div><?php echo __('Connect with professionals around the world. Build business relationships.') ?>
                    </div>
                </li>
                <li id="tab2">
                    <h2><?php echo __('Reach Buyers/Suppliers') ?></h2>
                    <div><?php echo __('Find trusted buyers and suppliers. Reach beyond the borders.') ?>
                    </div>
                </li>
                <li id="tab3">
                    <h2><?php echo __('Promote Your Organisation') ?></h2>
                    <div><?php echo __('Take advantage of group features for your organisation.') ?>
                    </div>
                </li>
            </ul>
            <ul class="home-pans">
                <li id="pan1" class="active"  style="background: url(/images/layout/background/globeline-thin.png) no-repeat center; background-opacity: .1;">
                    <h1><?php echo __('Meet professionals worldwide') ?></h1>
                    <div style="background: url(/images/layout/background/social-world.png) no-repeat center;"></div>
                </li>
                <li id="pan2" style="background: url(/images/layout/background/globeline-thin.png) no-repeat center; background-opacity: .1;">
                    <h1><?php echo __('Improve your sales and buyings') ?></h1>
                    <div style="background: url(/images/layout/background/buyerssuppliers.png) no-repeat center;"></div>
                </li>
                <li id="pan3" style="background: url(/images/layout/background/globeline-thin.png) no-repeat center; background-opacity: .1;">
                    <h1><?php echo __('Advanced group features') ?></h1>
                    <div style="background: url(/images/layout/background/groupcube.png) no-repeat center;"></div>
                </li>
            </ul>
            
        </div>
    </div>

    <div class="col_312">
        <div class="box_312 pad-t2 _titleBG_White">
        <h3><?php echo __('Signup') ?></h3>
        <div>
<?php if ($sesuser->isNew()): ?>
<?php echo form_tag(url_for('@myemt.signup' . ($sf_params->get('keepon') ? '?keepon='.$sf_params->get('keepon') : ''), true)) ?>
<?php echo $sf_params->get('invite') ? input_hidden_tag('invite', $sf_params->get('invite')) : '' ?>
<dl class="_table signup">
    <dt><?php echo emt_label_for('name', __('Name')) ?></dt>
    <dd><?php echo input_tag('name', $sf_params->get('name', isset($invite)?$invite->getName():''), 'size=30') ?></dd>
    <dt><?php echo emt_label_for('lastname', __('Lastname')) ?></dt>
    <dd><?php echo input_tag('lastname', $sf_params->get('lastname', isset($invite)?$invite->getLastname():''), 'size=30') ?></dd>
    <dt><?php echo emt_label_for('email_first', __('Email address')) ?></dt>
    <dd><?php echo input_tag('email_first', $sf_params->get('email_first', isset($invite)?$invite->getEmail():''), 'size=30') ?></dd>
    <dt class="doubleline"><?php echo emt_label_for('email_repeat', __('Email address (repeat)')) ?></dt>
    <dd><?php echo input_tag('email_repeat', $sf_params->get('email_repeat', isset($invite)?$invite->getEmail():''), 'size=30') ?></dd>
    <dt><?php echo emt_label_for('gender', __('Gender')) ?></dt>
    <dd><?php echo select_tag('gender', options_for_select(array('female' => __('Female'), 'male' => __('Male')), $sf_params->get('gender'), array('include_custom' => __('Please Select')))) ?></dd>
    <dt><?php echo emt_label_for('birthdate', __('Birthdate')) ?></dt>
    <dd><?php echo select_day_tag('bd_day', $sf_params->get('bd_day') ? $sf_params->get('bd_day') : '') . '&nbsp;' . select_month_tag('bd_month', $sf_params->get('bd_month') ? $sf_params->get('bd_month') : '', array('include_custom' => __('month'))) . '&nbsp;' . select_year_tag('bd_year', $sf_params->get('bd_year') ? $sf_params->get('bd_year') : '', array('year_start' => date('Y'), 'year_end' => date('Y')-90, 'include_custom' => __('year'))) ?></dd>
    <dt class="ghost"></dt>
    <dd class="ghost"><?php echo cryptographp_picture(); ?>&nbsp;
        <?php echo cryptographp_reload(); ?></dd>
    <dt class="ghost"><?php echo emt_label_for('captcha', __('Security Code')) ?></dt>
    <dd class="ghost"><?php echo input_tag('captcha', '', array('style' => 'border:solid 1px #CCCCCC', 'size' => '6')); ?></dd>
    <dt></dt>
    <dd><?php echo submit_tag(__('Sign Up'), 'class=green-button') ?></dd>
</dl>
    <div class="clear g_bubble ui-corner-all pad-1"><span class="ln-example"><?php echo __('By clicking Sign Up, you are indicating that you have read and agree to the %1s and %2s.', array('%1s' => link_to(__('Terms of Use'),'@terms','target=emt_terms class=inherit-font bluelink hover'), '%2s' => link_to(__('Privacy Policy'),'@privacy','target=emt_privacy class=inherit-font bluelink hover'))) ?></span>
</form>
    </div>
<?php else: ?>
<div class="pad-3">
<?php if ($sf_user->getUser() && !$sf_user->getUser()->getCompany()): ?>
<div class="column span-62">
<div class="column">
<?php echo link_to(image_tag('layout/button/lobby/register-company.'.$sf_user->getCulture().'.png'), '@myemt.register-comp') ?>
</div>
<ul class="first" style="margin-top: 7px;display: inline-block; font: 1em 'helvetica'; color: #666666; list-style-type: circle; padding-left: 20px; line-height: 1.4em;">
<li><?php echo __('Promote your products and services') ?></li>
<li><?php echo __('Improve your accessiblity') ?></li>
<li><?php echo __('Get support from trade experts') ?></li>
<li><?php echo __('Exclusive access to buyers') ?></li>
<li><?php echo __('Build trusted relationships') ?></li>
<li><?php echo __('Beware business opportunities') ?></li>
</ul>
</div>
<div class="hrsplit-1"></div>
<?php endif ?>
<?php if ($sf_user->getUser() && !$sf_user->getUser()->getResume()): ?>
<div class="column span-62">
<div class="column">
<?php echo link_to(image_tag('layout/button/lobby/create-cv.'.$sf_user->getCulture().'.png'), '@hr.mycv-action?action=edit') ?>
</div>
<ul class="first" style="margin-top: 7px;display: inline-block; font: 1em 'helvetica'; color: #666666; list-style-type: circle; padding-left: 20px; line-height: 1.4em;">
<li><?php echo __('Improve your career') ?></li>
<li><?php echo __('Find a new job') ?></li>
<li><?php echo __('Be aware of employment opportunities') ?></li>
<li><?php echo __('Join social and business networks') ?></li>
</ul>                            
</div>
<div class="hrsplit-1"></div>
<?php endif ?>
</div>
<?php endif ?>
        </div>
    </div>


</div>

<?php echo javascript_tag("
$(function(){

    $('ul.home-tabs li').click(function(){ $('ul.home-pans li').removeClass('active'); $('ul.home-pans #' + $(this).attr('id').replace('tab', 'pan')).addClass('active'); $(this).siblings().removeClass('active'); $(this).addClass('active'); });

});
") ?>