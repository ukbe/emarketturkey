<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Lead') ?></th>
            <th><?php echo __('Category') ?></th>
            <th><?php echo __('Published') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $lead): ?>
    <tr>
        <td><?php echo link_to(image_tag($lead->getThumbUri()), $lead->getEditUrl()) ?></td>
        <td><?php echo link_to($lead->getName($lead->getDefaultLang()), $lead->getEditUrl()) ?></td>
        <td><?php echo link_to($lead->getProductCategory(), $lead->getEditUrl()) ?></td>
        <td><?php echo link_to(time_ago_in_words($lead->getCreatedAt('U')), $lead->getEditUrl()) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>