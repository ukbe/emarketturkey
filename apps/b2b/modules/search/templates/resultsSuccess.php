<div class="col_948">
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>

<?php /* ?>
<?php use_helper('Date', 'I18N') ?>
<div class="col_180">
<?php include_partial('search/filter', array('filtercats' => $filtercats, 'criterias' => $criterias, 'searchroute' => $searchroute)) ?>
</div>
<div class="col_762">
<h2><?php echo __('Search Results') ?></h2>
<div id="ress">
<?php if (count($results)): ?>
<table width="100%" class="searchresults">
<?php foreach ($results as $result): ?>
<tr><?php include_partial('result'.get_class($result), array('result' => $result)) ?></tr>
<?php endforeach ?>
</table>
<?php else: ?>
<span style="font-size: 14px;"><?php echo __('No results found for keyword "%1"', array('%1' => $criterias['keyword'])) ?></span>
<?php endif ?>
</div>
</div>
<br class="clear" /><? */ ?>