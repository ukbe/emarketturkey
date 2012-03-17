<?php use_helper('Date') ?>
<table class="data-table extended">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Lead Details') ?></th>
            <th><?php echo __('') ?></th>
            <th><?php echo __('Published') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $lead): ?>
    <tr>
        <td><?php echo link_to(image_tag($lead->getThumbUri()), $lead->getEditUrl()) ?></td>
        <td><strong><?php echo link_to($lead->getName($lead->getDefaultLang()), $lead->getEditUrl()) ?></strong>
            <em><?php echo __('Category: ') . link_to($lead->getProductCategory(), "@list-leads?$query&category={$lead->getCategoryId()}") ?></em>
            </td>
        <td></td>
        <td><?php echo link_to(format_datetime($lead->getCreatedAt('U'), 'F'), $lead->getEditUrl()) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>