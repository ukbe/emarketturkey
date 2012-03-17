<div class="column span-196 pad-2">
<h1><?php echo __('Directory Service') ?></h1>
<div class="column span-140 append-2" style="height: 300px;">
<p>
<!--
<?php echo __("eMarketTurkey Directory Service allows companies promote their products and services 
worldwide. By publishing the product and service informations, supplier companies 
provide 7x24 access for buyers.") ?>
</p>
<p>
<?php echo __("Directory Service includes company profile page and product pages. Gold and Premium Members 
take advantage of unlimited product listings while free members can only list a limited number of 
products. Buyers and other public visitors around the world will have the opportunity to view 
company profiles and product informations and access supplier companies for free.") ?>
-->
</p>

<p>
<?php echo __("eMarketTurkey covering all sectors and companies can promote their products and services on the Internet is a versatile trading platform. We provide opportunities to the companies viewed  in different languages and can be reached around the world. Customizable profile pages enables to create  detailed informations about institutions, products and services.EmarketTurkey's addvertising  power not only to foreign markets, it is achieving new goals and value-added services in domestic markets.") ?> 
</p><p>
<h3><?php echo __("Multi Language Support") ?> </h3>
<?php echo __("Multiple Language Support is license and required that registered companies can publish their products and services in many different languages. Companies can determine their interpreters to translate corporation and product informations into different languages or eMarketTurkey takes care of your translations with a few clicks.") ?>   
</p><p>
<h3><?php echo __("Unlimited Product Listing") ?></h3>
<?php echo __("eMarketTurkey determined limits on products and services to save for free members, if our members will demand to continue and if they don't need our other services, Unlimited Product Listing License is required for your usage.") ?>  
</p><p>
<h3><?php echo __("Get Listed In The Front") ?></h3>
<?php echo __("When our visitors or members make searchs in eMarketTurkey, all products, services, buy-sell ads and other informations of Gold and Premium members list primarily") ?>   
</p><p>
<h3><?php echo __("Multimedia  Upload") ?> </h3>
<?php echo __("Companies prepare their efficient presentations with videos, product catalogs, price lists, etc. So that the institutions or firms can create more richer profiles pages.") ?> 
</p><p>


</div>
<div class="column span-49 pad-2 divbox">
<h2><?php echo __('Start using!') ?></h2>
<ol class="column span-48 pad-1">
<li class="column span-48">
<?php echo link_to(__('Register your company, if you have not done yet.'), '@signup', array('query_string' => 'keepon='.url_for('@myemt.register-comp'))) ?></li>
<li class="column span-48">
<?php echo link_to(__('Publish your products, if you have already registered your company.'), '@myemt.manage-products') ?></li>
</ol> 
</div>
</div>