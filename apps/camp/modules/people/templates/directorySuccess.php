<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('people', array('mod' => $mod)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($country): ?>
            <h4 style="border-bottom:none;"><?php echo __('People in %1', array('%1' => $country->getName())) ?></h4>
            <?php echo link_to(__('Back to Country List'), '@people-action?action=byCountry', 'class=bluelink hover') ?>
            <?php elseif ($initial): ?>
            <h4 style="border-bottom:none;"><?php echo __('Browse People by Name') ?></h4>
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $init): ?>
                <?php echo link_to($init, "@people-dir?substitute=$init", $initial == $init ? 'class=_on' : '' )?>
            <?php endforeach ?>
                <?php echo link_to('@', "@people-dir?substitute=@", $initial == '@' ? 'class=_on' : '')?>
            </div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            <div class="hor-filter margin-t1">
                <?php echo $keyword ? "<div>" . __('Keyword:') . ' ' . link_to($keyword, myTools::remove_querystring_var($sf_request->getUri(), 'keyword'), array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) . "</div>" : "" ?>
                <?php if (isset($countries) && count($countries)): ?>
                <div class="clear"><?php echo __('Country:') ?>
                <?php foreach ($countries as $code): ?>
                <?php echo link_to(format_country($code), myTools::remove_querystring_var($sf_request->getUri(), 'country[]', $code), array('class' => 'filter-remove-link', 'title' => __('Remove Country Filter'))) ?>
                <?php endforeach ?>
                </div>
                <?php endif ?>
            </div>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <div class="hrsplit-2"></div>
            <div class="clear">
                <?php include_partial("layout_extended", array('pager' => $pager, 'sesuser' => $sesuser, '_here' => $_here)) ?>
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