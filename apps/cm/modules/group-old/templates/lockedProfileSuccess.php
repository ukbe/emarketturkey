<?php use_helper('Date') ?>
<div class="column span-198">
</div>
<div class="hrsplit-2"></div>
<div class="column span-156 prepend-1 last">
<?php if ($group): ?>
<div class="column span-41 right">
<?php echo image_tag($group->getProfilePictureUri()) ?>
</div>
<div class="column span-104 prepend-2">
<div class="column span-100">
<h2><?php echo $group ?></h2>
<div class="hrsplit-1"></div>
<div class="column span-96 pad-2" style="border: solid 1px #E4D08C; background-color: #FFF6D6">
<div class="column span-13">
<?php echo image_tag('layout/icon/stock-lock-50x50.png') ?>
</div>
<div class="column">
<h3><?php echo __('Locked Profile!') ?></h3>
<?php echo __('%1 profile page was locked for public access.', array('%1' => $group)) ?>
</div>
</div>
<div class="hrsplit-1"></div>
<em><?php echo __('Have a look at our %1.', array('%1' => link_to(__('Privacy Policy'), '@lobby.privacy'))) ?></em>
<div class="hrsplit-3"></div>
<?php echo link_to_function(__('Go Back'), 'history.back()') ?>
</div>
</div>
</div>
<?php endif ?>
</div>