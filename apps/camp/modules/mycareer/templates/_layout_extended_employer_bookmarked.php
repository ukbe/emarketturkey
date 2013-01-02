<?php use_helper('Date') ?>
<table class="data-table extended">
<tr>
    <th><?php echo __('Employer') ?></th>
    <th><?php echo __('Type') ?></th>
    <th><?php echo __('Online Jobs') ?></th>
    <th><?php echo __('Remove') ?></th>
</tr>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $book): ?>
<?php $emp = $book->getObject() ?>
    <tr>
        <td><?php echo $emp->getHRProfile()->getName() . link_to('&nbsp;', $emp->getProfileActionUrl('jobs'), 'class=popup-link-10px target=blank') ?></td>
        <td><?php echo PrivacyNodeTypePeer::retrieveByPK($emp->getObjectTypeId()) ?></td>
        <td><?php echo $emp->getOnlineJobs(null, null, true) ?></td>
        <td><?php echo link_to(__('Remove'), $emp->getProfileActionUrl('jobs')."&act=rem&_ref=$_here", 'class=led delete-11px') ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>