<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('tradeexperts', array('mod' => $mod)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($country): ?>
            <h4 style="border-bottom:none;"><?php echo __('Trade Experts for %1 Market', array('%1' => $country->getName())) ?></h4>
            <?php echo link_to(__('Back to Country List'), '@tradeexperts-action?action=byCountry', 'class=bluelink hover') ?>
            <?php elseif ($industry): ?>
            <h4 style="border-bottom:none;"><?php echo __('Trade Experts related to %1 Industry', array('%1' => $industry)) ?></h4>
            <?php echo link_to(__('Back to Industry List'), '@tradeexperts-action?action=byIndustry', 'class=bluelink hover') ?>
            <?php elseif ($initial): ?>
            <h4 style="border-bottom:none;"><?php echo __('Browse Trade Experts by Name') ?></h4>
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $init): ?>
                <?php echo link_to($init, "@tradeexperts-dir?substitute=$init", $initial == $init ? 'class=_on' : '' )?>
            <?php endforeach ?>
                <?php echo link_to('@', "@tradeexperts-dir?substitute=@", $initial == '@' ? 'class=_on' : '')?>
            </div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            <div class="hor-filter">
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@tradeexperts-dir?substitute=$substitute&page=$page", array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
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