<h4><div class="_right"><?php echo link_to(__('Edit Publication Source'), $object->getEditUrl(), 'class=action-button') ?></div>
    <?php echo __('Title: %1s', array('%1s' => $object)) ?></h4>
<table class="infopanel" style="width: 90%; margin: 0 auto;">
    <tr>
        <td><strong><?php echo __('Publication Source') ?> :</strong>
            <div><?php echo $object ?></div>
        </td>
        <td><strong><?php echo __('Status') ?></strong>
            <div>
                <?php echo $object->getActive() ? link_to(__('Online'), $object->getEditUrl('unpub'), 'class=status-switch green') : link_to(__('Offline'), $object->getEditUrl('pub'), 'class=status-switch red') ?>
            </div>
        </td>
    </tr>
</table>
<h5><?php echo __('Publication Source Information') ?></h5>
<dl class="_table _noInput">
    <dt><?php echo emt_label_for('pubs_name', __('Source Name')) ?></dt>
    <dd><?php echo $object->getName() ?></dd>
    <dt><?php echo emt_label_for('pubs_display_name', __('Display Name')) ?></dt>
    <dd><?php echo $object->getDisplayName($object->getDefaultLang()) ?></dd>
    <dt><?php echo emt_label_for('pubs_short_desc', __('Short Description')) ?></dt>
    <dd><?php echo $object->getShortDescription($object->getDefaultLang()) ?></dd>
    <dt><?php echo emt_label_for('pubs_description', __('Description')) ?></dt>
    <dd><?php echo $object->getDescription($object->getDefaultLang()) ?></dd>
</dl>
<h5><?php echo __('Photos') ?></h5>
<dl class="_table whoatt">
    <dt></dt>
    <dd><?php if (count($photos = $object->getPhotos())): ?>
        <?php foreach ($photos as $photo): ?>
        <div>
        <?php echo link_to(image_tag($photo->getThumbnailUri(), 'class=bordered-image'), $photo->getUri(), array('title' => __('Click to view'), 'target' => 'blank')) ?><br />
        <?php echo link_to('&nbsp;', $object->getEditUrl('rmp') . "&pid={$photo->getId()}", array('class' => 'remove', 'title' => __('Remove Photo'))) ?>
        </div>
        <?php endforeach ?>
        <div class="hrsplit-1"></div>
        <?php else: ?>
        <?php echo __('No photos') ?>
        <?php endif ?></dd>
    </dd>
</dl>
<?php echo javascript_tag("
    $('.whoatt a[title!=\"\"]').tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });
") ?>