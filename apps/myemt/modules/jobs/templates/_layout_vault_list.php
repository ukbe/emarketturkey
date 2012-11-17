<?php use_helper('Date') ?>
<table class="data-table list">
    <thead>
        <tr>
            <th></th>
            <th style="width: 20px;"></th>
            <th><?php echo __('Name Lastname') ?></th>
            <th><?php echo __('Channel') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $resume): ?>
    <?php $channels = array() ?>
    <?php foreach ($resume->getChannels($profile->getId()) as $type => $chnls): ?>
    <?php foreach ($chnls as $chnl): ?>
    <?php switch ($type){
            case DatabaseCVPeer::CHANNEL_APPLICATION:
                $channels[] = __('Applied to %1 at %2', array('%1' => link_to("&nbsp;", $chnl->getJob()->getManageUrl(), array('class' => 'box_closed', 'title' => $chnl->getJob())), '%2' => format_datetime($chnl->getCreatedAt('U'), 'f')));
                break;
            case DatabaseCVPeer::CHANNEL_SERVICE:
                $channels[] = __('Unlocked at %1', array('%1' => format_datetime($chnl->getCreatedAt('U'), 'f')));
                break;
          } ?>
    <?php endforeach ?>
    <?php endforeach ?>
    <tr>
        <td><?php echo link_to(image_tag($resume->getPhotoUri()), $url = $profile->getCVPreviewUrl($resume->getId())) ?></td>
        <td></td>
        <td><?php echo link_to($resume->getUser()->__toString(), $url) ?></td>
        <td><?php echo implode('<br />', $channels) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="5"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>