<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (isset($results) || count($results = $pager->getResults())): ?>
<?php foreach ($results as $lead): ?>
    <tr>
        <td><?php echo link_to(image_tag($lead->getPictureUri()), $lead->getUrl()) ?></td>
        <td><strong><?php echo link_to($lead, $lead->getUrl()) ?></strong>
            <em><?php echo $lead->getProductCategory() ?></em>
            <div><?php echo $lead->getCompany() ?></div>
            <div><b><?php echo __('Deadline:') ?></b> <?php echo format_date($lead->getExpiresAt('U'), 'D') ?></div>
            </td>
        <td><div class="txtCenter">
                <div class="t_smaller t_grey"><?php echo __('Valid by:') ?></div>
                <div class="clndr-leaf" style="display: inline-block">
                    <div><?php echo strtoupper(format_date($lead->getExpiresAt('U'), 'MMMM')) ?></div>
                    <?php echo $lead->getExpiresAt('d') ?>
                </div>
            </div></td>
        <td><?php echo $lead->getCompany()->getContact()->getWorkAddress()->getGeonameCity(). ', ' . format_country($lead->getCompany()->getContact()->getWorkAddress()->getCountry()) . '' ?><div><?php if (isset($lead->relevel)): ?><span class="relevel margin-l2"><?php echo $lead->relevel ?></span><?php endif ?></div></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>