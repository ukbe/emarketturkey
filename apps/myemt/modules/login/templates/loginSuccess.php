<div class="column span-82 append-1 prepend-15">
<h2><?php echo __('Login') ?></h2>
<div class="inside">
<?php echo form_tag('@login') ?>
<?php echo input_hidden_tag('_ref', $_ref) ?>
<div class="span-75">
<p><?php echo __('If you already have an eMarketTurkey.com account, you can login to your account using your email address and password.') ?></p>
<?php echo form_errors() ?>
</div>
<div class="hrsplit-3"></div>
 <ol id="signup" class="column span-68 last large-form">
  <li class="column span-14 first right"><?php echo emt_label_for('email_p', __('E-mail')) ?></li>
  <li class="column span-42"><?php echo input_tag('email', '', 'id=email_p name=email maxlength=50') ?></li>
  <li class="column span-14 first right"><?php echo emt_label_for('password_p', __('Password')) ?></li>
  <li class="column span-42"><?php echo input_password_tag('password', '', 'id=password_p name=password') ?></li>
  <li class="column span-42 prepend-14 first"><?php echo checkbox_tag('remember', 1, $sf_user->getAttribute("remember"), 'id=remember_p name=remember') ?>
                                        <?php echo emt_label_for('remember_p', __('Remember Me')) ?></li>
  <li class="column span-42 prepend-14 first"><?php echo submit_tag(__('Login'), 'class=command') ?></li>
  <li class="column span-54 prepend-2"><div class="hrsplit-1"></div><?php echo link_to(__('Login Problems?'), "@homepage") ?>
  &nbsp;&nbsp;or&nbsp;&nbsp; 
<?php echo link_to(__('Forgot Password?'), "@forgot-password") ?></li>
 </ol>
<?php echo "</form>" ?>
</div>
</div>
<div class="column span-82 last prepend-15">
<h2><?php echo __('Sign Up') ?></h2>
<div class="inside">
<div class="span-75">
<p><?php echo __("Don't have an eMarketTurkey.com account, yet?<br /><b>You can sign up in seconds!</b>") ?></p>
<div class="hrsplit-1"></div>
<p><?php echo link_to(image_tag('layout/button/joinnow.'.$sf_user->getCulture().'.gif'), '@signup') ?></p>
<div class="hrsplit-1"></div>
<p><?php echo __('%1 to get more information on sign up process<br />or <br />%2 how you can benefit for your career or your corporation.', array('%1' => link_to(__("Click"), "@homepage"), '%2' => link_to(__("Find out"), "@homepage"))) ?></p>
<div class="hrsplit-1"></div>
<div><h4><?php echo __('Registration FAQ') ?></h4> 
<ul>
<li><?php echo link_to (__('Who can register to eMarketTurkey?'), "@homepage") ?></li>
<li><?php echo link_to (__('How can I register my company?'), "@homepage") ?></li>
<li><?php echo link_to (__('Why is the site called eMarketTurkey?'), "@homepage") ?></li>
</ul>
<?php echo link_to (__('read more'), "@homepage") ?>
</div></div>
</div>
</div>
<?php echo "</form>" ?>
<div class="column span-82 last prepend-15" style="margin-top: 30px;">
<div class="column span-35"><a href="//privacy-policy.truste.com/click-with-confidence/wps/en/emarketturkey.com/seal_m" title="TRUSTe online privacy certification" target="_blank"><img style="border: none" src="//privacy-policy.truste.com/certified-seal/wps/en/emarketturkey.com/seal_m.png" alt="TRUSTe online privacy certification"/></a></div>
<div class="column span-16 pad-1"><!-- BEGIN DigiCert Site Seal Code --><div id="digicertsitesealcode"><script language="javascript" type="text/javascript" src="https://www.digicert.com/custsupport/sealtable.php?order_id=00246390&amp;seal_type=a&amp;seal_size=small&amp;seal_color=blue&amp;new=1&amp;newsmall=1"></script><a href="http://www.digicert.com/">SSL Certificate</a><script language="javascript" type="text/javascript">coderz();</script></div><!-- END DigiCert Site Seal Code --></div>
</div>