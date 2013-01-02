<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $tradeexpert): ?>
    <tr>
        <td><?php echo link_to(image_tag($tradeexpert->getProfilePictureUri()), $tradeexpert->getProfileUrl()) ?></td>
        <td><strong><?php echo link_to($tradeexpert, $tradeexpert->getProfileUrl()) ?></strong>
            <em><strong><?php echo __('Industries: ') ?></strong><?php echo $tradeexpert->getIndustriesText() ?></em>
            <em><strong><?php echo __('Markets: ') ?></strong><?php echo $tradeexpert->getAreasText() ?></em>
            </td>
        <td></td>
        <td><?php echo $tradeexpert->getContact()->getWorkAddress()->getGeonameCity(). ', ' . format_country($tradeexpert->getContact()->getWorkAddress()->getCountry()) . '' ?><div><?php if (isset($tradeexpert->relevel)): ?><span class="relevel margin-l2"><?php echo $tradeexpert->relevel ?></span><?php endif ?></div></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>