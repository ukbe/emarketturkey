<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map'   => array(__('Profile') => $user->getProfileUrl(), 
                                                                     __('Photos') => null),
                                                    'user'  => $user
                                                   )) ?> 
<?php end_slot() ?>

<?php if (count($photos)): ?>
<?php $i = 0 ?>
<table class="column photo-album span-140">
<?php foreach ($photos as $photo): ?>
<?php $i++; ?>
<?php if (($i % 4) == 1 ): ?>
<tr>
<?php endif ?>
<td><?php echo link_to(image_tag($photo->getMediumUri()), $user->getPhotosUrl(), array('query_string' => 'mod=display&id='.$user->getId().'&pid='.$photo->getId())) ?></td>
<?php if (($i % 4) == 0 ): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if (($i % 4) != 0 ): ?>
</tr>
<?php endif ?>
</table>
<?php else: ?>
<p><?php echo __('%1 does not have any photos, yet.', array('%1' => link_to($user, $user->getProfileUrl()))) ?></p>
<?php endif ?>