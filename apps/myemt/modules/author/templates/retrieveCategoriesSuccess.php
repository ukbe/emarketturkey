<?php use_helper('EmtAjaxTable') ?>
<?php echo get_ajax_table($table, false) ?>

<?php $form = get_pager_links($table) ?>
<?php echo javascript_tag("
           html = '".escape_javascript($form)."';
           var tab = ajaxtables['pubcategories'];
           tab.pagerlinks.html(html);
           var items = {};
           items['filter'] = '{$table->getKeyword()}';
           items['st'] = '{$table->getPager()->getFirstIndice()}';
           items['sort'] = '{$table->getOrderColumn()}';
           items['dir'] = '{$table->getSortOrder()}';
           tab.updatePagerAttributes(items);
           tab.progressbar.hide();
           ") ?>