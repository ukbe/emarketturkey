<ol class="column span-39">
<?php $fc = 0; ?>
<?php foreach ($members as $members): ?>
<?php $fc++; if ($fc>6) continue;  ?>
<?php if ($user->can(ActionPeer::ACT_VIEW_PROFILE, $member)): ?>
<li class="<?php echo ($fc % 4 == 0)?"first ":""  ?>column span-12" style="text-align:center;"><?php echo link_to(image_tag($member->getProfilePictureUri()), $member->getProfileUrl()) ?><br /><?php echo link_to($member, $member->getProfileUrl()) ?></li>
<?php else: ?>
<li class="<?php echo ($fc % 4 == 0)?"first ":""  ?>column span-12" style="text-align:center;"><?php echo image_tag($member->getProfilePictureUri()) ?><br /><?php echo $member ?></li>
<?php endif ?>
<?php endforeach ?>
</ol>