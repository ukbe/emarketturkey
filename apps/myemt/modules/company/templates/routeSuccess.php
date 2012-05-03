<?php use_helper('DateForm') ?>
<?php slot('subNav') ?>
<?php include_partial('subNav-route', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="col_678 login">
        <div class="box_678 _titleBG_Transparent">
            <h4 class="_noBorder"><?php echo __('Hooray!') ?></h4>
            <div class="_noBorder">
                <div class="spot margin-b2">
                <?php echo __('%1cmp&nbsp; is now registered.', array('%1cmp' => $company)) ?>
                </div>
                <div class="hrsplit-3"></div>
                <div class="ui-corner-all bubble pad-3">
                    <div><?php echo __("We have sent you an e-mail providing information on how to manage your company account.") ?></div>
                    <div><?php echo __("Company profile is available at %1cplink.", array('%1cplink' => link_to('', $company->getProfileUrl(), array('absolute' => true, 'class' => 'inherit-font bluelink hover', 'target' => 'blank')))) ?></div>
                </div>
                <div class="hrsplit-3"></div>
                <div class="txtCenter">
                    <h3><?php echo __("What's Next?") ?></h3>
                <div style="display: inline-block;">
                    <ul class="_horizontal sepdot">
                        <li><?php echo link_to(__('List your first product'), "@add-product?hash={$company->getHash()}", 'class=inherit-font bluelink hover') ?></li>
                        <li><?php echo link_to(__('Post a Job'), "@company-jobs-action?hash={$company->getHash()}&action=overview", 'class=inherit-font bluelink hover') ?></li>
                        <li><?php echo __('Go to %1mcp page', array('%1mcp' => link_to(__('Manage Company'), $company->getManageUrl(), 'class=inherit-font bluelink hover'))) ?></li>
                    </ul>
                </div>
                </div>
                <div class="hrsplit-3"></div>
                <div class="hrsplit-3"></div>
                <div style="text-align: center;">
                    <?php echo image_tag("layout/route/menu-strip-company.{$sf_user->getCulture()}.png", 'style=border: solid 1px #ddd; padding: 8px;') ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col_264">
        <div class="box_264 _titleBG_Transparent">
            <h4><?php echo __('Profile Status') ?></h4>
            <div class="_noBorder">
            <?php echo $company->getStatusMessage() ?>
            </div>
        </div>
        <div class="box_264 _titleBG_Transparent">
            <h4><?php echo __('Upgrade to a Premium Account') ?></h4>
            <div class="_noBorder" style="background: url(/images/background/emtTrust);">
                <?php echo __("Prove your company's online reliability by upgrading your account.") ?>
                <?php echo link_to(__('Upgrade Account'), "@company-account?action=upgrade&hash={$company->getHash()}", 'class=green-button margin-t2')?>
            </div>
        </div>
    </div>

</div>
<style>
.login h4 { font-family: 'Century Gothic', sans-serif; font-size: 23px; color: #222; margin: 0px 0px 10px; padding: 5px 10px; border-bottom: none; }
.spot { font-family: 'Century Gothic', sans-serif; font-size: 26px; color: #0088CC; }
</style>