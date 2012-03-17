<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('about_menu') ?>
<?php end_slot() ?>
<div class="column span-130 pad-2">
<h2><?php echo __('Terms of use') ?></h2>
<p><?php include_partial('terms_of_use.'.$sf_user->getCulture()) ?></p> 
</div>