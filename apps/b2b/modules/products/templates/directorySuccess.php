<div class="col_948">
    <div class="col_180">

<?php include_partial('products', array('mod' => $mod)) ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($country): ?>
            <h4 style="border-bottom:none;"><?php echo __('Products from %1', array('%1' => $country->getName())) ?></h4>
            <?php echo link_to(__('Back to Country List'), '@products-action?action=byCountry', 'class=bluelink hover') ?>
            <?php elseif ($category): ?>
            <h4 style="border-bottom:none;"><?php echo __('Products in %1 Category', array('%1' => $category)) ?></h4>
            <?php echo link_to(__('Back to Category List'), '@products-action?action=byCategory', 'class=bluelink hover') ?>
            <?php if (count($subs = $category->getSubCategories())):?>
            <div class="bubble two_columns margin-t1">
            <?php foreach ($subs as $sub): ?>
            <?php echo link_to($sub, "@products-dir?substitute={$sub->getStrippedCategory()}") ?>
            <?php endforeach ?>
            <div class="clear"></div>
            </div>
            <?php endif ?>
            <?php elseif ($initial): ?>
            <h4 style="border-bottom:none;"><?php echo __('Browse Products by Name') ?></h4>
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $init): ?>
                <?php echo link_to($init, "@products-dir?substitute=$init", $initial == $init ? 'class=_on' : '' )?>
            <?php endforeach ?>
                <?php echo link_to('@', "@products-dir?substitute=@", $initial == '@' ? 'class=_on' : '')?>
            </div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            <div class="hor-filter">
                <?php echo $keyword ? "<div>" . __('Keyword:') . ' ' . link_to($keyword, myTools::remove_querystring_var($sf_request->getUri(), 'keyword'), array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) . "</div>" : "" ?>
                <?php if (count($countries)): ?>
                <div class="clear"><?php echo __('Country:') ?>
                <?php foreach ($countries as $code): ?>
                <?php echo link_to(format_country($code), myTools::remove_querystring_var($sf_request->getUri(), 'country[]', $code), array('class' => 'filter-remove-link', 'title' => __('Remove Country Filter'))) ?>
                <?php endforeach ?>
                </div>
                <?php endif ?>
                <?php if (count($categories)): ?>
                <div class="clear"><?php echo __('Category:') ?>
                <?php foreach ($categories as $cat_id): ?>
                <?php echo link_to(ProductCategoryPeer::retrieveByPK($cat_id), myTools::remove_querystring_var($sf_request->getUri(), 'category[]', $cat_id), array('class' => 'filter-remove-link', 'title' => __('Remove Category Filter'))) ?>
                <?php endforeach ?>
                </div>
                <?php endif ?>
            </div>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <div class="hrsplit-2"></div>
            <div class="clear">
                <?php include_partial("layout_extended", array('pager' => $pager)) ?>
            </div>
            <div class="hrsplit-2"></div>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>