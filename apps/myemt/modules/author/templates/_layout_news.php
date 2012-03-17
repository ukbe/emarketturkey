<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th><?php echo link_to(__('ID'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'id' && $dir == 'asc' ? 'desc' : 'asc').'&sort=id'), $sort == 'id' ? "class=$dir" : '') ?></th>
            <th></th>
            <th><?php echo link_to(__('News'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'title' && $dir == 'asc' ? 'desc' : 'asc').'&sort=title'), $sort == 'title' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Source'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'source' && $dir == 'asc' ? 'desc' : 'asc').'&sort=source'), $sort == 'source' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Category'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'category' && $dir == 'asc' ? 'desc' : 'asc').'&sort=category'), $sort == 'category' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Created At'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'publish' && $dir == 'asc' ? 'desc' : 'asc').'&sort=publish'), $sort == 'publish' ? "class=$dir" : '') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $news): ?>
    <tr<?php echo $news->getActive() ? '' : ' class="passive"' ?>>
        <td><?php echo $news->getId() ?></td>
        <td><?php echo $news->getPicture() ? link_to(image_tag($news->getPictureUri()), $news->getEditUrl('view')) : '' ?></td>
        <td><strong><?php echo link_to($news, $news->getEditUrl('view')) ?></strong>
            <div><?php echo $news->getAuthor() ?></div></td>
        <td><?php echo $news->getPublicationSource() ?></td>
        <td><?php echo $news->getPublicationCategory() ?></td>
        <td><?php echo format_datetime($news->getCreatedAt('U'), 'g') ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>