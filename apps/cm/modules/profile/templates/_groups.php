<?php if (count($groups)): ?>
<div class="network-items">
<?php foreach ($groups as $group): ?>
<div class="item span-142">
<div class="hangright">
<?php $m = $user->getGroupMembership($group->getId());
      $matrix = RoleMatrixPeer::retrieveByPK($m->getRoleId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, PrivacyNodeTypePeer::PR_NTYP_USER); ?>
<?php if ($matrix->getBadge()): ?>
<?php echo image_tag('layout/icon/badge/'.$matrix->getBadge(), array('title' => $m->getRole())) ?>
<?php endif ?>
</div>
<div class="logo"><?php echo link_to(image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $group->getProfileUrl()) ?></div>
<div class="info">
<b><?php echo link_to($group->getDisplayName()?$group->getDisplayName():$group, $group->getProfileUrl()) ?></b>
<br /><?php echo $group->getGroupType() ?>
</div>
</div>
<?php endforeach ?>
</div>
<?php else: ?>
<div class="hrsplit-2"></div>
<div class="traditional">
<h3><?php echo __('Not a member of any groups.') ?></h3>
</div>
<?php endif ?>