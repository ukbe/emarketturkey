<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th><?php echo link_to(__('ID'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'id' && $dir == 'asc' ? 'desc' : 'asc').'&sort=id'), $sort == 'id' ? "class=$dir" : '') ?></th>
            <th></th>
            <th><?php echo link_to(__('Author'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'name' && $dir == 'asc' ? 'desc' : 'asc').'&sort=name'), $sort == 'name' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Created At'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'created' && $dir == 'asc' ? 'desc' : 'asc').'&sort=created'), $sort == 'created' ? "class=$dir" : '') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $author): ?>
    <tr>
        <td><?php echo $author->getId() ?></td>
        <td><?php echo $author->getPicture() ? link_to(image_tag($author->getPictureUri()), $author->getEditUrl('view')) : '' ?></td>
        <td><strong><?php echo link_to($author, $author->getEditUrl('view')) ?></strong>
            <div><?php echo $author->getTitle() ? $author->getTitle() : $author->getTitle($author->getDefaultLang()) ?></div></td>
        <td><?php echo format_datetime($author->getCreatedAt('U'), 'g') ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>