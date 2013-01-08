<?php use_helper('Date') ?>
<?php $profile = $user->getUserProfile() ?>
<div class="column span-198">
</div>
<div class="hrsplit-2"></div>
<div class="column span-156 prepend-1 last">
<?php if ($profile): ?>
<div class="column span-41 right">
<?php echo image_tag($user->getProfilePictureUri()) ?>
</div>
<div class="column span-104 prepend-2">
<div class="column span-100">
<h2><?php echo $user ?></h2>
<div class="hrsplit-1"></div>
<div class="column span-96 pad-2" style="border: solid 1px #E4D08C; background-color: #FFF6D6">
<div class="column span-13">
<?php echo image_tag('layout/icon/stock-lock-50x50.png') ?>
</div>
<div class="column">
<h3><?php echo __('Locked Profile!') ?></h3>
<?php echo __('%1 locked %2 profile for public access.', array('%1' => $user, '%2' => ($user->getGender()==UserProfilePeer::GENDER_MALE ? __('his') : __('her')))) ?>
</div>
</div>
<div class="hrsplit-1"></div>
<em><?php echo __('Have a look at our %1.', array('%1' => link_to(__('Privacy Policy'), '@privacy'))) ?></em>
<div class="hrsplit-3"></div>
<?php echo link_to_function(__('Go Back'), 'history.back()') ?>
</div>
</div>
<?php endif ?>
</div>