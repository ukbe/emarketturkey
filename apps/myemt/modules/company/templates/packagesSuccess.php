<?php use_helper('Number') ?>
<?php slot('mappath') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php end_slot() ?>
<?php slot('rightcolumn') ?>
<?php end_slot() ?>

<div class="column span-153">
<h1 style="font-family: verdana;"><?php echo __('%1 Packages', array('%1' => $service->getName())) ?></h1>
<div class="hrsplit-3"></div>
<style>
.packtab {
width: 100%;
padding: 5px;
border: solid 1px #888888;
}
.packtab th {
background-color: #93037D; color: #FFFFFF; font: 18px verdana;padding: 10px 20px;margin: 0px 0px 0px 10px;
}
.packtab td {
border-bottom: solid 1px #888888; padding: 10px 20px; height: 30px;
}
.packtab td input {
margin: 0 auto;
display: block;
}
</style>
<table class="packtab" cellpadding="0" cellspacing="0">
<tr>
<th class="span-25" style=""><?php echo __('Package') ?></th>
<th class="span-25"><?php echo __('Content') ?></th>
<th class="span-25"><?php echo __('Price') ?></th>
<th class="span-25" style="text-align: center;"><?php echo __('Select') ?></th>
</tr>
<?php foreach ($packages as $package): ?>
<tr>
<td class="span-25"><b><?php echo $package->getName() ?></b></td>
<td class="span-25">
<?php foreach ($package->getMarketingPackageItems() as $pitem): ?>
<?php echo $pitem->getQuantity() . ' x ' . $pitem->getService()->getName()  ?><br />
<?php endforeach ?>
</td>
<td class="span-25">
<?php echo format_currency($package->getPriceFor($company)->getPrice(), $package->getPriceFor($company)->getCurrency()) ?>
</td>
<td class="span-25">
<?php echo radiobutton_tag('selectpackage', $package->getId(), false) ?>
</td>
</tr>
<?php endforeach ?>
</table>
</div>