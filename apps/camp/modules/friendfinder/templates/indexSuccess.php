<?php use_helper('Cryptographp', 'DateForm') ?>

<?php slot('subNav') ?>
<?php include_partial('subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">
    <div class="box_657 _titleBG_Transparent" style="float: none; margin: 0 auto;">
        <div class="_noBorder">

<div class="bubble ui-corner-all">
<div style="background: url(/images/layout/windows-live-logo.png) 15px 30% no-repeat; background-size: 100px auto; padding: 0px 20px 15px 135px;">
<h4 class="noBorder"><?php echo __('Windows Live Contacts') ?></h4>
<?php echo __('Search for your friends by using your Windows Live account.<br />This way you will have the opportunity to find your friends who are already member of eMarketTurkey.') ?>
<div class="hrsplit-2"></div>
<?php echo link_to_function(__('Find Friends'), "popit('".url_for('@myemt.consent-import')."');", 'class=green-button target=_blank') ?>
<div class="hrsplit-2"></div>
<span class="ln-example"><?php echo __('Notice: eMarketTurkey WILL NOT be able to access or store your password.') ?></span>
</div>
</div>
<div class="hrsplit-3"></div>
<div class="bubble ui-corner-all">
<div style="background: url(/images/layout/google.png) 15px 30% no-repeat; background-size: 100px auto; padding: 0px 20px 15px 135px;">
<h4 class="noBorder"><?php echo __('Google Contacts') ?></h4>
<?php echo __('Search for your friends by using your Google account.<br />This way you will have the opportunity to find your friends who are already member of eMarketTurkey.') ?>
<div class="hrsplit-2"></div>
<?php echo link_to_function(__('Find Friends'), "popit('".url_for('@myemt.google-import')."');", 'class=green-button target=_blank') ?>
<div class="hrsplit-2"></div>
<span class="ln-example"><?php echo __('Notice: eMarketTurkey WILL NOT be able to access or store your password.') ?></span>
</div>
</div>
<div class="hrsplit-3"></div>
<div class="bubble ui-corner-all">
<div style="background: url(/images/layout/address-book.png) 15px 30% no-repeat; background-size: 100px auto; padding: 0px 20px 15px 135px;">
<h4 class="noBorder"><?php echo __('Invite Friends') ?></h4>
<?php echo __('You may invite your friends to join eMarketTurkey by providing their e-mail addresses.') ?>
<div class="hrsplit-2"></div>
<?php echo link_to(__('Continue'), "@invite-friends", 'class=green-button') ?>
</div>
</div>
<div class="hrsplit-3"></div>
<?php if ($sf_params->get('sup') == 'true'): ?>
<span class="_right"><?php echo link_to(__('Skip this step'), '@myemt.homepage', 'class=inherit-font bluelink hover') ?></span>
<?php endif ?>
<div class="hrsplit-3"></div>
<?php echo javascript_tag("
window.name='emt-base';
function popit(url){window.open(url, 'consent','width=1000, height=570, left='+(screen.width/2-500)+', top='+(screen.height/2-285));}") ?>
        </div>
    </div>
</div>