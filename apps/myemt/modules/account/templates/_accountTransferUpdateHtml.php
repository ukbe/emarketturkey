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
                <?php echo __('This email was sent to inform you about the status change of %1 account transfer.', array('%1' => link_to($transacc, $transacclink, array('absolute_url' => true)))) ?><br /><br />
                <?php $mess = array(
                            TransferOwnershipRequestPeer::STAT_INVALID => __('This transfer is invalid.'),
                            TransferOwnershipRequestPeer::STAT_PENDING => __('This transfer is pending receiver user action.'),
                            TransferOwnershipRequestPeer::STAT_CANCELLED_BY_INITER => __('This transfer has been cancelled by initiator user.'),
                            TransferOwnershipRequestPeer::STAT_CANCELLED_BY_OWNER => __('This transfer has been cancelled by current account owner.'),
                            TransferOwnershipRequestPeer::STAT_DECLINED_BY_USER => __('This transfer has been rejected by receiver user.'),
                            TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER => __('This transfer has been accepted by receiver user.'),
                            TransferOwnershipRequestPeer::STAT_COMPLETED => __('This transfer has been completed.'),
                    ) ?>
                <?php echo $mess[$status_id] ?><br /><br />
                <?php echo __('Thank you for your attention!') ?><br /><br />
                <?php echo __('eMarketTurkey Team') ?><br /><br />
                <em><?php echo __('This e-mail was automatically sent from (%1).', array('%1' => link_to('http://www.emarketturkey.com', 'http://www.emarketturkey.com'))) ?></em>
            </p>
        </td>
    </tr>
</table>
</div>
</body>
</html>
<?php $sf_context->getI18N()->setCulture($clt) ?>