<table class="sticker">
<tr><td><?php echo link_to(image_tag($user->getProfilePictureUri()), $user->getProfileUrl()) ?></td>
<td><b><?php echo link_to($user, $user->getProfileUrl()) ?></b>
<div class="t_grey margin-t1">
<?php if (isset($user->relevel)): ?>
    <?php if ($user->relevel == 0): ?>
    <?php echo link_to(__('Connect'), "@connect-user?user={$user->getPlug()}", "class=action-button ajax-enabled id=conus-{$user->getPlug()}") ?>
    <?php else: ?>
    <span class="relevel margin-l2"><?php echo $user->relevel ?></span>
    <?php endif ?>
<?php endif ?>
    </div></td></tr>
</table>