<div class="col_948">

    <div class="presentation">
        
    <div class="premium-container">
        <h1><?php echo $campaign->getDisplayName() ?></h1>
    </div>

    <div class="spot-split">        
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
                <strike><small><?php echo __('2.500 TL + KDV') ?></small></strike><br />
                <large class="t_green"><?php echo __('1.750 TL + KDV') ?></large>
                <span class="p-period"><?php echo __('per year') ?></span>
            </span>
            <div class="hrsplit-3"></div>
            <?php echo link_to(__('Apply for Gold Account'), "@upgrade-gold?cid={$campaign->getCode()}", 'class=green-button') ?>
            <div class="p-compare gold<?php echo $sf_params->get('act') == 'compare' ? '' : ' ghost' ?>">
                <ul>
                <li><span><?php echo __('emtTrust') ?><sup>®</sup></span><?php echo __('Verified business with emtTrust') ?><sup>®</sup></li>
                <li><span><?php echo __('Priority Listing') ?></span><?php echo __('Gold Members are listed prior to free members in search results and category pages.') ?></li>
                <li><span><?php echo __('Content Translation') ?></span><?php echo __('Automated online content translation for up to %1 languages.', array('%1' => 2)) ?></li>
                <li><span><?php echo __('Job Posting') ?></span><?php echo __('Up to %1 Job Postings.', array('%1' => 5)) ?></li>
                <li><span><?php echo __('Extended Product Listing') ?></span><?php echo __('Gold Members can list up to %1 products.', array('%1' => 50)) ?></li>
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
                <strike><small><?php echo __('5.000 TL + KDV') ?></small></strike><br />
                <large class="t_green"><?php echo __('3.500 TL + KDV') ?></large>
                <span class="p-period"><?php echo __('per year') ?></span>
            </span>
            <div class="hrsplit-3"></div>
            <?php echo link_to(__('Apply for Platinum Account'), "@upgrade-platinum?cid={$campaign->getCode()}", 'class=green-button') ?>
            <div class="p-compare gold<?php echo $sf_params->get('act') == 'compare' ? '' : ' ghost' ?>">
                <ul>
                <li><span><?php echo __('emtTrust') ?><sup>®</sup></span><?php echo __('Verified business with emtTrust') ?><sup>®</sup></li>
                <li><span><?php echo __('TradeExperts') ?></span><?php echo __('Marketing support from global TradeExperts.') ?></li>
                <li><span><?php echo __('Priority Listing') ?></span><?php echo __('Platinum Members are listed prior to Gold Members and free members in search results and category pages.') ?></li>
                <li><span><?php echo __('Content Translation') ?></span><?php echo __('Automated online content translation for up to %1 languages.', array('%1' => 4)) ?></li>
                <li><span><?php echo __('Job Posting') ?></span><?php echo __('Up to %1 Job Postings.', array('%1' => 20)) ?></li>
                <li><span><?php echo __('Platinum Job Posting') ?></span><?php echo __('Up to %1 Platinum Job Postings.', array('%1' => 3)) ?></li>
                <li><span><?php echo __('Extended Product Listing') ?></span><?php echo __('Platinum Members can list up to %1 products.', array('%1' => 150)) ?></li>
                <li><span><?php echo __('Dedicated Support') ?></span><?php echo __('Get support from Dedicated Professionals for corporate needs.') ?></li>
                <li><span><?php echo __('One-Month Targeted Ads') ?></span><?php echo __('Targeted Ads through B2B and Career pages for one month period.') ?></li>
                <li><span><?php echo __('Investment Opportunities') ?></span><?php echo __('Free access to Investment Opportunities directory throughout the membership period.') ?></li>
                </ul>
            </div>
        </div>
        </div>
        <div class="clear<?php echo $sf_params->get('act') == 'compare' ? ' ghost' : '' ?>"><?php echo link_to_function(__('Want to compare Premium Memberships?'), "$('.p-compare').removeClass('ghost'); $('html, body').animate({scrollTop: $('.p-box').first().offset().top-10}, 500); $(this).hide(); ", 'class=bluelink t_large hover') ?></div>

    </div>
    <div class="hrsplit-3"></div>
    </div>

    <div class="hrsplit-3"></div>

    <div class="boxContent _noTitle noBorder">
        <q class="_center">
            <?php echo __('Premium Services provide you a wide range of business opportunities which improves your reachability and profitability.') ?>
        </q>
        <dl class="_table large p_dgrey">
            <dt><?php echo image_tag('emttrust-logotype.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('Prove your Reliability with emtTrust') ?><sup>®</sup></h2>
                <p><?php echo __('A Premium Member is verified at their business location prior to the confirmation of its eligibility. emtTrust, provides eMarketTurkey sellers and buyers protect themselves from fraudulent quotations.') ?></p>
            </dd>
            <dt><?php echo image_tag('tradeexperts-logotype.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('Marketing Support from global TradeExperts') ?><sup>®</sup></h2>
                <p><?php echo __("Platinum Members receive marketing support from eMarketTurkey's global TradeExperts. This will allow your products get promoted by industry professionals around the world.") ?></p>
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
            <dt><?php echo image_tag('layout/badges/ekonomi-logo.png') ?></dt>
            <dd style="width: 700px;"><h2><?php echo __('eMarketTurkey is pre-approved by Turkish Ministry of Economics') ?></h2>
                <p><?php echo __('eMarketTurkey has been pre-approved by Republic of Turkey Ministry of Economics. Ministry of Economics yields grants to Turkish Companies in order to improve online presence of Turkish Companies.') ?></p>
            </dd>
        </dl>
    </div>

    <div class="hrsplit-3"></div>

    <div class="premium-container">
    
        <div id="accordion" class="clear" style="text-align: left;">
          <h2>
            <span class="_right t_grey"><?php echo __('click to open') ?></span>
            <?php echo __('Check out the tax advantages provided via Government Grants') ?></h2>
          <div style="display: none;">
              <p class="pad-2">
              <?php echo __('eMarketTurkey is pre-approved by Republic of Turkey Ministry of Economics. The tax advantages plus state grant provides an additional contribution to your budget.') ?>
              </p>
              <div class="two_columns">
                <div style="width: 428px; margin-right: 10px;">
                    <h4><?php echo __('Gold Membership') ?></h4>
                    <table class="plan" cellspacing="0" cellpadding="0">
                    <tr><th><?php echo __('Invoiced Amount (%1amount)', array('%1amount' => '1.750,00 TL + KDV')) ?></th><td class="t_red">2.065,00 TL</td></tr>
                    <tr><th><?php echo __('State Grant (%1amount)', array('%1amount' => __('Taxed Amount &times; %1ratio', array('%1ratio' => '%70')))) ?></th><td class="t_green">1.445,50 TL</td></tr>
                    <tr><th><?php echo __('VAT Advantage') ?></th><td class="t_green">315,00 TL</td></tr>
                    <tr><th><?php echo __('Income Tax Advantage') ?></th><td class="t_green">350,00 TL</td></tr>
                    <tr class="sum"><th><?php echo __('Overall Budget Cost') ?></th><td class="t_green">+45,50 TL</td></tr>
                    </table>
                </div>
                <div style="width: 428px;">
                    <h4><?php echo __('Platinum Membership') ?></h4>
                    <table class="plan" cellspacing="0" cellpadding="0">
                    <tr><th><?php echo __('Invoiced Amount (%1amount)', array('%1amount' => '3.500,00 TL + KDV')) ?></th><td class="t_red">4.130,00 TL</td></tr>
                    <tr><th><?php echo __('State Grant (%1amount)', array('%1amount' => __('Taxed Amount &times; %1ratio', array('%1ratio' => '%70')))) ?></th><td class="t_green">2.891,00 TL</td></tr>
                    <tr><th><?php echo __('VAT Advantage') ?></th><td class="t_green">630,00 TL</td></tr>
                    <tr><th><?php echo __('Income Tax Advantage') ?></th><td class="t_green">700,00 TL</td></tr>
                    <tr class="sum"><th><?php echo __('Overall Budget Cost') ?></th><td class="t_green">+91,00 TL</td></tr>
                    </table>
                </div>
              </div>

              <div class="hrsplit-2"></div>

              <em class="ln-example"><?php echo __("Our Customer Relations staff provides consultancy on your application to government's e-Trade Website Membership Grant.") ?></em>
          </div>
        </div>
    </div>
    </div>
    
<?php echo javascript_tag("
$('#accordion h2').click(function(){ var j = this; $('#accordion > h2 > span').fadeToggle('fast'); $('#accordion > div').slideToggle('fast', function(){ $(j).toggleClass('active'); }); });
") ?>

</div>
<style>

h1 { font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; font-size: 26px; line-height: 30px; color: #454545; }
div.premium-container { width: 896px; margin: 10px auto 0; border: none; text-align: center; }
.p-header { font: 18px verdana; color: #242424; }
.p-border { width: 408px; padding: 0px 0px 10px 0px; background: url(/images/layout/background/premium-box-bottom.png) no-repeat center bottom; border: none; float: left; margin: 15px; }
.p-box { width: 368px; padding: 256px 20px 20px; position: relative; border: none; float: left; }
.p-box.gold { text-align: right; background: url(/images/layout/background/premium-gold.jpg) no-repeat center top; }
.p-box.platinum { text-align: left; background: url(/images/layout/background/premium-platinum.jpg) no-repeat center top; }
.p-title { height: 42px; padding: 8px 0px; font: bold 22px 'Lucida Grande'; color: #fff; position: absolute; top: 196px; right: 20px; }
.p-box.platinum .p-title { left: 20px; }
.p-slogan { display: block;font: 16px verdana; color: #3f3e3e; }
.p-price { display: block; font: 25px 'Lucida Grande'; color: #626161; }
.p-period { display: block; line-height:17px; height: 17px; font-size: 17px; margin-top: -3px; }
.p-compare { margin-top: 30px; }
.p-compare ul { margin: 0px; padding: 0px; }
.p-compare li { font: 11px arial; color: #666; padding: 4px; border-bottom: solid 1px #f0f0f0; text-align: right; }
.p-compare li span { font: bold 11px tahoma; color: #777; float: left; margin: 0px 10px 10px 0px; }

#accordion { font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; font-size: 14px; line-height: 18px; color: #333333; }
#accordion h2 { background-color: #f3f3f3; cursor: pointer; padding: 10px 14px; border: solid 1px #d8d8d8; border-radius: 6px; font-size: 16px; line-height: 16px; }
#accordion h2.active { background-color: #f6f6f6; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px; border-color: #c8c8c8; }
#accordion h2:hover { background-color: #f0f0f0; }
#accordion > div { background-color: #fbfbfb; padding: 14px; border: solid 1px #c8c8c8; border-top: none; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; overflow: auto; }

table.plan { background-color: #f9f9f9; font-family: arial; font-size: 14px; width: 100%; margin: 0px; padding: 0px; }
table.plan th, table.plan td { padding: 8px 12px; font-weight: normal; border-bottom: solid 1px #f1f1f1; }
table.plan td { text-align: right; }
table.plan tr.sum { background-color: #f5f5f5; }
table.plan tr.sum th, table.plan tr.sum td { font-weight: bold; }

.p_dgrey p { color: #777; }
.presentation { position: relative; }
.presentation .spot-split { display: block; margin: -6px; border-top: solid 2px #eaeaea; border-bottom: solid 1px #eaeaea; background-color: #f7f7f7; }
.presentation hr.spot-split { display: block; margin: 0px -6px; background-color: #f0f0f0; height: 1px; padding: 0px; line-height: 1px; }
._table.large { width: 900px; margin-left: 40px; margin-right: 10px; }
</style>