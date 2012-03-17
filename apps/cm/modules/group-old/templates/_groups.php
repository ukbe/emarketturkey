<?php use_helper('Date') ?>
<?php if (count($groups)): ?>
<div class="network-items">
<?php foreach ($groups as $group): ?>
<div class="item span-142">
<div class="logo"><?php echo link_to(image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $group->getProfileUrl()) ?></div>
<div class="info">
<b><?php echo link_to($group->getDisplayName()?$group->getDisplayName():$group, $group->getProfileUrl()) ?></b>
<br /><?php echo $group->getGroupType() ?>
</div>
</div>
</div>
<?php endforeach ?>
</div>
<?php else: ?>
<div class="hrsplit-2"></div>
<div class="traditional">
<h3><?php echo __('No existing member groups in the group.') ?></h3>
</div>
<?php endif ?>