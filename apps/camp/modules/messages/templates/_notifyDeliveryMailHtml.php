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
div.mbox
    {
        margin: 0px 0px 5px 0px;
        display: block;
        clear: both;
        color: #000000;
        border: solid 1px #E4AE47;
        background-color: #FFF3B3;
        padding: 10px;
        text-align: left;
    }

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
                <?php echo __('Hi %1,', array('%1' => $oname ? $oname : $rname)) ?><br /><br />
                <?php echo $oname ? __('%1 sent %2 a message.', array('%1' => $sname, '%2' => $rname)) : __('%1 sent you a message.', array('%1' => $sname)) ?><br /><br />
                <div class="mbox">
                <?php if ($subject!=''): ?>
                <b><?php echo $subject ?></b><br />
                <?php endif ?>
                <?php echo str_replace("\n", '<br />', $message) ?>
                </div><br />
                <?php echo __('You can click the link below to go to the message:') ?><br/>
                <?php echo link_to('', $message_link, array('absolute_url' => true)); ?>
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