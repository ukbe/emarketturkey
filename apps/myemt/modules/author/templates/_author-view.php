<h4><div class="_right"><?php echo link_to(__('Edit Author'), $object->getEditUrl(), 'class=action-button') ?></div>
    <?php echo __('Title: %1s', array('%1s' => $object)) ?></h4>
<table class="infopanel" style="width: 90%; margin: 0 auto;">
    <tr>
        <td><strong><?php echo __('Author Account Owner') ?> :</strong>
            <div><?php echo $object->getUser() ? link_to(image_tag($object->getUser()->getProfilePictureUri()) . $object->getUser(), $object->getUser()->getProfileUrl()) : __('Not Available') ?></div>
        </td>
        <td><strong><?php echo __('Status') ?></strong>
            <div>
                <?php echo $object->getActive() ? link_to(__('Online'), $object->getEditUrl('unpub'), 'class=status-switch green') : link_to(__('Offline'), $object->getEditUrl('pub'), 'class=status-switch red') ?>
                <?php if ($object->getIsColumnist()): ?>
                <div class="hrsplit-1"></div>
                <?php echo $object->getFeaturedType() == AuthorPeer::AUTH_FEATURED_COLUMN ? link_to(__('Column On'), $object->getEditUrl('ftr'), 'class=status-switch blue') : link_to(__('Column Off'), $object->getEditUrl('ftr') . '&typ='. AuthorPeer::AUTH_FEATURED_COLUMN, 'class=status-switch grey') ?>
                <?php endif ?>
            </div>
        </td>
    </tr>
</table>
<h5><?php echo __('Author Information') ?></h5>
<dl class="_table _noInput">
    <dt><?php echo emt_label_for('auth_user_id', __('User Account')) ?></dt>
    <dd><?php if ($object->getUser()): ?>
        <span class="t_bold"><?php echo link_to($object->getUser(), $object->getUser()->getProfileUrl()) ?></span>
        <?php else: ?>
        <span class="t_bold"><?php echo __('Not Available') ?></span>
        <?php endif ?>
        <?php echo link_to($object->getUser() ? __('[change]') : __('[assign user]'), $object->getEditUrl(), 'class=inherit-font bluelink hover margin-l1') ?>
        </dd>
    <dt><?php echo emt_label_for('auth_salutation', __('Salutation')) ?></dt>
    <dd><?php echo $object->getSalutation() ?></dd>
    <dt><?php echo emt_label_for('auth_name', __('Name')) ?></dt>
    <dd><?php echo $object->getName() ?></dd>
    <dt><?php echo emt_label_for('auth_lastname', __('Lastname')) ?></dt>
    <dd><?php echo $object->getLastname() ?></dd>
    <dt><?php echo emt_label_for('auth_is_columnist', __('Columnist')) ?></dt>
    <dd><?php echo $object->getIsColumnist() ? __('Yes') : __('No') ?></dd>
    <dt><?php echo emt_label_for('auth_display_name', __('Display Name')) ?></dt>
    <dd><?php echo $object->getDisplayName($object->getDefaultLang()) ?></dd>
    <dt><?php echo emt_label_for('auth_title', __('Title')) ?></dt>
    <dd><?php echo $object->getTitle($object->getDefaultLang()) ?></dd>
    <dt><?php echo emt_label_for('auth_introduction', __('Introduction')) ?></dt>
    <dd><?php echo $object->getIntroduction($object->getDefaultLang()) ?></dd>
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