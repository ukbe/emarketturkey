<?php use_helper('Number') ?>
<ul class="selectplan">
<?php $packs = array() ?>
<?php $packs[1] = MarketingPackagePeer::getPackageFor(ServicePeer::STYP_ACCESS_CV_DB, $cus_type_id, 100) ?>
<?php $packs[2] = MarketingPackagePeer::getPackageFor(ServicePeer::STYP_ACCESS_CV_DB, $cus_type_id, 500) ?>
<?php $packs[3] = MarketingPackagePeer::getPackageFor(ServicePeer::STYP_ACCESS_CV_DB, $cus_type_id, 1500) ?>
<?php $seeds = array() ?>
<?php foreach ($packs as $key => $pack): ?>
<?php $seeds[$key] = SecretHub::impl($cus_type_id, $cus_id, $pack->getGuid()) ?>
<?php endforeach ?>
<?php $secrets = SecretHub::issue($seeds) ?>
<?php if (isset($packs[1])): ?>
<li class="box">
    <h5><?php echo __('Starter') ?></h5>
    <span class="highlight"><?php echo __('%1 credits', array('%1' => 100)) ?></span>
    <ul>
        <li><?php echo __('Best for low-demand needs.') ?></li>
        <li><?php echo __('Wanna try? This is what you are looking for.') ?></li>
        </ul>
    <?php $price = $packs[1]->getPriceFor($cus_type_id) ?>
    <span class="price"><?php echo format_currency($price->getPrice(), $price->getCurrency()) ?></span>
    <?php echo link_to(__('Select'), "$add_route&pckid={$packs[1]->getGuid()}&sec={$secrets[1]}", "class=picker") ?>
    </li>
<?php endif ?>
<?php if ($packs[2]): ?>
<li class="box pick-me">
    <h5><?php echo __('Standart') ?></h5>
    <span class="highlight"><?php echo __('%1 credits', array('%1' => 500)) ?></span>
    <ul>
        <li><?php echo __('Best for average users.') ?></li>
        <li><?php echo __("Should meet Small and medium companies' needs.") ?></li>
        </ul>
    <?php $price = $packs[2]->getPriceFor($cus_type_id) ?>
    <span class="price"><?php echo format_currency($price->getPrice(), $price->getCurrency()) ?></span>
    <?php echo link_to(__('Select'), "$add_route&pckid={$packs[2]->getGuid()}&sec={$secrets[2]}", "class=picker") ?>
    </li>
<?php endif ?>
<?php if ($packs[3]): ?>
<li class="box pro">
    <h5><?php echo __('Professional') ?></h5>
    <span class="highlight"><?php echo __('%1 credits', array('%1' => 1500)) ?></span>
    <ul>
        <li><?php echo __('Suitable for recruitment organisations and large companies.') ?></li>
        <li><?php echo __('Frequent needs.') ?></li>
        </ul>
    <?php $price = $packs[3]->getPriceFor($cus_type_id) ?>
    <span class="price"><?php echo format_currency($price->getPrice(), $price->getCurrency()) ?></span>
    <?php echo link_to(__('Select'), "$add_route&pckid={$packs[3]->getGuid()}&sec={$secrets[3]}", "class=picker") ?>
    </li>
<?php endif ?>
</ul>