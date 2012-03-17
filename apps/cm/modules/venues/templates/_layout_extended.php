<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (isset($results) || count($results = $pager->getResults())): ?>
<?php foreach ($results as $venue): ?>
    <tr>
        <td><?php echo $venue->getLogo() ? link_to(image_tag($venues->getLogo()->getThumbnailUri()), $venue->getUrl()) : '' ?></td>
        <td><strong><?php echo link_to($venue, $venue->getUrl()) ?></strong>
            <em><?php echo $venue->getPlaceType()?></em>
            </td>
        <td><span style="white-space: nowrap;"><?php echo $venue->getLocationText() ?></span>
        </td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>