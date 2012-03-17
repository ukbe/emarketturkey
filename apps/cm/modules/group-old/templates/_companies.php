<?php use_helper('Date') ?>
<?php if (count($companies)): ?>
<div class="network-items span-142">
<?php foreach ($companies as $company): ?>
<div class="item span-142">
<div class="hangright">
<?php $m = $company->getGroupMembership($group->getId());
      $matrix = RoleMatrixPeer::retrieveByPK($m->getRoleId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, PrivacyNodeTypePeer::PR_NTYP_COMPANY); ?>
<?php if ($matrix->getBadge()): ?>
<?php echo image_tag('layout/icon/badge/'.$matrix->getBadge(), array('title' => $m->getRole())) ?>
<?php endif ?>
</div>
<div class="logo"><?php echo link_to(image_tag($company->getProfilePictureUri()), $company->getProfileUrl()) ?></div>
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
<h3><?php echo __('No existing member companies in the group.') ?></h3>
</div>
<?php endif ?>