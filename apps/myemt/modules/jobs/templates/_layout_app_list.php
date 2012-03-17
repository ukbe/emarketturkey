<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th></th>
            <th style="width: 20px;"></th>
            <th><?php echo __('Name Lastname') ?></th>
            <th><?php echo __('Status') ?></th>
            <th><?php echo __('Applied At') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $app): ?>
    <tr<?php echo !$app->getEmployerRead() ? ' class="unread"' : '' ?>>
        <td><?php echo link_to(image_tag($app->getUser()->getResume()->getPhotoUri()), $url = $job->getApplicantUrl($app->getId())) ?></td>
        <td><?php echo $app->getFlagType() ? image_tag(UserJobPeer::$flagTypeIcons[$app->getFlagType()], array('title' => UserJobPeer::$flagTypeNames[$app->getFlagType()])) : '' ?></td>
        <td><?php echo link_to($app->getUser(), $url) ?></td>
        <td><?php echo link_to(__(UserJobPeer::$statTypeNames[$app->getEmployerRead() ? UserJobPeer::UJ_STAT_TYP_READ : UserJobPeer::UJ_STAT_TYP_UNREAD]), $url) ?></td>
        <td><?php echo link_to(format_datetime($app->getCreatedAt('U')), $url) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>