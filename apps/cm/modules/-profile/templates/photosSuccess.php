<?php use_helper('Date') ?>
<?php slot('mappath') ?>
<?php $map = array(__('Profile') => $user->getProfileUrl());
      if (isset($album) && $album instanceof MediaItemFolder)
      {
        $map[__('Photos')] = $user->getPhotosUrl();
        $map[__('Album')] = null;
      }
      else {
        $map[__('Photos')] = null;
      }
 ?>
<?php include_partial('profile/user_pagetop', array('map'   => $map,
                                                    'user'  => $user
                                                   )) ?> 
<?php end_slot() ?>
<?php if ($sesuser->getId()==$user->getId()): ?>
<?php slot('rightcolumn') ?>
<div class="column span-49">
<ol class="column command-menu" style="margin: 0px;padding: 0px;">
<li><?php echo link_to(__('Upload Photo'), $user->getUploadUrl()) ?></li>
</ol></div>
<?php end_slot() ?>
<?php endif ?>
<?php if (count($photos)+count($albums)): ?>
<?php $i = 0 ?>
<?php if (isset($album) && $album instanceof MediaItemFolder): ?>
<h2><?php echo $album->getName() ?></h2>
<?php endif ?>
<table class="column photo-album span-150">
<?php foreach ($albums as $oalbum): ?>
<?php $album_photo = $oalbum->getItems(1) ?>
<?php $i++; ?>
<?php if (($i % 4) == 1 ): ?>
<tr>
<?php endif ?>
<td>
<?php if ($album_photo): ?>
<?php echo link_to(image_tag($album_photo[0]->getMediumUri(), array('style' => 'background-color:#8088B1;', 'title' => __('Album: %1 (%2 photos)', array('%1' => $oalbum->getName(), '%2' => $oalbum->countMediaItems())))), $user->getPhotosUrl(), array('query_string' => 'aid='.$oalbum->getId())) ?>
<br /><?php echo $oalbum->getName() . '<br />' . __('<span class="grey-text">%1 Photos</span>', array('%1' => $oalbum->countMediaItems())) ?>
<?php else: ?>
<?php echo link_to(image_tag('layout/photo-album.jpg'), $user->getPhotosUrl(), array('query_string' => 'aid='.$oalbum->getId())) ?>
<?php endif ?>
</td>
<?php if (($i % 4) == 0 ): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php foreach ($photos as $photo): ?>
<?php $i++; ?>
<?php if (($i % 4) == 1 ): ?>
<tr>
<?php endif ?>
<td>
<?php echo link_to(image_tag($photo->getMediumUri()), $user->getPhotosUrl(), array('query_string' => 'mod=display&pid='.$photo->getId())) ?>
</td>
<?php if (($i % 4) == 0 ): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if (($i % 4) != 0 ): ?>
</tr>
<?php endif ?>
</table>
<?php if (isset($album) && $album instanceof MediaItemFolder): ?>
<div class="hrsplit-1"></div>
<?php include_partial('profile/comment_box', array('item' => $album)) ?>
<?php endif ?>
<?php else: ?>
<?php if ($sf_user->getUser() && $sf_user->getUser()->getId()==$user->getId()): ?>
<p><?php echo __('No photos uploaded, yet. Click "Upload" button to upload a photo.') ?></p>
<?php else: ?>
<p><?php echo __('%1 does not have any photos, yet.', array('%1' => link_to($user->getName(), $user->getProfileUrl()))) ?></p>
<?php endif ?>
<?php endif ?>
