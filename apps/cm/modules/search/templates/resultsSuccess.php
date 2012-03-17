<?php use_helper('Date', 'I18N', 'EmtAjaxTable') ?>
<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('search/filter', array('filtercats' => $filtercats, 'criterias' => $criterias)) ?>
<?php end_slot() ?>
<div style="float: right;">
<?php echo get_progress_bar($table) ?>
</div>
<?php echo get_error_box($table) ?>
<h2><?php echo __('Search Results') ?></h2>
<div id="ress">
<?php if ($table->getPager()->getNbResults()>0): ?>
<?php echo get_ajax_table($table); ?>
<?php else: ?>
<span class="no-results">
<?php if ($table->getName()=='users'): ?>
<?php echo __('Sorry! We could not find the person you are looking for.') ?>
<?php else: ?>
<?php echo __('Sorry! We could not find the group you are looking for.') ?>
<?php endif ?>
</span>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php echo get_pager_links($table) ?>
<?php /*else: ?>
<span style="font-size: 14px;"><?php echo __('No results found for keyword "%1"', array('%1' => $criterias['keyword'])) ?></span>
<?php endif */ ?>
</div>