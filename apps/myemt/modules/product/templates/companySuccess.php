<div class="column span-198">
<div class="column">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to($company->getName(), $company->getProfileUrl()) ?></li>
<li class="last"><?php echo __('Products') ?></li>
</ol>
</div>
<ol class="column command-menu">
<li></li>
</ol>
<ol class="inline-form">
<li></li></ol>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('product/leftmenuCompany', array('company' => $company)) ?>
<div class="column span-107 append-1">
<div class="column span-105 prepend-1 append-1">
<h2><?php echo $company->getName() ?></h2>
<h4><?php echo $company->getBusinessSector() ?></h4>
<p><?php echo $company->getCompanyProfile()->getProductService() ?></p>
<?php if (count($products)): ?>
<div class="column span-104"><?php echo image_tag('layout/button/company-profile/products.'.$sf_user->getCulture().'.png') ?></div>
<div class="hrsplit-1"></div>
<ol class="column span-104 product-spot">
<?php foreach ($products as $product): ?>
<li class="column span-10 pad-1 append-1"><?php echo link_to(image_tag($product->getThumbUri(), 'width=40 border=0'), $product->getUrl()) ?><br /><?php echo link_to($product->getDisplayName(), $product->getUrl()) ?></li>
<?php endforeach ?>
</ol>
<?php endif ?>
</div></div>
<div class="column span-49 last">
<div class="column span-49 divbox">
<div class="inside">
</div>
</div>
</div>