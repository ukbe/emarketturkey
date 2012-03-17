<?php use_helper('DateForm', 'Object') ?>

<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('products/products', array('company' => $company)) ?>
        </div>
    </div>
    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            <section id="boxContent">
                <h4><?php echo __('Manage Leads') ?></h4>
<h5><?php echo __('Buying Leads') ?></h5>
<?php foreach ($leads[B2bLeadPeer::B2B_LEAD_BUYING] as $lead): ?>
<?php echo link_to($lead->getDefaultName(), "@edit-lead?hash={$company->getHash()}&lead={$lead->getId()}") ?>
<?php endforeach ?>
<div class="hrsplit-1"></div>
<h5><?php echo __('Selling Leads') ?></h5>
<?php foreach ($leads[B2bLeadPeer::B2B_LEAD_SELLING] as $lead): ?>
<?php echo link_to($lead->getDefaultName(), "@edit-lead?hash={$company->getHash()}&lead={$lead->getId()}") ?>
<?php endforeach ?>

            </section>
        </div>
    </div>
</div>