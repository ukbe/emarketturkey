<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (isset($results) || count($results = $pager->getResults())): ?>
<?php foreach ($results as $att): ?>
    <tr>
        <td><?php echo link_to(image_tag($att->getSubject()->getProfilePictureUri()), $att->getSubject()->getProfileUrl()) ?></td>
        <td><strong><?php echo __('%1 is attending %2', array('%1' => link_to($att->getSubject(), $att->getSubject()->getProfileUrl()), '%2' => link_to($att->getEvent(), $att->getEvent()->getUrl()))) ?></strong>
            <?php if ($org = $att->getEvent()->getOrganiser()): ?><em><?php echo __('Organiser') . ': ' . $org ?></em><?php endif ?>
            <?php if ($plc = $att->getEvent()->getPlaceText()): ?><em><?php echo __('Location') . ': ' . $plc ?></em><?php endif ?>
            </td>
        <td></td>
        <td><span style="white-space: nowrap;"><?php echo format_datetime($att->getEvent()->getTimeScheme()->getStartDate('U'), 'f') ?></span>
        </td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>