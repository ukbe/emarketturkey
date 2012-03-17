<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $lead): ?>
    <tr>
        <td><?php echo ($photo = $lead->getPhotos(1)) ? link_to(image_tag($photo->getThumbnailUri()), $lead->getUrl()) : '' ?></td>
        <td><strong><?php echo link_to($lead, $lead->getUrl()) ?></strong>
            <em><b><?php echo __('Category:')?>&nbsp;</b><?php echo $lead->getProductCategory() ?></em>
            <em><b><?php echo __('Lead Type:')?>&nbsp;</b><?php echo __(B2bLeadPeer::$typeNames[$lead->getTypeId()]) ?></em>
            </td>
        <td>
            <div class="txtCenter">
                <div class="t_smaller t_grey"><?php echo __('Valid by:') ?></div>
                <div class="clndr-leaf" style="display: inline-block">
                    <div><?php echo strtoupper(format_date($lead->getExpiresAt('U'), 'MMMM')) ?></div>
                    <?php echo $lead->getExpiresAt('d') ?>
                </div>
            </div></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>