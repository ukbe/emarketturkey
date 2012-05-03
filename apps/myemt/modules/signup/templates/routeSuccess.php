        <?php echo javascript_tag("
    var changeStarted = false;
    function OnChangeStart(){
        changeStarted = true;
        jQuery('#changeform label').removeClass('error');
        jQuery('#changeform .erm').hide();
        jQuery('#changeform #post').hide();
        jQuery('#fixerrors').hide();
        jQuery('#changeform #posting').show();

        jQuery('#changeform label').removeClass('error');
        jQuery('#changeform div[id^=\"err\"]').hide();
        jQuery('#changeform div[id^=\"err\"] em').attr('html', '');
    }

    function interruptChange(){            
        changeStarted = false;
        if (navigator.appName == 'Microsoft Internet Explorer') {
            window.frames['cpframe'].document.execCommand('Stop');
        } else {
            window.frames['cpframe'].stop();
        }
        jQuery('#changeform #posting').hide();
        jQuery('#changeform #post').show();
    }

    function resetUpload(){
        changeStarted = false;
        jQuery('#changeform #post').hide();
        jQuery('#changeform #posting').show();
    }

    function OnChangeComplete(state, messages){
       if(state == 1)
       {
         jQuery('#pass-block').hide();
         jQuery('p#changeit').hide();
         jQuery('p#changeok').show();
       }
       else if(state == 0 && changeStarted)
       {
          if (messages)
          {
              for (i in messages)
              {
                jQuery('#changeform dd label[for=\"'+messages[i][0]+'\"]').addClass('error');
                jQuery('#changeform dd #err_'+messages[i][0]+' em').html(messages[i][1]);
                jQuery('#changeform dd #err_'+messages[i][0]).show();
              }
            jQuery('#fixerrors').html('".__('Please fix the errors specified below.')."');
            jQuery('#fixerrors').show();
          }
          else
          {
            jQuery('#fixerrors').html('".__('Unidentified error occured.')."');
          }
          jQuery('#changeform #posting').hide();
          jQuery('#changeform #post').show();
          jQuery('#fixerrors').show();
       }
       changeStarted = false;
    }
    
    jQuery('#changeform input').focus(function(){id=jQuery(this).attr('id');jQuery('#changeform label[for=\"'+mess[0]+'\"]').addClass('error');jQuery('#changeform #erm_'+mess[0]+' em').html(\"\");jQuery('#changeform #erm_'+mess[0]).hide();});
    
    ") ?>
<?php use_helper('Cryptographp', 'DateForm') ?>
<?php slot('subNav') ?>
<?php include_partial('signup/subNav-route', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 route">

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <div class="_noBorder">

<div style="width: 386px; background: url(/images/layout/route/email-notice.png) no-repeat; padding: 0px; padding-left: 60px;">
<h1><?php echo __('Check your inbox') ?></h1>
<p style="font: 11px tahoma;"><?php echo __('We have sent you an email including your password.') ?></p>
<p style="font: 11px tahoma;"><?php echo __("If you can't find the email in your inbox you may also need to check out your junk email folder.<br />Please send an email to <a href=\"mailto:support@emarketturkey.com\"><b>support@emarketturkey.com</b></a> for account issues.") ?></p>
<p id="changeok" class="t_green ghost"><?php echo __('Congragulations! Your password has been successfully changed.') ?></p>
<p id="changeit"><?php echo link_to_function(__('Change your password?'), "jQuery('#pass-block').show();", array('style' => 'font: bold 11px tahoma; color: #FF9600; text-decoration: none;')) ?></p>
<div id="pass-block" class="ghost">
<p id="fixerrors" class="t_red ghost"><?php echo __('Please fix the errors specified below.') ?></p>
<?php echo form_tag('@route?cp=true', array('id' => 'changeform', 'target' => 'cpframe', 'onsubmit' => 'OnChangeStart()')) ?>
<dl class="_table ui-corner-all" style="background-color: #;">
<dt><?php echo emt_label_for('old_password', __('Old Password :')) ?></dt>
<dd><?php echo input_password_tag('old_password', '', 'size=20 maxlength=50') ?><div id="err_old_password" class="ghost"><em class="t_red"></em></div></dd>
<dt><?php echo emt_label_for('new_password', __('New Password :')) ?></dt>
<dd><?php echo input_password_tag('new_password', '', 'size=20 maxlength=14') ?><div id="err_new_password" class="ghost"><em class="t_red"></em></div></dd>
<dt><?php echo emt_label_for('new_password_repeat', __('New Password (repeat) :')) ?></dt>
<dd><?php echo input_password_tag('new_password_repeat', '', 'size=20 maxlength=14') ?><div id="err_new_password_repeat" class="ghost"><em class="t_red"></em></div></dd>
<dt></dt>
<dd id="posting" class="ghost">
<?php echo __('Changing your password.') ?>&nbsp;&nbsp;<?php echo link_to_function(__('Cancel'), "interruptChange()", 'class=inherit-font bluelink hover') ?></dd>
<dd id="post" class="">
<?php echo submit_tag(__('Save Password'), 'class=action-button') ?>&nbsp;
<?php echo link_to_function(__('Cancel'), "jQuery('#pass-block').hide();", 'class=inherit-font bluelink hover') ?></dd>
</dl>
</form>
<iframe id="cpframe" name="cpframe" style="width: 0px; height: 0px; border: none; display: none;" onload="OnChangeComplete(0);"></iframe>
</div>
</div>
            </div>
        </div>
    </div>

    <div class="col_471">
        <div class="box_471 _titleBG_Transparent">
            <div class="_noBorder">

<div style="width: 386px; background: url(/images/layout/route/orange-column.png) no-repeat; padding: 0px; padding-left: 40px;">
<h1 style="font: bold 16pt arial; color: #FF9600;"><?php echo __('Thank you for signing up!') ?></h1>
<p><?php echo __('Before you start using eMarketTurkey create your user profile now.<br /> This way people and your friends can easily notice you.') ?></p>
<div class="hrsplit-1"></div>
<?php echo link_to(image_tag('layout/route/create-your-profile.'.$sf_user->getCulture().'.png', 'border=0'), '@setup-profile') ?>
</div>

            </div>
        </div>
    </div>
</div>

<?php echo javascript_tag("
window.name='emt-base';
function popit(url){window.open(url, 'consent','width=1000, height=570, left='+(screen.width/2-500)+', top='+(screen.height/2-285));}") ?>

<style>
.login h1 { font-family: 'Century Gothic', sans-serif; font-size: 20px; color: #222; margin: 0px; padding: 5px 10px; border-bottom: none; }
.route dl._table dt { width: 25%; }
.route dl._table dd { width:  65%;}
.route dl._table input[type=password] { width:  150px;}

</style>