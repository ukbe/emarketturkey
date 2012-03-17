<?php use_helper('Date') ?>
<table class="data-table extended">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Event Details') ?></th>
            <th><?php echo __('Organiser') ?></th>
            <th><?php echo __('Start Date') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $event): ?>
    <tr>
        <td><?php echo link_to(image_tag($event->getLogoUri()), $event->getManageUrl()) ?></td>
        <td><strong><?php echo link_to($event->getName(), $event->getManageUrl()) ?></strong>
            <em><?php echo __('Type: ') . link_to($event->getEventType(), "$query&type={$event->getTypeId()}") ?></em>
            <em><?php echo __('Location: ') . ($event->getPlace() ? link_to($event->getPlace()->getLongName(), "$query&place={$event->getPlaceId()}") : $event->getLocationName() . ($event->getGeonameCity() ? ', ' . $event->getGeonameCity()->getName() : '') . ($event->getLocationCountry() ? ', ' . format_country($event->getLocationCountry()) : '')) ?></em>
            </td>
        <td><?php echo $event->getOrganiser() ? link_to($event->getOrganiser(), "$query&org={$event->getOrganiserId()}orgtyp={$event->getOrganiserTypeId()}") : $event->getOrganiserName() ?></td>
        <td><?php echo link_to(format_datetime($event->getTimeScheme()->getStartDate('U'), 'D'), $event->getManageUrl()) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>