<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('companies', array('mod' => $mod)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($country): ?>
            <h4 style="border-bottom:none;"><?php echo __('Companies in %1', array('%1' => $country->getName())) ?></h4>
            <?php echo link_to(__('Back to Country List'), '@companies-action?action=byCountry', 'class=bluelink hover') ?>
            <?php elseif ($industry): ?>
            <h4 style="border-bottom:none;"><?php echo __('Companies in %1 Industry', array('%1' => $industry)) ?></h4>
            <?php echo link_to(__('Back to Industry List'), '@companies-action?action=byIndustry', 'class=bluelink hover') ?>
            <?php elseif ($initial): ?>
            <h4 style="border-bottom:none;"><?php echo __('Browse Companies by Name') ?></h4>
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $init): ?>
                <?php echo link_to($init, "@companies-dir?substitute=$init", $initial == $init ? 'class=_on' : '' )?>
            <?php endforeach ?>
                <?php echo link_to('@', "@companies-dir?substitute=@", $initial == '@' ? 'class=_on' : '')?>
            </div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            <div class="hor-filter margin-t1">
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@companies-dir?substitute=$substitute&page=$page", array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
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