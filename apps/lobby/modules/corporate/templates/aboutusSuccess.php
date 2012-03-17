<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('about_menu') ?>
<?php end_slot() ?>
<div class="column span-110 pad-2">
<h2><?php echo __('About Us') ?></h2>
<p class="content_text">
<?php include_partial('about_us.'.$sf_user->getCulture()) ?>
<p><b><?php echo __('eMarketTurkey Team') ?></b></p>
<br />
</div>
<script>parent.pholder.height=document.height;</script>