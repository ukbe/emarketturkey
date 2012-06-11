<?php $clt = $sf_context->getI18N()->getCulture() ?>
<?php $sf_context->getI18N()->setCulture($culture) ?>
<html>
<head>
<title><?php echo __("You've got an eMarketTurkey Invitation") ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
<style>
    p,div, a { font: 11px tahoma; }
</style>
</head>
<body bgcolor="#FFFFFF">
<div style="width: 748px; margin: 10px auto; background: url(http://www.emarketturkey.com/images/content/invite/template-1/middle-back.png) left repeat-y; padding: 0px;">
<div style="background: url(http://www.emarketturkey.com/images/content/invite/template-1/border-top.png) 0px 0px;">
    <img src="http://www.emarketturkey.com/images/spacer.gif" width="1" height="9" /></div>
<div style="padding: 1px; text-align: left;">
    <a href="http://www.emarketturkey.com"><img src="http://www.emarketturkey.com/images/content/invite/template-1/header.<?php echo $culture ?>.png" width="735" height="73" border="0" /></a></div>
<div>
    <div style="float: left; width: 420px; text-align: left; padding-left: 30px; padding-top: 20px;">
        <p><b><?php echo ($iname||$ilname)?__('Hello %1n %2n,', array('%1n' => $iname, '%2n' => $ilname)):__('Hello,') ?></b></p>
        <p><?php echo __('Your friend <b>%1n</b> has invited you to join eMarketTurkey.', array('%1n' => $mnamelname)) ?></p>
        <?php if ($message): ?>
        <p><?php echo __('Here is %1 message :', array('%1' => ($gender==UserProfilePeer::GENDER_FEMALE?__('her'):__('his')))) ?></p>
        <p>"<?php echo $message ?>"</p>
        <?php endif ?>
        <p><?php echo __("You may click the link below to respond to your friend's invitation:") ?></p>
        <p><?php echo link_to('', '@myemt.signup', array('query_string' => 'invite='. $invite_guid, 'absolute' => true)) ?></p><br />
        <p><?php echo link_to('View in English', '@lobby.viewinvite', array('query_string' => 'invite=' . $invite_guid . '&ln=en', 'absolute' => true)) ?>&nbsp;&nbsp;
<?php echo link_to('Türkçe dilinde oku', '@lobby.viewinvite', array('query_string' => 'invite=' . $invite_guid . '&ln=tr', 'absolute' => true)) ?>&nbsp;&nbsp;</p>
    </div>
    <div style="float: left;">
        <img src="http://www.emarketturkey.com/images/content/invite/template-1/network.png" width="259" height="208" />
    </div></div>
<div align="left" style="padding-left: 1px;">
    <img src="http://www.emarketturkey.com/images/content/invite/template-1/services.<?php echo $culture ?>.png" width="707" height="206" />
    </div>
<div align="right" style="padding: 20px 40px;"><?php echo link_to(__('More about eMarketTurkey Services'), '@lobby.homepage') ?></div>
<div align="right" style="padding: 20px 40px;"><?php echo __('eMarketTurkey Team') ?></div>
<div style="background: url(http://www.emarketturkey.com/images/content/invite/template-1/footer.png) top left no-repeat;">
            <img src="http://www.emarketturkey.com/images/spacer.gif" width="1" height="12" /></div>
            <img src="http://www.emarketturkey.com/en/feedback?invite=<?php echo $invite_guid ?>" />
</div>
<div align="center">
<em><?php echo __('If you cannot view this message properly, then %1.', array('%1' => link_to(__('click here'), '@homepage'))) ?></em>
</div>
</body>
</html>
<?php $sf_context->getI18N()->setCulture($clt) ?>