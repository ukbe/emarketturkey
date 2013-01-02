<div class="col_948">
    <div class="col_180">

<?php include_partial('venues', array('mod' => $mod)) ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($country): ?>
            <h4 style="border-bottom:none;"><?php echo __('Venues in %1', array('%1' => $country->getName())) ?></h4>
            <?php echo link_to(__('Back to Country List'), '@venues-action?action=byCountry', 'class=bluelink hover') ?>
            <?php elseif ($initial): ?>
            <h4 style="border-bottom:none;"><?php echo __('Browse Venues by Name') ?></h4>
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $init): ?>
                <?php echo link_to($init, "@venues-dir?substitute=$init", $initial == $init ? 'class=_on' : '' )?>
            <?php endforeach ?>
                <?php echo link_to('@', "@venues-dir?substitute=@", $initial == '@' ? 'class=_on' : '')?>
            </div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            <div class="hor-filter">
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@venues-dir?substitute=$substitute&page=$page", array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
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