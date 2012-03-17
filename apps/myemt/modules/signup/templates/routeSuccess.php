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
                jQuery('#changeform li label[for=\"'+messages[i][0]+'\"]').addClass('error');
                jQuery('#changeform li #err_'+messages[i][0]+' em').html(messages[i][1]);
                jQuery('#changeform li #err_'+messages[i][0]).show();
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
<div class="column span-198">
<div class="hrsplit-2"></div>
<?php echo image_tag('layout/background/welcome.to.emt.'.$sf_user->getCulture().'.png') ?>
</div>
<div class="hrsplit-3"></div>
<div class="column span-193 prepend-5">
<div class="column span-90">
<div class="column" style="width: 442px; background: url(/images/layout/route/grey-box-top-442x.png) top left no-repeat; padding-top: 10px;">
<div class="column" style="width: 442px; background: url(/images/layout/route/grey-box-bottom-442x.png) bottom left no-repeat; padding-bottom: 10px;">
<div class="column" style="width: 412px; background: url(/images/layout/route/grey-box-middle-442x.png) repeat-y; padding: 5px 15px;">
<ol class="column span-82" style="padding: 0px; margin: 0px;">
<li class="column span-9 first">
<?php echo image_tag('layout/route/email-notice.png') ?>
</li>
<li class="column span-73"><h1 style="font: bold 16pt verdana; color: #555555;"><?php echo __('Check your inbox') ?></h1></li>
<li class="column span-82 first">
<p style="font: 11px tahoma;"><?php echo __('We have sent you an email including your password.') ?></p>
<p style="font: 11px tahoma;"><?php echo __("If you can't find the email in your inbox you may also need to check out your junk email folder.<br />Please send an email to <a href=\"mailto:support@emarketturkey.com\"><b>support@emarketturkey.com</b></a> for account issues.") ?></p></li>
</ol>
<p id="changeok" class="ghost"><?php echo __('Congragulations! Your password has been successfully changed.') ?></p>
<p id="changeit"><?php echo link_to_function(__('Change your password?'), "jQuery('#pass-block').show();", array('style' => 'font: bold 11px tahoma; color: #FF9600; text-decoration: none;')) ?></p>
<div id="pass-block" class="ghost">
<p id="fixerrors" class="error ghost"><?php echo __('Please fix the errors specified below.') ?></p>
<?php echo form_tag('@route?cp=true', array('id' => 'changeform', 'target' => 'cpframe', 'onsubmit' => 'OnChangeStart()')) ?>
<ol class="column span-82" style="padding: 0px; margin: 0px;">
<li class="column span-30 append-1 right first"><?php echo emt_label_for('old_password', __('Old Password :')) ?></li>
<li class="column span-51"><?php echo input_password_tag('old_password', '', 'size=20 maxlength=50') ?><div id="err_old_password" class="first ghost"><em class="error"></em></div></li>
<li class="column span-30 append-1 right first"><?php echo emt_label_for('new_password', __('New Password :')) ?></li>
<li class="column span-51"><?php echo input_password_tag('new_password', '', 'size=20 maxlength=14') ?><div id="err_new_password" class="first ghost"><em class="error"></em></div></li>
<li class="column span-30 append-1 right first"><?php echo emt_label_for('new_password_repeat', __('New Password (repeat) :')) ?></li>
<li class="column span-51"><?php echo input_password_tag('new_password_repeat', '', 'size=20 maxlength=14') ?><div id="err_new_password_repeat" class="first ghost"><em class="error"></em></div></li>
<li class="column span-82 first" style="height: 5px;"></li>
<li id="posting" class="column span-82 first ghost" style="text-align: center;">
<?php echo __('Changing your password.') ?>&nbsp;<?php echo link_to_function(__('Cancel'), "interruptChange()", array('style' => 'font: 11px tahoma; text-decoration: none; color: #000000;')) ?></li>
<li id="post" class="column span-82 first" style="text-align: center;">
<?php echo submit_tag(__('Save Password'), array('style' => 'border: none; background-color: #868686; padding: 3px 6px; margin-right: 10px; font: 11px tahoma; color: #FFFFFF; text-decoration: none;')) ?>&nbsp;<?php echo link_to_function(__('Cancel'), "jQuery('#pass-block').hide();", array('style' => 'font: 11px tahoma; text-decoration: none; color: #000000;')) ?></li>
</ol>
<iframe id="cpframe" name="cpframe" style="width: 0px; height: 0px; border: none; display: none;" onload="OnChangeComplete(0);"></iframe>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="column span-87 prepend-3">
<ol class="column span-87">
<li class="column span-5"><?php echo image_tag('layout/route/orange-column.png') ?></li>
<li class="column span-82">
<h1 style="font: bold 16pt arial; color: #FF9600;"><?php echo __('Thank you for signing up!') ?></h1>
<p><?php echo __('Before you start using eMarketTurkey create your user profile now.<br /> This way people and your friends can easily notice you.') ?></p>
<div class="hrsplit-1"></div>
<?php echo link_to(image_tag('layout/route/create-your-profile.'.$sf_user->getCulture().'.png', 'border=0'), '@setup-profile') ?>
</li>
</ol>
</div>
<div class="hrsplit-1"></div>
</div>
<?php echo javascript_tag("
window.name='emt-base';
function popit(url){window.open(url, 'consent','width=1000, height=570, left='+(screen.width/2-500)+', top='+(screen.height/2-285));}") ?>