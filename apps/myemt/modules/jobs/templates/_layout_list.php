<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th><?php echo __('Ref') ?></th>
            <th><?php echo __('Position') ?></th>
            <th><?php echo __('Applicants') ?></th>
            <th><?php echo __('Status') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $job): ?>
    <tr>
        <td><?php echo link_to($job->getRefCode() ? $job->getRefCode() : 'NA', $url = $job->getManageUrl()) ?></td>
        <td><?php echo link_to($job->__toString(), $url) ?></td>
        <td><?php echo link_to(format_number_choice('[0]No applicants|[1]1 applicant|(1,+Inf]%1 applicants', 
                 array('%1' => ($app = $job->countApplicants())), $app), $job->getApplicantsUrl()) ?>
                 <?php echo ($new=$job->getNewApplicants(true)) ?  link_to(__('%1 new', array('%1' => $new)), $job->getApplicantsUrl(), 'class=redbacked') : '' ?></td>
        <td><?php echo link_to(JobPeer::$typeNames[$job->getStatus()], $url) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>