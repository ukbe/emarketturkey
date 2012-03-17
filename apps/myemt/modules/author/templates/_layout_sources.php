<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th><?php echo link_to(__('ID'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'id' && $dir == 'asc' ? 'desc' : 'asc').'&sort=id'), $sort == 'id' ? "class=$dir" : '') ?></th>
            <th></th>
            <th><?php echo link_to(__('Source'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'name' && $dir == 'asc' ? 'desc' : 'asc').'&sort=name'), $sort == 'name' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Created At'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'publish' && $dir == 'asc' ? 'desc' : 'asc').'&sort=publish'), $sort == 'publish' ? "class=$dir" : '') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $source): ?>
    <tr>
        <td><?php echo $source->getId() ?></td>
        <td><?php echo $source->getPicture() ? link_to(image_tag($source->getPictureUri()), $source->getEditUrl()) : '' ?></td>
        <td><strong><?php echo link_to($source, $source->getEditUrl()) ?></strong>
            <div><?php echo $source->getDescription() ?></div></td>
        <td><?php echo format_datetime($source->getCreatedAt('U'), 'g') ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>