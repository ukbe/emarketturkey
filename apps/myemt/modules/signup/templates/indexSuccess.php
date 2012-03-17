<?php use_helper('Cryptographp','DateForm') ?>
<?php if ($sf_params->get('keepon')==url_for('@hr.mycv-action?action=basic')): ?>
<div style="text-align: center;"><?php echo image_tag('layout/background/create-cv-step-1.'.$sf_user->getCulture().'.png') ?></div>
<div class="column span-90 pad-2 prepend-4">
<h1><?php echo __('Step 1 - Create Your Personal Account') ?></h1>
<p><?php echo __('Please fill in the form below to have your login account created.<br /><br />Once your login account is created, you will be redirected to CV creating page.') ?></p>
<?php elseif ($sf_params->get('keepon')==url_for('@register-comp')): ?>
<div style="text-align: center;"><?php echo image_tag('layout/background/register-company-step-1.'.$sf_user->getCulture().'.png') ?></div>
<div class="column span-90 pad-2 prepend-4">
<h1><?php echo __('Step 1 - Create Your Personal Account') ?></h1>
<p><?php echo __('Please fill in the form below to have your login account created.<br /><br />Once your login account is created, you will be redirected to Company registration page.') ?></p>
<?php else: ?>
<div id="signup" class="column span-85 pad-2 prepend-4">
<h1><?php echo __('Sign Up') ?></h1>
<p><?php echo __('Please fill in the form below to have your login account created.') ?></p>
<?php endif ?>
<?php echo form_tag(url_for('@signup' . ($sf_params->get('keepon') ? '?keepon='.$sf_params->get('keepon') : ''), true)) ?>
<?php echo $sf_params->get('invite') ? input_hidden_tag('invite', $sf_params->get('invite')) : '' ?>
<table cellspacing="0" cellpadding="3" border="0" width="425">
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
<td class="signupleft"><?php echo emt_label_for(array('bd_day', 'bd_month', 'bd_year'), __('Birthdate')) ?></td>
<td><?php echo select_day_tag('bd_day', $sf_params->get('bd_day') ? $sf_params->get('bd_day') : '', array('include_custom' => __('day'))) . '&nbsp;' . select_month_tag('bd_month', $sf_params->get('bd_month') ? $sf_params->get('bd_month') : '', array('include_custom' => __('month'))) . '&nbsp;' . select_year_tag('bd_year', $sf_params->get('bd_year') ? $sf_params->get('bd_year') : '', array('year_start' => date('Y'), 'year_end' => date('Y')-90, 'include_custom' => __('year'))) ?></td></tr>
<tr>
<td></td>
<td><?php echo cryptographp_picture(); ?>&nbsp;
<?php echo cryptographp_reload(); ?><br /><em class="tip"><?php echo __('Type the code you see above into Security Code field.') ?></em></td></tr>
<tr>
<td class="signupleft"><?php echo emt_label_for('captcha', __('Security Code')) ?></td>
<td><?php echo input_tag('captcha', '', array('style' => 'border:solid 1px #CCCCCC', 'size' => '6')); ?></td></tr>
<tr>
<td colspan="2" style="text-align: center;"><?php echo submit_tag(__('Sign Up')) ?></td></tr>
<tr>
<td colspan="2" style="text-align: center; padding: 5px;"><em><?php echo __('By clicking Sign Up, you are indicating that you have read and agree to the %1s and %2s.', array('%1s' => link_to(__('Terms of Use'),'@lobby.terms','target=emt_terms'), '%2s' => link_to(__('Privacy Policy'),'@lobby.privacy','target=emt_privacy'))) ?></em></td></tr>
</table>
</form>
</div>
<div class="column span-95 pad-2 prepend-3 last">
<div style="height:75px"></div>
<?php if (isset($errorWhileSaving) && $errorWhileSaving == true): ?>
<div class="error" style="font-size: larger;color: red;">
<?php echo __('An error occurred while creating your account.<br />We are sorry for the inconvenience and still working to work out the problem.') ?>
</div>
<?php elseif (form_errors()): ?>
<div><?php echo form_errors() ?></div>
<?php else: ?>
<table cellspacing="0" cellpadding="5">
<tr><td><?php echo image_tag('layout/background/signup/business-graph.png') ?></td>
    <td class="slogan-large"><?php echo __('eMarketTurkey helps you advance your commercial activities') ?></td></tr>
<tr><td><?php echo image_tag('layout/background/signup/social-networking.png') ?></td>
    <td class="slogan-large"><?php echo __('eMarketTurkey helps you extend your personal network') ?></td></tr>
</table>
<div class="column span-60" style="margin-top: 50px;">
<div class="column span-40"><a href="//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_l" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_l.png" alt="TRUSTe online privacy certification"/></a></div>
<div class="column span-16 pad-2"><!-- BEGIN DigiCert Site Seal Code --><div id="digicertsitesealcode"><script language="javascript" type="text/javascript" src="https://www.digicert.com/custsupport/sealtable.php?order_id=00246390&amp;seal_type=a&amp;seal_size=small&amp;seal_color=blue&amp;new=1&amp;newsmall=1"></script><a href="http://www.digicert.com/">SSL Certificate</a><script language="javascript" type="text/javascript">coderz();</script></div><!-- END DigiCert Site Seal Code --></div>
</div>
<?php endif ?>
 </div>