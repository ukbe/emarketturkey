<?php use_helper('Date') ?>
<table class="data-table extended">
    <thead>
        <tr>
            <th><?php echo __('Member Details') ?></th>
            <th><?php echo __('Activity') ?></th>
            <th><?php echo __('Actions') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $member): ?>
    <tr>
        <td><strong><?php echo link_to($member, $url = $url) ?></strong>
            <?php if (($spec = $member->getSpec(JobSpecPeer::JSPTYP_JOB_FUNCTION)) && ($jf = JobFunctionPeer::retrieveByPK($spec->getSpecId()))): ?>
            <div><?php echo __('Function: ') . link_to($jf, "$route&action=list&$query&jfunc={$jf->getId()}") ?></div>
            <?php endif ?>
            <div class="tagged"><?php echo __('Location&Personel: ') ?>
            <?php if ($member->countJobLocations()): ?>
            <?php foreach ($member->getJobLocations() as $loc): ?>
            <span><?php echo $loc->formatText('@') ?></span>
            <?php endforeach ?>
            <?php else: ?>
            <?php echo __('None') ?>
            <?php endif ?></div>
            </td>
        <td><?php echo link_to(format_number_choice('[0]No applicants|[1]1 applicant|(1,+Inf]%1 applicants', 
                 array('%1' => ($app = $member->countApplicants())), $app), $url()) ?>
             <?php echo ($new=$member->getNewApplicants(true)) ?  link_to(__('%1 new', array('%1' => $new)), $member->getApplicantsUrl(), 'class=redbacked') : '' ?></td>
        <td><?php echo link_to(format_datetime($member->getUpdatedAt('U'), 'D'), $url()) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>