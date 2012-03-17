<?php use_helper('Date') ?>
<table class="data-table extended">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Job Details') ?></th>
            <th></th>
            <th><?php echo __('Applied At') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $app): ?>
    <tr>
        <td><?php echo link_to(image_tag($app->getUser()->getResume()->getPhotoUri()), $url = $job->getApplicantUrl($app->getId())) ?></td>
        <td><strong><?php echo link_to($app->getUser(), $url) ?>
            <?php echo $app->getFlagType() ? image_tag(UserJobPeer::$flagTypeIcons[$app->getFlagType()], array('title' => UserJobPeer::$flagTypeNames[$app->getFlagType()])) : '' ?></strong></td>
        <td><?php echo !$app->getEmployerRead() ? link_to(__('new'), $url, 'class=redbacked') : '' ?></td>
        <td><?php echo link_to(format_datetime($app->getCreatedAt('U')), $url) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>