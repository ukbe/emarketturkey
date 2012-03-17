<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('group/account', array('group' => $group)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4><?php echo __('Account Settings') ?></h4>
        </div>
        
        <div class="box_576 _titleBG_Transparent">
            <h4><?php echo __('Advanced Options') ?></h4>
        </div>
        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Transfer Account Ownership') ?></h5>
            <div class="_noBorder smalltext">
            <?php echo __('You may transfer the account ownership of your group <b>%1</b> to another eMarketTurkey member account.', array('%1' => $group)) ?>
            <?php echo link_to(__('Transfer Account Ownership ...'), "@group-account?action=transfer&hash={$group->getHash()}", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Parent/Subsidiary Groups') ?></h5>
            <div class="_noBorder smalltext">
            <?php echo __('In case your group is a subsidiary or parent of another group, you may setup relations with other groups by clicking the link below.') ?>
            <?php echo link_to(__('Setup Relations ...'), "@group-account?action=relations&hash={$group->getHash()}", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>
    </div>

    <div class="col_180">
        <?php include_partial('group/upgradeBox', array('group' => $group)) ?>
    </div>

    
</div>