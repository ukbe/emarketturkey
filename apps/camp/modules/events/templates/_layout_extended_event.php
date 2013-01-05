<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (isset($results) || count($results = $pager->getResults())): ?>
<?php foreach ($results as $event): ?>
    <tr>
        <td><?php echo link_to(image_tag($event->getLogoUri()), $event->getUrl()) ?></td>
        <td><strong><?php echo link_to($event, $event->getUrl()) ?></strong>
            <?php if ($org = $event->getOrganiser()): ?><em><?php echo __('Organiser') . ': ' . $org ?></em><?php endif ?>
            <?php if ($plc = $event->getPlaceText()): ?><em><?php echo __('Location') . ': ' . $plc ?></em><?php endif ?>
            </td>
        <td></td>
        <td><span style="white-space: nowrap;"><?php echo format_datetime($event->getTimeScheme()->getStartDate('U'), 'f') ?></span>
        </td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>