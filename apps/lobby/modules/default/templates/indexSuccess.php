<?php use_helper('Cryptographp','DateForm') ?>
<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<div class="column span-120 pad-1" style="margin-top: 50px;">
<div class="column span-38" style="text-align: center;">
<?php echo image_tag('layout/background/lobby/jump-into-biz.'.$sf_user->getCulture().'.png') ?>
</div>
<div class="column span-80" style="text-align: center;">
<?php echo image_tag('layout/background/lobby/thumbs.png') ?>
</div>
<div class="column span-125" style="margin-top: 30px;">
<h2 style="font-family: 'trebuchet ms';letter-spacing: 0.5em; text-align: center;"><?php echo __('join the global business cloud') ?></h2>
</div>
</div>
<?php if (!$sf_user->getUser() || ($sf_user->getUser() && (!$sf_user->getUser()->getCompany() || !$sf_user->getUser()->getResume()))): ?>
<div id="signup" class="column span-77" style="background: url(/images/layout/background/lobby/right-box.<?php echo $sf_user->getCulture() ?>.png) no-repeat top left;">
<div class="column span-73" style="background: url(/images/layout/background/lobby/right-box-bottom.png) no-repeat bottom left; padding: 30px 10px 10px 10px;">
<h1 style="font: bold 14pt tahoma; color: #475057; padding-left: 17px;"><?php echo !$sf_user->getUser() ? __('Sign Up') : __('Get More') ?></h1>
<p style="width: 255px; font: 11pt tahoma; color: #475057; padding-left: 17px;"><?php echo __('eMarketTurkey helps you advance your commercial activities and personal network.') ?></p>
<div class="hrsplit-1"></div>
<?php if (!$sf_user->getUser()): ?>
<?php echo form_tag(url_for('@myemt.signup' . ($sf_params->get('keepon') ? '?keepon='.$sf_params->get('keepon') : ''), true)) ?>
<?php echo $sf_params->get('invite') ? input_hidden_tag('invite', $sf_params->get('invite')) : '' ?>
<table cellspacing="0" cellpadding="3" border="0" width="340">
<tr>
<td class="signupleft"><?php echo emt_label_for('name', __('Name')) ?></td>
<td><?php echo input_tag('name', $sf_params->get('name', isset($invite)?$invite->getName():''), 'size=30') ?></td></tr>
<tr>
<td class="signupleft"><?php echo emt_label_for('lastname', __('Lastname')) ?></td>
<td><?php echo input_tag('lastname', $sf_params->get('lastname', isset($invite)?$invite->getLastname():''), 'size=30') ?></td></tr>
<tr>
<td class="signupleft"><?php echo emt_label_for('email_first', __('Email address')) ?></td>
<td><?php echo input_tag('email_first', $sf_params->get('email_first', isset($invite)?$invite->getEmail():''), 'size=30') ?></td></tr>
<tr>
<td class="signupleft"><?php echo emt_label_for('email_repeat', __('Email address (repeat)')) ?></td>
<td><?php echo input_tag('email_repeat', $sf_params->get('email_repeat', isset($invite)?$invite->getEmail():''), 'size=30') ?></td></tr>
<tr>
<td class="signupleft"><?php echo emt_label_for('gender', __('Gender')) ?></td>
<td><?php echo select_tag('gender', options_for_select(array('female' => __('Female'), 'male' => __('Male')), $sf_params->get('gender'), array('include_custom' => __('Please Select')))) ?></td></tr>
<tr>
<td class="signupleft"><?php echo emt_label_for('birthdate', __('Birthdate')) ?></td>
<td><?php echo select_day_tag('bd_day', $sf_params->get('bd_day') ? $sf_params->get('bd_day') : '', array('include_custom' => __('day'))) . '&nbsp;' . select_month_tag('bd_month', $sf_params->get('bd_month') ? $sf_params->get('bd_month') : '', array('include_custom' => __('month'))) . '&nbsp;' . select_year_tag('bd_year', $sf_params->get('bd_year') ? $sf_params->get('bd_year') : '', array('year_start' => date('Y'), 'year_end' => date('Y')-90, 'include_custom' => __('year'))) ?></td></tr>
<tr>
<td></td>
<td><?php echo cryptographp_picture(); ?>&nbsp;
<?php echo cryptographp_reload(); ?></td></tr>
<tr>
<td class="signupleft"><?php echo emt_label_for('captcha', __('Security Code')) ?></td>
<td><?php echo input_tag('captcha', '', array('style' => 'border:solid 1px #CCCCCC', 'size' => '6')); ?></td></tr>
<tr>
<td colspan="2" style="text-align: center;"><?php echo submit_tag(__('Sign Up')) ?></td></tr>
<tr>
<td colspan="2" style="text-align: center; padding: 5px;"><em><?php echo __('By clicking Sign Up, you are indicating that you have read and agree to the %1s and %2s.', array('%1s' => link_to(__('Terms of Use'),'@terms','target=emt_terms'), '%2s' => link_to(__('Privacy Policy'),'@privacy','target=emt_privacy'))) ?></em>
<div class="hrsplit-1"></div><div class="right"><a href="//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_s" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_s.png" alt="TRUSTe online privacy certification"/></a></div>
</td></tr>
</table>
</form>
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
<?php echo link_to(image_tag('layout/button/lobby/create-cv.'.$sf_user->getCulture().'.png'), '@hr.hr-cv-create') ?>
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
</div></div>
<?php endif ?>