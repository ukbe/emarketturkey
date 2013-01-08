<h4><div class="_right"><?php echo link_to(__('Edit Announcement'), $object->getEditUrl(), 'class=action-button') ?></div>
    <?php echo __('Title: %1s', array('%1s' => $object)) ?></h4>
<table class="infopanel" style="width: 90%; margin: 0 auto;">
    <tr>
        <td><strong><?php echo __('Activity') ?> :</strong>
            <div><?php echo __('Sent to %1recip of %2recip recipients', array('%1recip' => $object->countSentRecipients(), '%2recip' => $object->countRecipients())) ?></div>
        </td>
        <td><strong><?php echo __('Status') ?></strong>
            <div>
                <?php echo __(AnnouncementPeer::$statLabels[$object->getStatus()]) ?>
            </div>
        </td>
    </tr>
</table>
<h5><?php echo __('Announcement Information') ?></h5>
<dl class="_table _noInput">
    <dt><?php echo emt_label_for('ann_owner_id', __('Owner')) ?></dt>
    <dd><?php if ($object->getOwner()): ?>
        <span class="t_bold"><?php echo link_to($object->getOwner()->__toString(), $object->getOwner()->getProfileUrl()) ?></span>
        <?php elseif (is_null($object->getOwnerTypeId())): ?>
            <span class="t_bold"><?php echo __(AnnouncementPeer::$ownerName[$object->getOwnerId()]) ?></span>
        <?php else: ?>
            <span class="t_bold"><?php echo __('Not Available') ?></span>
        <?php endif ?>
        </dd>
    <dt><?php echo emt_label_for('ann_title', __('Title')) ?></dt>
    <dd><?php echo $object->gettitle() ?></dd>
    <dt><?php echo emt_label_for('ann_channel', __('Channel')) ?></dt>
    <dd><?php echo AnnouncementPeer::$chnlLabels[$object->getChannelId()] ?></dd>
    <dt><?php echo emt_label_for('ann_layout', __('Layout')) ?></dt>
    <dd><?php echo $object->getEmailLayout() ?></dd>
    <dt><?php echo emt_label_for('ann_recipient_class', __('Recipient Class')) ?></dt>
    <dd><?php echo _(AnnouncementPeer::$recipLabels[$object->getRecipientClass()]) ?></dd>
    <?php if ($object->getRecipientClass() == AnnouncementPeer::ANN_RECIP_RELATED): ?>
    <dt><?php echo emt_label_for('ann_relation_subject', __('Relation Subject')) ?></dt>
    <dd><?php echo link_to($object->getRelationSubject()->__toString(), $object->getRelationSubject()->getProfileUrl()) ?></dd>
    <dt><?php echo emt_label_for('ann_relation_role', __('Relation Role')) ?></dt>
    <dd><?php echo $object->getRole() ?></dd>
    <?php endif ?>
    <dt><?php echo emt_label_for('ann_feed_type', __('Feed Type')) ?></dt>
    <dd><?php echo $object->getDynamicFeed() ? __('Dynamic Feed') : __('Static Feed') ?></dd>
</dl>
<h5><?php echo __('Delivery Options') ?></h5>
<dl class="_table _noInput">
    <dt><?php echo emt_label_for('ann_deliver_from', __('Deliver From')) ?></dt>
    <dd><?php echo format_datetime($object->getDeliverFrom('U'), 'f') ?></dd>
    <dt><?php echo emt_label_for('ann_deliver_by', __('Deliver By')) ?></dt>
    <dd><?php echo format_datetime($object->getDeliverBy('U'), 'f') ?></dd>
    <dt><?php echo emt_label_for('ann_priority', __('Priority')) ?></dt>
    <dd><?php echo __(AnnouncementPeer::$prioLabels[$object->getPriority()]) ?></dd>
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