<h4><div class="_right"><?php echo link_to(__('Edit Article'), $object->getEditUrl(), 'class=action-button') ?></div>
    <?php echo __('Title: %1s', array('%1s' => $object->getName())) ?></h4>
<table class="infopanel" style="width: 90%; margin: 0 auto;">
    <tr>
        <td><strong><?php echo __('Author') ?> :</strong>
            <div><?php echo $object->getAuthor() ? $object->getAuthor() : __('Not Available') ?></div>
        </td>
        <td><strong><?php echo __('Source') ?> :</strong>
            <div><?php echo $object->getPublicationSource() ? $object->getPublicationSource() : __('Not Available') ?></div>
        </td>
        <td><strong><?php echo __('Category') ?></strong>
            <div><?php echo $object->getPublicationCategory() ? $object->getPublicationCategory() : __('Not Available') ?></div>
        </td>
        <td><strong><?php echo __('Status') ?></strong>
            <div>
                <?php echo $object->getActive() ? link_to(__('Online'), $object->getEditUrl('unpub'), 'class=status-switch green') : link_to(__('Offline'), $object->getEditUrl('pub'), 'class=status-switch red') ?>
                <div class="hrsplit-1"></div>
                <?php echo $object->getFeaturedType() == PublicationPeer::PUB_FEATURED_BANNER ? link_to(__('Banner On'), $object->getEditUrl('ftr'), 'class=status-switch blue') : link_to(__('Banner Off'), $object->getEditUrl('ftr') . '&typ='. PublicationPeer::PUB_FEATURED_BANNER, 'class=status-switch grey') ?>
                <div class="hrsplit-1"></div>
                <?php echo $object->getFeaturedType() == PublicationPeer::PUB_FEATURED_COLUMN ? link_to(__('Column On'), $object->getEditUrl('ftr'), 'class=status-switch blue') : link_to(__('Column Off'), $object->getEditUrl('ftr') . '&typ='. PublicationPeer::PUB_FEATURED_COLUMN, 'class=status-switch grey') ?>
            </div>
        </td>
    </tr>
</table>
<h5><?php echo __('Summary') ?></h5>
<div class="pad-2">
    <?php echo $object->getSummary($object->getDefaultLang()) ? $object->getSummary($object->getDefaultLang()) : '<span class="ln-example">'.__('[Empty]')."</span>" ?>
</div>
<h5><?php echo __('Introduction') ?></h5>
<div class="pad-2">
    <?php echo $object->getIntroduction($object->getDefaultLang()) ? $object->getIntroduction($object->getDefaultLang()) : '<span class="ln-example">'.__('[Empty]')."</span>" ?>
</div>
<h5><?php echo __('Content') ?></h5>
<div class="pad-2">
<?php echo str_replace("\n", "<br />", $object->getClob(PublicationI18nPeer::CONTENT, $object->getDefaultLang())) ?>
</div>
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