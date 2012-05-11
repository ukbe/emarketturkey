<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<?php $clt = $sf_context->getI18N()->getCulture() ?>
<?php $sf_context->getI18N()->setCulture($culture) ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="emt" />
<meta name="language" content="EN" />
<meta name="content-language" content="EN" />
<style>
body { font-family: Arial; font-size: 10pt; font-weight: normal; color: #000000; }
</style>
</head>
<body>
<div>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        
    </tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <p style="margin: 20px; font-family: Arial; font-size: 10pt">
                <?php echo __('Hi %1', array('%1' => $uname)) ?>,<br /><br />
                <?php echo __('You have submitted us a request to reset your password.') ?><br /><br />
                <?php echo __('Please click the link below to reset your password :') ?><br />
                <?php echo link_to('', 'login/resetPassword', array('absolute_url' => true, 'query_string' => 'log='.$loginuid.'&req='.$reqid)) ?><br /><br />
                <br /><br />
                <?php echo __('eMarketTurkey Team') ?>
                <br /><br />
                <em><?php echo __('This e-mail was automatically sent from (%1).', array('%1' => link_to('http://www.emarketturkey.com', 'http://www.emarketturkey.com'))) ?></em>
            </p>
        </td>
    </tr>
</table>
</div>
</body>
</html>
<?php $sf_context->getI18N()->setCulture($clt) ?>