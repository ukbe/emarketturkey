<?php slot('leftcolumn') ?>
<h3><?php echo __('Corporate Representative Tasks') ?></h3>
<?php echo image_tag('layout/icon/role/admin.png') ?></li>
<?php end_slot() ?>
<div class="role-index">
<h2><?php echo __('Manage Portfolio') ?></h2>
<ol class="actions">
<li><?php echo link_to(__('Portfolio Companies'), 'representative/companies') ?></li>
<li><?php echo link_to(__('Add New Portfolio Company'), 'representative/addCompany') ?></li>
</ol>
<div class="hrsplit-1"></div>
</div>