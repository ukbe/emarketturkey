<?php use_helper('Date') ?>
<?php if (count($companies)): ?>
<div class="network-items span-142">
<?php foreach ($companies as $company): ?>
<div class="item span-142">
<div class="logo"><?php echo link_to(image_tag($company->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $company->getProfileUrl()) ?></div>
<div class="info">
<b><?php echo link_to($company, $company->getProfileUrl()) ?></b>
<br /><?php echo $company->getBusinessSector() ?>
<br /><em><?php echo $company->getBusinessType() ?></em>
</div>
</div>
<?php endforeach ?>
</div>
<?php else: ?>
<div class="hrsplit-2"></div>
<div class="traditional">
<h3><?php echo __('No existing companies in network.') ?></h3>
</div>
<?php endif ?>