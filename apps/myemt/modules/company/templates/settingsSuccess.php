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
            <h4><?php echo __('Account Settings') ?></h4>
        </div>
        
        <div class="box_576 _titleBG_Transparent">
            <h4><?php echo __('Advanced Options') ?></h4>
        </div>
        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Transfer Account Ownership') ?></h5>
            <div class="_noBorder smalltext">
            <?php echo __('You may transfer the account ownership of your company <b>%1</b> to another eMarketTurkey member account.', array('%1' => $company)) ?>
            <?php echo link_to(__('Transfer Account Ownership ...'), "@company-account?action=transfer&hash={$company->getHash()}", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

        <div class="box_285">
            <h5 class="margin-0"><?php echo __('Parent/Subsidiary Companies') ?></h5>
            <div class="_noBorder smalltext">
            <?php echo __('In case your company is a subsidiary or parent of another company, you may setup relations with other companies by clicking the link below.') ?>
            <?php echo link_to(__('Setup Relations ...'), "@company-account?action=relations&hash={$company->getHash()}", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>
    </div>

    <div class="col_180">
        <?php include_partial('company/upgradeBox', array('company' => $company)) ?>
    </div>

    
</div>