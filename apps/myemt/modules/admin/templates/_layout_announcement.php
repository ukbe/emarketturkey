<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th><?php echo link_to(__('ID'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'id' && $dir == 'asc' ? 'desc' : 'asc').'&sort=id'), $sort == 'id' ? "class=$dir" : '') ?></th>
            <th></th>
            <th><?php echo link_to(__('Announcement'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'title' && $dir == 'asc' ? 'desc' : 'asc').'&sort=title'), $sort == 'title' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Status'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'source' && $dir == 'asc' ? 'desc' : 'asc').'&sort=source'), $sort == 'source' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Priority'), myTools::remove_querystring_var($sf_request->getUri(), array('priority', 'dir'), null, 'dir='.($sort == 'priority' && $dir == 'asc' ? 'desc' : 'asc').'&sort=priority'), $sort == 'priority' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Created At'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'publish' && $dir == 'asc' ? 'desc' : 'asc').'&sort=publish'), $sort == 'publish' ? "class=$dir" : '') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $ann): ?>
    <tr<?php echo $ann->getActive() ? '' : ' class="passive"' ?>>
        <td><?php echo $ann->getId() ?></td>
        <td><?php echo $ann->getPicture() ? link_to(image_tag($ann->getPictureUri()), $ann->getEditUrl('view')) : '' ?></td>
        <td><strong><?php echo link_to($ann, $ann->getEditUrl('view')) ?></strong>
            <div><?php echo $ann->getOwner() ?></div></td>
        <td><?php echo $ann->getStatus() ?></td>
        <td><?php echo $ann->getPriority() ?></td>
        <td><?php echo format_datetime($ann->getCreatedAt('U'), 'f') ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>