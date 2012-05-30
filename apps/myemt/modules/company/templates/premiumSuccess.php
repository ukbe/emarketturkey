<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948 presentation">

    <div class="boxContent tabs">

        <dl class="_premium-services" style="display: block; ">
            <dt><?php echo __('Premium Services') ?></dt>
            <dd>
                <?php echo __('Take your business to the level it deserves.') ?>
            </dd>
        </dl>

    </div>    
    <div class="hrsplit-3"></div>
    
    <div class="boxContent _noTitle noBorder">
        <q>
            <?php echo __('Premium Services provide you a wide range of business opportunities which improves your reachability and profitability.') ?>
        </q>
        <dl class="_table">
            <dt><?php echo image_tag('layout/icon/large/medal_blue.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('Prove your Reliability with emtTrust') ?><sup>®</sup></h2>
                <p><?php echo __('A Premium Member is verified at their business location prior to the confirmation of its eligibility. emtTrust, provides eMarketTurkey sellers and buyers protect themselves from fraudulent quotations.') ?></p>
            </dd>
            <dt><?php echo image_tag('layout/icon/large/search_blue.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('Better reachability performance') ?></h2>
                <p><?php echo __('Premium Service members have a higher reachability score than other members. Because, Premium Service members are listed prior to other members in search results and category pages. As a result of this potential customers will find you more easily and contact you more frequently.') ?></p>
            </dd>
            <dt><?php echo image_tag('layout/icon/large/chart-up_green.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('The very first step for more profitable connections') ?></h2>
                <p><?php echo __('eMarketTurkey provides valued trading services to its Premium Members. Some of these services include; <b>Buyer-Seller Matching</b>, <b>Marketing Support</b>, <b>Regional Market Research</b>, <b>Remote Product Audit</b>, etc.. Premium Services, reduces operational costs of organisations on global trade tasks.') ?></p>
            </dd>
            <dt><?php echo image_tag('layout/icon/large/shapes_blue.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('Wide Range of Business Services in one place') ?></h2>
                <p><?php echo __('We provide a group of Business Services to our valued Premium Members. By upgrading to Premium Services, members get service packages like emtTrust, Job Posts, Online Translation Service, Unlimited Product Listing, CV Database Search, etc..') ?></p>
            </dd>
            <dt><?php echo image_tag('layout/icon/large/user_yellow.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('Professional support by a Corporate Representative dedicated to your Company') ?></h2>
                <p><?php echo __('Premium Members have an advantage of getting direct support from an eMarketTurkey Corporate Representative on any topic like; Performing Negotiations with Buyers/Sellers, Getting Trading Support Services, etc..') ?></p>
            </dd>
            <dt></dt>
            <dd style="width: 700px;">
                <p><?php echo link_to(__('You may compare Premium Account types here.'), "@company-account?action=upgrade&act=compare&hash={$company->getHash()}", 'class=inherit-font bluelink hover') ?></p>
            </dd>
        </dl>
        <div class="clear txtCenter">
            <?php echo link_to(__('Upgrade to Premium Account'), "@company-account?action=upgrade&hash={$company->getHash()}", 'class=green-button') ?>
        </div>
    </div>
</div>
