<?php use_helper('Date') ?>
<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map'   => array(__('Profile') => $user->getProfileUrl(), 
                                                                     __('Photos') => $user->getPhotosUrl(),
                                                                     __('Photo Preview') => null
                                                                     ),
                                                    'user'  => $user
                                                   )) ?> 
<?php end_slot() ?>
<?php echo link_to(image_tag($photo->getUri()), $user->getPhotosUrl(), array('query_string' => 'mod=display&pid='.$photo->getNext()->getId())) ?>
</li>
<div class="hrsplit-2"></div>
<div class="grey-box span-100">
<em><?php echo __('<b>Uploaded at:</b> %1t', array('%1t' => format_datetime($photo->getCreatedAt('U')))) ?></em>
</div>
<div class="hrsplit-1"></div>
<?php include_partial('profile/comment_box', array('item' => $photo)) ?>