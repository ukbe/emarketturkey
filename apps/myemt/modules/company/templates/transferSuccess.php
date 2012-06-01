<?php use_helper('Date') ?>
<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('company/account', array('company' => $company)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4><?php echo __('Transfer Account Ownership') ?></h4>
            <?php if ($transfer && ($transfer->getStatus()==TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER ||$transfer->getStatus()==TransferOwnershipRequestPeer::STAT_PENDING)): ?>
            <?php echo __('At the moment there is an initiated transfer process. Please see the details below.') ?>
                <?php if ($transfer->getStatus() == TransferOwnershipRequestPeer::STAT_PENDING): ?>
                <div class="bubble margin-t2 margin-b2"><b class="t_red"><?php echo __('Attention!') ?></b><br />
                    <?php echo __('You should now send <b>%1</b> the transfer code <b>%2</b> since %1 will need this code in order to accept the transfer request.', array('%1' => $transfer->getUserRelatedByNewOwnerId(), '%2' => $transfer->getTransferCode())) ?>
                    </div>
                <dl class="_table">
                    <dt><?php echo emt_label_for('init-code', __('Transfer Code')) ?></dt>
                    <dd style="font: bold 16px helvetica"><?php echo $transfer->getTransferCode() ?></dd>
                    <dt><?php echo emt_label_for('init-status', __('Status')) ?></dt>
                    <dd><?php echo TransferOwnershipRequestPeer::$statLabels[$transfer->getStatus()] ?></dd>
                    <dt><?php echo emt_label_for('init-date', __('Transfer Initiated At')) ?></dt>
                    <dd><?php echo format_date($transfer->getCreatedAt('U'), 'f') ?></dd>
                    <dt><?php echo emt_label_for('init-by', __('Initiated By')) ?></dt>
                    <dd><?php echo $transfer->getUserRelatedByProcessInitById() ?></dd>
                    <dt><?php echo emt_label_for('init-from', __('Transfer From')) ?></dt>
                    <dd><?php echo $transfer->getUserRelatedByCurrentOwnerId() ?></dd>
                    <dt><?php echo emt_label_for('init-to', __('Transfer To')) ?></dt>
                    <dd><?php echo $transfer->getUserRelatedByNewOwnerId() ?><br /><?php echo $transfer->getEmailAddress() ?></dd>
                    <?php if ($transfer->getStatus() == TransferOwnershipRequestPeer::STAT_PENDING): ?>
                    <dt></dt>
                    <dd><?php echo link_to(__('Cancel Transfer'), "@company-account?action=transfer&act=cancel&tid={$transfer->getGuid()}&hash={$company->getHash()}", 'class=green-button') ?></dd>
                    <?php endif ?>
                </dl>
                <div class="hrsplit-1"></div>
                <?php echo link_to(__('Re-send notification email to %1.', array('%1' => $transfer->getUserRelatedByNewOwnerId())), "@company-account?action=transfer&act=notify&hash={$company->getHash()}", 'class=act a16px message bluelink') ?>
                <div class="hrsplit-2"></div>
                <?php elseif ($transfer->getStatus() == TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER): ?>
                <div class="bubble margin-t2 margin-b2 pad-1"><b class="t_green"><?php echo __('Attention!') ?></b><br />
                    <?php echo __('<b>%1</b> accepted the account transfer by entering the transfer code.', array('%1' => $transfer->getUserRelatedByNewOwnerId())) ?>
                    <div class="hrsplit-1"></div>
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
                    </form></div>
                <?php endif ?>
            <?php else: ?>
            <?php if ($transfer && $transfer->getStatus() == TransferOwnershipRequestPeer::STAT_CANCELLED_BY_OWNER): ?>
            <div class="bubble margin-t2 margin-b2"><?php echo __('Transfer Process has been cancelled by account owner!') ?></div>
            <?php elseif ($transfer && $transfer->getStatus() == TransferOwnershipRequestPeer::STAT_CANCELLED_BY_INITER): ?>
            <div class="bubble margin-t2 margin-b2"><?php echo __('Transfer Process has been cancelled by process initiator!') ?></div>
            <?php endif ?>
            <?php if (!$member): ?>
            <?php echo __('Type email address* of the member who you want to transfer account ownership of the company <b>%1</b>.', array('%1' => $company)) ?>
            <em class="ln-example">* <?php echo __('Make sure to enter the registered email address of member.') ?></em>
            <div class="hrsplit-2"></div>
            <?php echo form_errors() ?>
            <?php echo form_tag("@company-account?action=transfer&hash={$company->getHash()}") ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('search_email', __('Email Address')) ?></dt>
                <dd><?php echo input_tag('search_email', $sf_params->get('search_email'), 'maxlength=80 style=width:230px;') ?></dd>
                <dt></dt>
                <dd><?php echo submit_tag(__('Search Member'), 'class=green-button') ?></dd>
            </dl>
            </form>
            <?php else: ?>
            <?php echo __('Please check the user below and make sure that %1 is the correct person who you want to transfer account ownership.', array('%1' => $member)) ?>
            <div class="_center center-childs margin-2">
            <?php include_partial('profile/user', array('user' => $member)) ?>
            <div class="hrsplit-3"></div>
            <?php echo form_tag("@company-account?action=transfer&hash={$company->getHash()}") ?>
            <?php echo input_hidden_tag('search_email', $sf_params->get('search_email')) ?>
            <?php echo input_hidden_tag('act', 'init') ?>
            <?php echo submit_tag(__('Yes, Send Transfer Request'), 'class=green-button') ?>&nbsp;&nbsp;
            <?php echo link_to(__('No! Go Back'), "@company-account?action=transfer&hash={$company->getHash()}", 'class=inherit-font bluelink hover') ?>
            </form>
            </div>
            <?php endif ?>
            <?php endif ?>
        </div>
    </div>

    <div class="box_180 _titleBG_White">
    <h3><?php echo __('How this works?') ?></h3>
    <div class="">
        <?php echo __('Need more info on how the transfer process works?') ?>
        <?php echo link_to_function(__('Get More Info'), "", 'class=clear inherit-font hover bluelink margin-t2 id=transfer-info') ?>
    </div>
    </div>
</div>

<div id="transfer-info-box" class="ghost">
<div style="padding: 7px;">
<span class="circle green">1</span><b><?php echo __('Search for the member') ?></b>
<p><?php echo __('On the "Transfer Account Ownership" page, ') ?></p>
<div class="hrsplit-2"></div>
<span class="circle green">2</span><b><?php echo __('Find the right person') ?></b>
<p><?php echo __('Find the correct line in the search results and select by clicking on it, then click send .') ?></p>
</div>
</div>
<?php echo javascript_tag("

$('#transfer-info').dynabox({clickerMethod: 'click', loadMethod: 'static', loadType: 'html', sourceElement: '#transfer-info-box', fillType: 'copy', position: 'window', autoUpdate: false, headerContent: '".__('Transfer Process Steps')."'}); 

") ?>
