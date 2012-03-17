<?php use_helper('Date') ?>
<table class="data-table extended job-search-result">
<tr>
    <th class="date"><span></span></th>
    <th><?php echo __('Job Post Title') ?></th>
    <th><?php echo __('Employer') ?></th>
    <th><?php echo __('Location') ?></th>
    <th><?php echo __('Specs') ?></th>
</tr>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $job): ?>
    <tr>
        <td class="date">
            <div class="clndr-leaf">
                <div><?php echo strtoupper(format_date($job->getPublishedOn('U'), 'MMM')) ?></div>
                <?php echo $job->getPublishedOn('d') ?>
            </div>
        </td>
        <td class="job-title"><?php echo link_to($job, $job->getUrl()) ?></td>
        <td class="employer-name"><?php echo link_to($job->getOwner()->getHRProfile()->getName(), $job->getOwner()->getProfileActionUrl('jobs')) ?></td>
        <td class="location"><?php echo $job->getLocationString() ?></td>
        <td class="specs"></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items t_larger"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>