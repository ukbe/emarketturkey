<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th><?php echo __('Member Name') ?></th>
            <th><?php echo __('Activity') ?></th>
            <th><?php echo __('Actions') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $member): ?>
<?php $murl = "@group-members?action=member&hash={$group->getHash()}&mid=" . $member->getPlug() . '&' . $backlink ?>
    <tr>
        <td><?php echo checkbox_tag('member[]', $member->getId()) ?></td>
        <td><?php echo link_to(image_tag($member->getProfilePictureUri()), $url = $member->getProfileUrl()) ?></td>
        <td><?php echo link_to($member->__toString(), $url, 'style=color:#333;') ?></td>
        <td><?php echo link_to($member->getActivityLevelInGroup($group->getId()), $murl) ?></td>
        <td><?php echo link_to(__('View Info'), $murl, 'class=right-arrowed') ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>