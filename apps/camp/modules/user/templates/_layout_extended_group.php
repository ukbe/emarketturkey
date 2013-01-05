<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $group): ?>
    <tr>
        <td><?php echo link_to(image_tag($group->getProfilePictureUri()), $group->getProfileUrl()) ?></td>
        <td><strong><?php echo link_to($group->getName(), $group->getProfileUrl()) ?></strong>
            <em><?php echo $group->getGroupType() ?></em>
            </td>
        <td></td>
        <td><?php echo $group->getLocationLabel() ?>
        <div>
        <?php if (isset($group->relevel)): ?>
            <span class="relevel margin-t2">
            <?php if (isset($group->role_id)): ?><span class="role"><?php echo RolePeer::retrieveByPK($group->role_id) ?></span><?php endif ?>
            </span>
        <?php endif ?></div></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>