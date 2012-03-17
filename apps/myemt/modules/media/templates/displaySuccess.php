<?php use_helper('Date') ?>
<div class="column span-198">
<div class="column">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Profile'), '@profile') ?></li>
<li><?php echo link_to(__('Photos'), 'media/photos') ?></li>
<li class="last"><?php echo __('Display') ?></li>
</ol>
</div>
<ol class="column command-menu">
<li><?php echo link_to(__('Delete Photo'), 'media/photos', array('query_string' => 'mod=delete&pid='.$photo->getId())) ?></li>
<?php if ($user->getProfilePictureId()!=$photo->getId()): ?>
<li><?php echo link_to(__('Set as Profile Picture'), 'media/photos', array('query_string' => 'mod=setprofile&pid='.$photo->getId())) ?></li>
<?php endif ?>
</ol>
<ol class="inline-form">
<li></li></ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-198 last">
<h2><?php echo $photo->getMediaItemFolder()?$photo->getMediaItemFolder()->getName().':':'' ?>Photo</h2>
<?php echo image_tag($photo->getUri()) ?>
<div class="hrsplit-2"></div>
<div class="grey-box span-100">
<em><?php echo __('<b>Uploaded at:</b> %1t', array('%1t' => format_datetime($photo->getCreatedAt('U')))) ?></em>
</div>
</div>