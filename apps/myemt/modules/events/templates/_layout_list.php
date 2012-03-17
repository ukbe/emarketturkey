<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Event') ?></th>
            <th><?php echo __('Category') ?></th>
            <th><?php echo __('Published') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $event): ?>
    <tr>
        <td><?php echo link_to(image_tag($event->getLogoUri()), $event->getManageUrl()) ?></td>
        <td><?php echo link_to($event->getName(), $event->getManageUrl()) ?></td>
        <td><?php echo link_to($event->getEventType(), $event->getManageUrl()) ?></td>
        <td><?php echo link_to(time_ago_in_words($event->getCreatedAt('U')), $event->getManageUrl()) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>