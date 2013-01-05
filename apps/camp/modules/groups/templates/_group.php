<table class="sticker">
<tr><td><?php echo $group->getLogo() ? link_to(image_tag($group->getLogo()->getThumbnailUri()), $group->getProfileUrl()) : "" ?></td>
<td><b><?php echo link_to($group->getName(), $group->getProfileUrl()) ?></b>
<div class="t_grey margin-t1"><?php echo $group->getGroupType() ?>
    <?php if (isset($group->relevel)): ?><span class="relevel margin-l2"><?php echo $group->relevel ?></span><?php endif ?>
    </div></td></tr>
</table>