<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="breadcrumb">
        <ul>
            <li><?php echo link_to(__('Trade Experts'), '@tradeexperts') ?></li>
            <li><span><?php echo $tradeexpert->__toString() ?></span></li>
        </ul>
    </div>

    <div class="hrsplit-2"></div>

    <div class="col_180">
    <?php if ($tradeexpert->getProfilePicture()): ?>
        <div class="box_180 txtCenter">
            <?php echo link_to_function(image_tag($tradeexpert->getProfilePicture()->getMediumUri()), '') ?>
        </div>
    <?php endif ?>
        <div class="box_180 txtCenter">
            <div class="_noBorder">
                <?php echo like_button($tradeexpert, $_here) ?>
            </div>
        </div>
    </div>
            
    <div class="col_576 b2bProduct">

        <h3 class="pname"><?php echo $tradeexpert->__toString() ?><span class="subinfo"><?php echo $tradeexpert->getHolderTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? __('Corporate') : __('Individual') ?></span></h3>
        <div>
            <?php if ($intro = $tradeexpert->getClob(TradeExpertI18nPeer::INTRODUCTION)): ?>
            <div class="box_576">
                <div class="_noBorder pad-2">
                    <?php echo $intro ?>
                </div>
            </div>
            <?php endif ?>
            <div class="box_576">
                <h4><?php echo __('Industries') ?></h4>
                <div class="_noBorder">
                    <?php if (count($industries)): ?>
                    <div class="two_columns">
                    <?php foreach ($industries as $industry): ?>
                    <div><?php echo $industry->__toString() ?></div> 
                    <?php endforeach ?>
                    </div>
                    <?php else: ?>
                    <p class="t_grey pad-1"><?php echo __('No focused industries.') ?></p>
                    <?php endif ?>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="box_576">
                <h4><?php echo __('Regions') ?></h4>
                <div class="_noBorder">
                    <?php if (count($areas)): ?>
                    <div class="two_columns">
                    <?php foreach ($areas as $area): ?>
                    <div><?php echo $area->__toString() ?></div> 
                    <?php endforeach ?>
                    </div>
                    <?php else: ?>
                    <p class="t_grey pad-1"><?php echo __('No focused regions.') ?></p>
                    <?php endif ?>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if (count($clients)): ?>
            <div class="hrsplit-2"></div>
            <div class="box_576 _titleBG_White">
                <h3><?php echo __('Select Clients') ?></h3>
                <div>
                    <div class="four_columns">
                    <?php foreach ($clients as $client): ?>
                        <div class="txtCenter"><?php echo link_to(image_tag($client->getClient()->getProfilePictureUri(), array('title' => $client->getClient()->__toString())), $client->getClient()->getProfileUrl()) ?></div> 
                    <?php endforeach ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>

    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
        </div>
    </div>

</div>