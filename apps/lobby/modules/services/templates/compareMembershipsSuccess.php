<div class="col_948">

    <div class="presentation">

    <div class="premium-container">
        <div class="p-border">
        <div class="p-box gold">
            <span class="p-title">
                <?php echo __('Gold Membership') ?>
            </span>
            <span class="p-slogan">
                <?php echo __('Get Verified for Secure Business') ?>
            </span>
            <div class="hrsplit-3"></div>
            <span class="p-price">
                <?php echo __('US$ 2,499') ?>
                <span class="p-period"><?php echo __('per year') ?></span>
            </span>
            <div class="hrsplit-3"></div>
            <?php echo link_to(__('Upgrade to Gold Account'), "@upgrade-gold", 'class=green-button') ?>
            <div class="p-compare gold<?php echo $sf_params->get('act') == 'compare' ? '' : ' ghost' ?>">
                <ul>
                <li><span><?php echo __('emtTrust') ?><sup>®</sup></span><?php echo __('Verified business with emtTrust') ?><sup>®</sup></li>
                <li><span><?php echo __('Priority Listing') ?></span><?php echo __('Gold Members are listed prior to free members in search results and category pages.') ?></li>
                <li><span><?php echo __('Content Translation') ?></span><?php echo __('Automated online content translation for up to %1 languages.', array('%1' => 2)) ?></li>
                <li><span><?php echo __('Job Posting') ?></span><?php echo __('Up to %1 Job Postings.', array('%1' => 5)) ?></li>
                <li><span><?php echo __('Extended Product Listing') ?></span><?php echo __('Gold Members can list up to %1 products.', array('%1' => 50)) ?></li>
                <li><span><?php echo __('TradeExperts') ?></span><?php echo __('On-demand TradeExperts directory listing.') ?></li>
                </ul>
            </div>
        </div>
        </div>

        <div class="p-border">
        <div class="p-box platinum">
            <span class="p-title">
                <?php echo __('Platinum Membership') ?>
            </span>
            <span class="p-slogan">
                <?php echo __('Dedicated Representatives Here for You') ?>
            </span>
            <div class="hrsplit-3"></div>
            <span class="p-price">
                <?php echo __('US$ 3,499') ?>
                <span class="p-period"><?php echo __('per year') ?></span>
            </span>
            <div class="hrsplit-3"></div>
            <?php echo link_to(__('Upgrade to Platinum Account'), "@upgrade-platinum", 'class=green-button') ?>
            <div class="p-compare gold<?php echo $sf_params->get('act') == 'compare' ? '' : ' ghost' ?>">
                <ul>
                <li><span><?php echo __('emtTrust') ?><sup>®</sup></span><?php echo __('Verified business with emtTrust') ?><sup>®</sup></li>
                <li><span><?php echo __('Dedicated Support') ?></span><?php echo __('Get support from Dedicated Professionals for corporate needs.') ?></li>
                <li><span><?php echo __('Priority Listing') ?></span><?php echo __('Platinum Members are listed prior to Gold Members and free members in search results and category pages.') ?></li>
                <li><span><?php echo __('Content Translation') ?></span><?php echo __('Automated online content translation for up to %1 languages.', array('%1' => 4)) ?></li>
                <li><span><?php echo __('Job Posting') ?></span><?php echo __('Up to %1 Job Postings.', array('%1' => 20)) ?></li>
                <li><span><?php echo __('Platinum Job Posting') ?></span><?php echo __('Up to %1 Platinum Job Postings.', array('%1' => 3)) ?></li>
                <li><span><?php echo __('Extended Product Listing') ?></span><?php echo __('Platinum Members can list up to %1 products.', array('%1' => 150)) ?></li>
                <li><span><?php echo __('TradeExperts') ?></span><?php echo __('On-demand TradeExperts directory listing.') ?></li>
                <li><span><?php echo __('Transportation Directory') ?></span><?php echo __('On-demand Transportation Directory listing.') ?></li>
                <li><span><?php echo __('One-Month Targeted Ads') ?></span><?php echo __('Targeted Ads through B2B and Career pages for one month period.') ?></li>
                <li><span><?php echo __('Investment Opportunities') ?></span><?php echo __('Free access to Investment Opportunities directory throughout the membership period.') ?></li>
                </ul>
            </div>
        </div>
        </div>
        <div class="clear<?php echo $sf_params->get('act') == 'compare' ? ' ghost' : '' ?>"><?php echo link_to_function(__('Want to compare Premium Memberships?'), "$('.p-compare').removeClass('ghost'); $('html, body').animate({scrollTop: $('.p-box').first().offset().top-10}, 500); $(this).hide(); ", 'class=inherit-font bluelink hover') ?></div>
        <div class="margin-t2 _left"></div>
        <div class="margin-t2 _right"><em class="ln-example"><?php echo __('* Prices include all additional charges (VAT, etc.)') ?></em></div>
    </div>
    </div>
<style>
div.premium-container { width: 896px; margin: 10px auto 0; border: none; text-align: center; }
.p-header { font: 18px verdana; color: #242424; }
.p-border { width: 408px; padding: 0px 0px 10px 0px; background: url(/images/layout/background/premium-box-bottom.png) no-repeat center bottom; border: none; float: left; margin: 15px; }
.p-box { width: 368px; padding: 256px 20px 20px; position: relative; border: none; float: left; }
.p-box.gold { text-align: right; background: url(/images/layout/background/premium-gold.jpg) no-repeat center top; }
.p-box.platinum { text-align: left; background: url(/images/layout/background/premium-platinum.jpg) no-repeat center top; }
.p-title { height: 42px; padding: 8px 0px; font: bold 22px 'Lucida Grande'; color: #fff; position: absolute; top: 196px; right: 20px; }
.p-slogan { display: block;font: 16px verdana; color: #3f3e3e; }
.p-price { display: block; font: 25px 'Lucida Grande'; color: #626161; }
.p-period { display: block; line-height:17px; height: 17px; font-size: 17px; margin-top: -3px; }
.p-compare { margin-top: 30px; }
.p-compare ul { margin: 0px; padding: 0px; }
.p-compare li { font: 11px arial; color: #666; padding: 4px; border-bottom: solid 1px #f0f0f0; text-align: right; }
.p-compare li span { font: bold 11px tahoma; color: #777; float: left; margin: 0px 10px 10px 0px; }
</style>
</div>