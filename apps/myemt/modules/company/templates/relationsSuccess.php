<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('company/account', array('company' => $company)) ?>
        </div>

    </div>
<?php $width = count($parents)> 3 || count($subsidiaries) > 3 ? 762 : 576 ?>
    <div class="col_<?php echo $width ?>">
        <div class="box_<?php echo $width ?> _titleBG_Transparent">
            <section>
            <h4><?php echo __('Parent and Subsidiary Companies') ?></h4>
            <div class="hrsplit-2"></div>
            <table class="subsup above">
                <tr><?php foreach ($parents as $parent): ?>
                    <?php $rl = $company->getCompanyUserFor($parent->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, RolePeer::RL_CM_PARENT_COMPANY) ?>
                    <td><div><?php echo link_to($parent, $parent->getProfileUrl(), $rl->getStatus() == CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION ? 'class=unconfirmed' : '') ?>
                        <?php echo $rl->getStatus() == CompanyUserPeer::CU_STAT_ACTIVE ? link_to('&nbsp', "@company-account?action=relations&act=remove&cid={$parent->getId()}&rel=parent&hash={$company->getHash()}", array('class' => 'click-remove', 'title' => __('Click to remove this relation')))
                                : link_to('&nbsp', "@company-account?action=relations&act=remove&cid={$parent->getId()}&rel=parent&hash={$company->getHash()}", array('class' => 'click-unconfirmed', 'title' => __("This relation is not confirmed yet by related company.\nClick to remove this relation"))) ?>
                        </div></td>
                    <?php endforeach ?>
                    <td class="adder"><?php echo link_to(__('Add a Parent Company'), "@company-account?action=relations&act=add&typ=parent&hash={$company->getHash()}", 'class=inherit-font t_orange hover') ?></td>
                </tr></table>
            <table class="subsup">
                <tr>
                    <td><div class="current"><?php echo $company ?></div></td>
                    <td class="adder">&nbsp;</td>
                </tr></table>
            <table class="subsup below">
                <tr><?php foreach ($subsidiaries as $subsidiary): ?>
                    <?php $rl = $company->getCompanyUserFor($subsidiary->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, RolePeer::RL_CM_SUBSIDIARY_COMPANY) ?>
                    <td><div><?php echo link_to($subsidiary, $subsidiary->getProfileUrl(), $rl->getStatus() == CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION ? 'class=unconfirmed' : '') ?>
                        <?php echo $rl->getStatus() == CompanyUserPeer::CU_STAT_ACTIVE ? link_to('&nbsp', "@company-account?action=relations&act=remove&cid={$subsidiary->getId()}&rel=subsidiary&hash={$company->getHash()}", array('class' => 'click-remove', 'title' => __('Click to remove this relation')))
                                : link_to('&nbsp', "@company-account?action=relations&act=remove&cid={$subsidiary->getId()}&rel=subsidiary&hash={$company->getHash()}", array('class' => 'click-unconfirmed', 'title' => __("This relation is not confirmed yet by related company.\nClick to remove this relation"))) ?>
                        </div></td>
                    <?php endforeach ?>
                    <td class="adder"><?php echo link_to(__('Add a Subsidiary Company'), "@company-account?action=relations&act=add&typ=subsidiary&hash={$company->getHash()}", 'class=inherit-font t_orange hover') ?></td>
                </tr></table>
            <div class="hrsplit-2"></div>
            <style>
                table.subsup { width: 100%; text-align: center; margin: 5px 0px; }
                table.subsup td { padding: 0px; }
                table.subsup.above td { vertical-align: bottom; background: url(/images/layout/icon/down-triangle.png) no-repeat center bottom; padding-bottom: 20px; }
                table.subsup.below td { vertical-align: top; background: url(/images/layout/icon/up-triangle.png) no-repeat center top; padding-top: 20px; }
                table.subsup.above td:hover { background: url(/images/layout/icon/down-triangle-dark.png) no-repeat center bottom; }
                table.subsup.below td:hover { background: url(/images/layout/icon/up-triangle-dark.png) no-repeat center top; }
                table.subsup td div a { font: 14px helvetica; padding: 10px; border: solid 2px #a2a3a2; margin: 0px 10px; -webkit-border-radius: 10px; display: block; text-align: center; }
                table.subsup.above td div a.unconfirmed,
                table.subsup.below td div a.unconfirmed { border: solid 2px #e0e0e0; background-color: #f9f9f9; color: #aaa; }
                table.subsup.above td div a {  background-color: #e8f3f4; }
                table.subsup.below td div a {  background-color: #d8edd1; }
                table.subsup td div a:hover { color: #000;border: solid 2px #d9dbd9; }
                table.subsup td div.current { background-color: transparent; border: none; margin: 20px 0px; text-align: center; font: bold 17px helvetica; }
                table.subsup td.adder { width: 120px; background-image: none; font-size: 12px; line-height: 17px; }
                table.subsup.above td.adder:hover { background: url(/images/layout/icon/green-plus-12px.png) no-repeat center bottom; }
                table.subsup.below td.adder:hover { background: url(/images/layout/icon/green-plus-12px.png) no-repeat center top; }
                table.subsup.above td.adder { padding: 0px 10px 23px; vertical-align: bottom; }
                table.subsup.below td.adder { padding: 23px 10px 0px; vertical-align: top; }
                table.subsup td div { position: relative; }
                table.subsup td div a.click-remove { width: 20px; height: 20px; padding: 0px; margin: 0px; position: absolute; right: 1px; top: -9px; background: url(/images/layout/icon/remove_red.png) no-repeat center; display: none; border: none; }
                table.subsup td div:hover a.click-remove { display: block; }
                table.subsup td div:hover a.click-remove:hover { background: url(/images/layout/icon/remove_red_hover.png) no-repeat center; }
                table.subsup td div a.click-unconfirmed { width: 20px; height: 20px; padding: 0px; margin: 0px; position: absolute; right: 1px; top: -9px; background: url(/images/layout/icon/exclamation-circle_red.png) no-repeat center; border: none; }
                table.subsup td div:hover a.click-unconfirmed { display: block; }
                table.subsup td div:hover a.click-unconfirmed:hover { background: url(/images/layout/icon/exclamation-circle_red_hover.png) no-repeat center; }
            </style>
            </section>
        </div>
        
    </div>
    <?php if ($width == 576): ?>

    <div class="col_180">
        <?php include_partial('company/upgradeBox', array('company' => $company)) ?>
    </div>

    <?php endif ?>
</div>