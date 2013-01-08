<?php use_helper('Date') ?>
<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map'   => array(__('Profile') => $user->getProfileUrl(), 
                                                                     __('Photos') => null),
                                                    'user'  => $user
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('rightcolumn') ?>
<div class="column span-49">
<ol class="column command-menu" style="margin: 0px;padding: 0px;">
<li><?php echo link_to(__('Upload Photo'), $user->getUploadUrl()) ?></li>
</ol></div>
<?php end_slot() ?>
<?php if (count($photos)): ?>
<?php $i = 0 ?>
<table class="column photo-album span-150">
<?php foreach ($albums as $album): ?>
<?php $album_photo = $album->getItems(1) ?>
<?php $i++; ?>
<?php if (($i % 4) == 1 ): ?>
<tr>
<?php endif ?>
<td>
<?php if ($album_photo): ?>
<?php echo link_to(image_tag($album_photo->getMediumUri()), $user->getPhotosUrl(), array('query_string' => 'aid='.$album->getId())) ?>
<?php else: ?>
<?php echo link_to(image_tag(), $user->getPhotosUrl(), array('query_string' => 'mod=display&pid='.$album_photo->getId())) ?>
<?php endif ?>
</td>
<?php if (($i % 4) == 0 ): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if (($i % 4) != 0 ): ?>
</tr>
<?php endif ?>
</table>
<?php else: ?>
<p><?php echo __('No photos uploaded, yet. Click "Upload" button to upload a photo.') ?></p>
<?php endif ?>
