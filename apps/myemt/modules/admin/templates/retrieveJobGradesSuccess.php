<?php use_helper('EmtAjaxTable') ?>
<?php echo get_ajax_table($table, false) ?>

<?php $form = get_pager_links($table) ?>
<?php echo javascript_tag("
           html = '".escape_javascript($form)."';
           var tab = ajaxtables['jobgrades'];
           tab.pagerlinks.html(html);
           var items = {};
           items['start'] = '{$table->getPager()->getFirstIndice()}';
           items['max'] = '{$table->getItemsPerPage()}';
           items['sort'] = '{$table->getOrderColumn()}';
           items['dir'] = '{$table->getSortOrder()}';
           items['keyword'] = '{$table->getKeyword()}';
           tab.updateParams(items);
           tab.progressbar.hide();
           ") ?>