<?php use_helper('Date') ?>
<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
        </div>
    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4><?php echo __('Account Transfer') ?></h4>
            <div class="hrsplit-2"></div>
            <?php if (isset($show_message)): ?>
            <?php $mess = array(
                            TransferOwnershipRequestPeer::STAT_INVALID => __('This transfer is invalid.'),
                            TransferOwnershipRequestPeer::STAT_PENDING => __('This transfer is pending receiver user action.'),
                            TransferOwnershipRequestPeer::STAT_CANCELLED_BY_INITER => __('This transfer has been cancelled by initiator user.'),
                            TransferOwnershipRequestPeer::STAT_CANCELLED_BY_OWNER => __('This transfer has been cancelled by current account owner.'),
                            TransferOwnershipRequestPeer::STAT_DECLINED_BY_USER => __('This transfer has been rejected by receiver user.'),
                            TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER => __('This transfer has been accepted by receiver user.'),
                            TransferOwnershipRequestPeer::STAT_COMPLETED => __('This transfer has been completed.'),
                    ) ?>
            <?php echo $mess[$transfer->getStatus()] ?>
            <?php else: ?>
            <?php if ($act == 'takeover'): ?>
                <?php if ($transfer->getStatus() == TransferOwnershipRequestPeer::STAT_PENDING): ?>
            <?php echo __('You have to provide TRANSFER CODE in order to obtain the ownership of <b>%1</b> account. If the current owner did not send you the TRANSFER CODE please ask for the code.', array('%1' => $transfer->getAccount())) ?>
            <div class="hrsplit-1"></div>
            <?php echo __('If you want to reject the transfer, then please click the Reject Ownership link below.') ?>
            <div class="hrsplit-2"></div>
            <?php echo form_errors() ?>
            <?php echo form_tag("@account-transfer?tid={$transfer->getGuid()}&act=$act") ?>
            <?php echo input_hidden_tag('opt', 'in') ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('tr-code', __('Transfer Code')) ?></dt>
                <dd><?php echo input_tag('tr-code', $sf_params->get('tr-code'), 'maxlength=50 style=width:150px;') ?></dd>
                <dt></dt>
                <dd><?php echo submit_tag(__('Submit Code'), 'class=green-button') ?>&nbsp;&nbsp;
                    <?php echo link_to(__('Reject Transfer'), "@account-transfer?tid={$transfer->getGuid()}&act=$act&opt=out", 'class=inherit-font bluelink hover') ?></dd>
            </dl>
            </form>
            <?php elseif ($transfer->getStatus() == TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER): ?>
            <?php echo __('You have accepted this transfer by providing TRANSFER CODE.<br />However, in case you want to cancel transfer, you can click "Reject Transfer" link before the current account owner confirms the transfer.') ?>
            <div class="hrsplit-2"></div>
            <?php echo link_to(__('Reject Transfer'), "@account-transfer?tid={$transfer->getGuid()}&act=takeover&opt=out", 'class=inherit-font t_red hover') ?>
            <?php endif ?>
            <?php elseif ($act == 'finalize'): ?>
            <?php echo __('The account for <b>%1</b> is about to be transferred to <b>%2</b>.', array('%1' => $transfer->getAccount(), '%2' => $transfer->getUserRelatedByNewOwnerId())) ?>
            <div class="hrsplit-1"></div>
            <?php echo __('Click Confirm button to complete the transfer process. If you did not initiate the transfer process or do not want to transfer <b>%1</b> account, then simply click the <b>Cancel Transfer</b> link below in order to cancel the whole process.', array('%1' => $transfer->getAccount())) ?>
            <div class="hrsplit-2"></div>
            <?php echo form_errors() ?>
            <?php echo form_tag("@account-transfer?tid={$transfer->getGuid()}&act=$act") ?>
            <?php echo input_hidden_tag('opt', 'in') ?>
            <div class="_center">
            <?php echo submit_tag(__('Confirm Transfer'), 'class=green-button') ?>&nbsp;&nbsp;
            <?php echo link_to(__('Cancel Transfer'), "@account-transfer?tid={$transfer->getGuid()}&act=$act&opt=out", 'class=inherit-font bluelink hover') ?>
            </div>
            </form>
            <?php endif ?>
            <?php endif ?>
        </div>
    </div>

    <div class="box_180 _titleBG_White">
    </div>
</div>