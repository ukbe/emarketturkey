<div class="column span-198">
<div class="column">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to($company->getName(), $company->getProfileUrl(), array('title' => __("%1 Profile", array('%1' => $company->getName())))) ?></li>
<li><?php echo link_to(__('Products'), 'product/company?id='.$company->getId()) ?></li>
<li class="last"><?php echo $product->getDisplayName() ?></li>
</ol>
</div>
<ol class="column command-menu">
<li></li>
</ol>
<ol class="inline-form">
<li></li></ol>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('product/leftmenu') ?>
<div class="column span-107 append-1">
<div class="column span-105 prepend-1 append-1">
<h2><?php echo $product->getDisplayName() ?></h2>
<h4><?php echo $product->getProductCategory()->getName() ?></h4>
<p><?php echo $product->getClob(ProductI18nPeer::INTRODUCTION) ?></p>
<ol class="column span-100">
<li class="column span-23 append-2 first"><?php echo __('Payment Term') ?></li>
<li class="column span-75"><?php echo $product->getPaymentTerm()->getCode().' - '. $product->getPaymentTerm()->getName() ?></li>
<li class="column span-23 append-2 first"><?php echo __('Packaging') ?></li>
<li class="column span-75"><?php echo $product->getPackaging() ?></li>
<li class="column span-23 append-2 first"><?php echo __('Minimum Order') ?></li>
<li class="column span-75"><?php echo $product->getMinimumOrder() ?></li>
</ol>
</div></div>
<div class="column span-49 last">
<div class="column span-49 divbox">
<div class="inside">
</div>
</div>
</div>