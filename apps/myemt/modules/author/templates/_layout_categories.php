<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th><?php echo link_to(__('ID'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'id' && $dir == 'asc' ? 'desc' : 'asc').'&sort=id'), $sort == 'id' ? "class=$dir" : '') ?></th>
            <th></th>
            <th><?php echo link_to(__('Category'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'name' && $dir == 'asc' ? 'desc' : 'asc').'&sort=name'), $sort == 'name' ? "class=$dir" : '') ?></th>
            <th><?php echo link_to(__('Parent Category'), myTools::remove_querystring_var($sf_request->getUri(), array('sort', 'dir'), null, 'dir='.($sort == 'parent' && $dir == 'asc' ? 'desc' : 'asc').'&sort=parent'), $sort == 'parent' ? "class=$dir" : '') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $category): ?>
    <tr<?php echo $category->getActive() ? '' : ' class="passive"' ?>>
        <td><?php echo $category->getId() ?></td>
        <td><?php echo $category->getPicture() ? link_to(image_tag($category->getPictureUri()), $category->getEditUrl('view')) : '' ?></td>
        <td><strong><?php echo link_to($category, $category->getEditUrl('view')) ?></strong></td>
        <td><?php echo $category->getPublicationCategoryRelatedByParentId() ? link_to($category->getPublicationCategoryRelatedByParentId(), $category->getPublicationCategoryRelatedByParentId()->getEditUrl('view')) : '' ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>