<?php use_helper('Date') ?>
<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>
<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('CV Database') ?></h4>
                <?php echo __('Your current credit amount is <b>%1</b>.', array('%1' => $credits)) ?>
                <div class="hrsplit-2"></div>
                <?php echo __('Prior to browsing or searching in <b>eMarketTurkey CV Database</b> you should buy credits.').'*' ?>
                <div class="clear"><em class="ln-example">* <?php echo __('You need 1 credit in order to unlock a single CV.') ?></em></div>
                <div class="hrsplit-3"></div>
                <?php include_partial('cvdb_select_credit_amount', array('add_route' => "$route&action=add2cart&custyp=$otyp&cusid={$owner->getId()}" , 'cus_type_id' => $otyp, 'cus_id' => $owner->getId())) ?>
            </section>
        </div>
    </div>

    <div class="col_180">
    </div>
    
</div>
