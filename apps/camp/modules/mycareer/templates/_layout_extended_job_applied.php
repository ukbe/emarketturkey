<?php use_helper('Date') ?>
<table class="data-table extended">
<tr>
    <th><?php echo __('Job Post Title') ?></th>
    <th><?php echo __('Employer') ?></th>
    <th><?php echo __('Deadline') ?></th>
    <th><?php echo __('Status') ?></th>
</tr>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $ujob): ?>
<?php $job = $ujob->getJob() ?>
    <tr>
        <td><?php echo $job . link_to('&nbsp;', $job->getUrl(), 'class=popup-link-10px target=blank') ?>
            <?php echo count($tx = $job->getTopSpecsText(true, null)) ? '<span class="clear t_grey margin-t1">'.implode(', ', $tx)."</span>" : "" ?></td>
        <td><?php echo link_to($job->getOwner()->getHRProfile()->getName(), $job->getOwner()->getProfileActionUrl('jobs')) ?></td>
        <td><?php echo format_date($job->getDeadline('U'), 'p') ?></td>
        <td><?php echo link_to(__(UserJobPeer::$statusLabels[$ujob->getStatusId()]), "@myjobs-applied-view?guid={$job->getGuid()}") ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>