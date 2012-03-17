

<div class="column">
<?php echo link_to('&nbsp;', '@lobby.homepage', array('class' => 'home', 'title' => __('Go to eMarketTurkey Home'))) ?>
</div>
<div style="text-align: center;">
<h1><?php echo __('Advertise on ') ?><?php echo image_tag('emtlogo.gif', array('width' => '150', 'style' => 'vertical-align:middle; margin: 0px 0px 10px 10px;')) ?></h1>
<div class="hrsplit-1"></div>
<?php echo __('Perfect place for international business promotions.') ?>
</div>
<style>
a.home {background: url(/images/layout/icon/home-grey.png) no-repeat; width: 31px; height: 29px; display: block;text-decoration: none;}
a.home:hover {background: url(/images/layout/icon/home-black.png)}
.tabs {text-align: center; padding: 10px 10px; height: 135px; vertical-align: middle;}
ol li a {border: solid 1px #DEDEDE; background-color: #F8F8F8; padding: 6px 10px 8px 10px; font: 12pt 'georgia'; color: #000000; text-decoration: none;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
}
ol li a.selected {background-color: #496181; color: #FFFFFF; border-color: #496181;}
</style>
<div style="height: 30px;"></div>
<div class="column" style="text-align: center; width: 100%;">
<ol id="links" style="margin: 0px; padding: 0px; display: inline-block;text-align: center;">
<li class="column append-2"><?php echo link_to_function(__('Overview'), "setTab(1);") ?></li>
<li class="column"><?php echo link_to_function(__('Quote'), "setTab(2);") ?></li>
</ol>
</div>
<div class="hrsplit-1"></div>
<div style="border: solid 2px #E8E7E7; width: 100%; text-align: center; float: left;">
<div class="tabs tab-1 ghost">
<ol class="column span-191">
<li class="column span-40">
<?php echo image_tag('content/ad/ads.png', 'width=200') ?>
</li>
<li class="column span-60"><?php echo __('Advertising on eMarketTurkey Overview') ?>
</li>
</ol>
</div>
<div class="tabs tab-2 ghost">
<?php echo __('Request quotation') ?>
</div>
<div class="hrsplit-1"></div>
</div>
<?php echo javascript_tag("
var opts = ".array_or_string_for_javascript(array()).";
function setTab(x)
{
    jQuery('.tabs').hide();
    jQuery('#links a').removeClass('selected');
    jQuery('.tab-'+x).show();
    jQuery('#links li:nth-child('+x+') a').addClass('selected');
} 
setTab(1);
    "); ?>