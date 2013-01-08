<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="col_657 clear _center">
        <div class="box_657">
            <h4><?php echo __('Application Received') ?></h4>
            <div class="pad-3 _noBorder">
            <h1><?php echo __('Thank You!') ?></h1>
            <?php echo __('Your Trade Experts application was successfully received. We will evaluate your application and take necessary steps very soon.') ?>
            <div class="hrsplit-3"></div>
            <b><?php echo __('Applied as: <span class="t_green">%1</span>', array('%1' => $account)) ?></b>
            <div class="hrsplit-3"></div>
            <ul class="sepdot">
                <li><?php echo link_to(__('Go to B2B Homepage'), '@homepage', 'class=bluelink hover') ?></li>
                <li><?php echo link_to(__('Find Trade Experts'), '@tradeexperts-action?action=find', 'class=bluelink hover') ?></li>
                <li><?php echo link_to(__('Go to MyEMT'), '@myemt.homepage', 'class=bluelink hover') ?></li>
                </ul>
            </div>
        </div>

    </div>

</div>