<?php use_helper('Date') ?>
<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map'   => array(__('Profile') => $user->getProfileUrl(), 
                                                                     __('Photos') => $user->getPhotosUrl(),
                                                                     __('Photo Preview') => null
                                                                     ),
                                                    'user'  => $user
                                                   )) ?> 
<?php end_slot() ?>
<?php if ($sf_user->getUser() && $sf_user->getUser()->getId()==$user->getId()): ?>
<?php slot('pagecommands') ?>
<ol class="column command-menu">
<li><?php echo link_to(__('Delete Photo'), $user->getPhotosUrl(), array('query_string' => 'mod=delete&pid='.$photo->getId())) ?></li>
<?php if ($user->getProfilePictureId()!=$photo->getId()): ?>
<li><?php echo link_to(__('Set as Profile Picture'), $user->getPhotosUrl(), array('query_string' => 'mod=setprofile&pid='.$photo->getId())) ?></li>
<?php endif ?>
</ol>
<?php end_slot() ?>
<?php endif ?>
<?php if ($photo->getMediaItemFolder()): ?>
<div style="float: right">
<?php echo ($photo->getIndex()>1) ? link_to(__('Previous'), $user->getPhotosUrl(), array('query_string' => 'mod=display&pid='.$photo->getPrevious()->getId(), 'class' => 'side-link')) : '' ?>
<?php echo ($photo->getIndex()<$photo->getMediaItemFolder()->countMediaItems()) ? link_to(__('Next'), $user->getPhotosUrl(), array('query_string' => 'mod=display&pid='.$photo->getNext()->getId(), 'class' => 'side-link')) : '' ?>
</div>
<div>
<?php echo $photo->getMediaItemFolder()->getName() ?>&nbsp;-&nbsp;<span class="grey-text"><?php echo __('%1i of %2i', array('%1i' => $photo->getIndex(), '%2i' => $photo->getMediaItemFolder()->countMediaItems())) ?></span>&nbsp;-&nbsp;
<?php echo link_to(__('Back to Album'), $user->getPhotosUrl(), array('query_string' => 'aid='.$photo->getFolderId(), 'class' => 'side-link')) ?>
</div>
<div class="hrsplit-1"></div>
<?php endif ?>
<?php echo link_to(image_tag($photo->getUri()), $user->getPhotosUrl(), array('query_string' => 'mod=display&pid='.$photo->getNext()->getId())) ?>
<div class="hrsplit-2"></div>
<div class="grey-box span-90">
<em><?php echo __('Uploaded at %1t by %2n', array('%1t' => format_datetime($photo->getCreatedAt('U'), 'U'), '%2n' => link_to($user, $user->getProfileUrl(), 'class=side-link'))) ?></em>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('global/comment_box', array('item' => $photo)) ?>