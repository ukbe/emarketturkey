<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $user): ?>
    <tr>
        <td><?php echo link_to(image_tag($user->getProfilePictureUri()), $user->getProfileUrl()) ?></td>
        <td><strong><?php echo link_to($user, $user->getProfileUrl()) ?></strong>
            <?php echo count($crr = $user->getCareerLabel()) ? '<em>' . implode('</em><em>', $crr) . '</em>' : '' ?>
            </td>
        <td></td>
        <td><?php echo $user->getLocationLabel() ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>