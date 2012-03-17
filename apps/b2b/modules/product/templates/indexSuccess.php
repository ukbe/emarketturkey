<?php slot('uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<div class="column span-30" style="display: table-cell;text-align: center; vertical-align: middle;">
<?php echo link_to(image_tag($product->getMediumUri(), array('alt' => $product->getDisplayName())), $product->getPictureUri(), array('rel' => 'shadowbox[product-photos]', 'title' => $product->getDisplayName())) ?>
</div>
<div class="hrsplit-1"></div>
<?php $photos = $product->getPhotos() ?>
<?php if (count($photos)>1): ?>
<?php $i = 0 ?>
<?php foreach ($product->getPhotos() as $photo): ?>
<?php if ($i>0): ?>
<div class="column span-12 append-1 divbox">
<?php echo link_to(image_tag($photo->getThumbnailUri(), array('width' => '60', 'alt' => $product->getDisplayName())), $photo->getUri(), array('rel' => 'shadowbox[product-photos]', 'title' => $product->getDisplayName())) ?>
</div>
<?php endif ?>
<?php $i++; ?>
<?php endforeach ?>
<?php endif ?>
<?php end_slot() ?>
<h2><?php echo $product->getDisplayName()!=''?$product->getDisplayName():$product->getName() ?></h2>
<h4><?php echo $product->getProductCategory()->getName() ?></h4>
<p><?php echo str_replace("\n", '<br />', $product->getIntroduction()) ?></p>
<ol class="column span-100">
<li class="column span-23 append-2 first"><?php echo __('Payment Term') ?></li>
<li class="column span-75">
<ul class="column span-74" style="padding-left: 0px;">
<?php foreach ($product->getPaymentTermList() as $pt): ?>
<li class="column span-35 append-2">
<?php echo $pt->getName() ?>
</li>
<?php endforeach ?></ul></li>
<li class="column span-23 append-2 first"><?php echo __('Packaging') ?></li>
<li class="column span-75"><?php echo $product->getPackaging() ?></li>
<li class="column span-23 append-2 first"><?php echo __('Minimum Order') ?></li>
<li class="column span-75"><?php echo $product->getMinimumOrder() ?></li>
</ol>
<?php slot('rightcolumn') ?>
<div class="column span-49">
<h4 style="color: #888888;border-bottom: solid 1px #CCCCCC;padding: 4px;"><?php echo __('Supplier Information') ?></h4>
<div class="pad-1">
<?php echo link_to(image_tag($company->getLogo()?$company->getLogo()->getMediumUri():$company->getProfilePictureUri()), $company->getProfileUrl()) ?>
<h3><?php echo $company->getName() ?>
<?php echo $work_address->getCountry()!=''?image_tag('layout/flag/'.$work_address->getCountry().'.png', array('style' => 'float:right;margin-right:5px;', 'title' => format_country($work_address->getCountry()))):'' ?></h3>
<em><?php echo $company->getBusinessSector() ?></em><br />
<em style="color: #777777;"><?php echo $company->getBusinessType() ?></em><br />
<div class="hrsplit-1"></div>
<em><?php echo link_to(__('Goto Company Profile'), $company->getProfileUrl()) ?></em><br />
<em><?php echo link_to(__('See All Products'), $company->getProfileActionUrl('products')) ?></em>
<div class="hrsplit-2"></div>
<?php echo link_to(image_tag('layout/button/company-profile/contactnow.'.$sf_user->getCulture().'.png'), '@myemt.compose-message') ?></div>
</div>
<div class="hrsplit-1"></div>
<div class="column span-49">
<?php $top_products=$company->getMostViewedProducts() ?>
<?php if (count($top_products)): ?>
<div class="hrsplit-1"></div>
<ol class="span-41">
<li><?php echo image_tag('layout/button/company-profile/most-viewed-products.'.$sf_user->getCulture().'.png') ?></li>
<li><table class="span-41" cellspacing="5" cellpadding="0" border="0">
<?php foreach ($top_products as $top_prod): ?>
<tr><td class="span-5"><?php echo link_to(image_tag($top_prod->getThumbUri(), 'width=30 border=0'), $top_prod->getUrl()) ?></td>
<td style="text-align: left; padding-left: 10px;"><?php echo link_to($top_prod->getDisplayName()!=''?$top_prod->getDisplayName():$top_prod->getName(), $top_prod->getUrl()) ?></td></tr>
<?php endforeach ?></table></li></ol>
<?php endif ?>
<?php echo javascript_tag('Shadowbox.init();') ?>
</div>
<?php end_slot() ?>