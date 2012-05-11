<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<?php $clt = $sf_context->getI18N()->getCulture() ?>
<?php $sf_context->getI18N()->setCulture($culture) ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="emt" />
<meta name="language" content="<?php echo $culture ?>" />
<meta name="content-language" content="<?php echo $culture ?>" />
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
                <?php echo __('Hi %1,', array('%1' => $uname)) ?><br /><br />
                <?php echo __('You have a pending account transfer request.') ?><br /><br />
                <?php echo __('%1 initiated an account transfer process for %2. You have to login to your account and accept transfer by entering the TRANSFER CODE.', array('%1' => link_to($inituser, $inituserlink), '%2' => link_to($transacc, $transacclink))) ?><br /><br />
                <?php echo __('%1 should contact you for the Transfer Code, soon. Once you receive the TRANSFER CODE, click the link below in order to go to Account Transfer page', array('%1' => $inituser)) ?><br /><br />
                <?php echo link_to('', "@account-transfer", array('absolute_url' => true, 'query_string' => "tid={$tid}&act=takeover")) ?><br /><br /><br />
                <?php echo __('Thank you for your attention!') ?><br /><br />
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