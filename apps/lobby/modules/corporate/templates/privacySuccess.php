<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('about_menu') ?>
<?php end_slot() ?><div class="column span-110 pad-2">
<h2><?php echo __('Privacy Policy') ?></h2>
<p><?php include_partial('privacy.'.$sf_user->getCulture()) ?></p> 
</div>