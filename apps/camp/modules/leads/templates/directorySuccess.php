<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">

<?php include_partial('leads', array('type_code' => $type_code, 'type_id' => $type_id, 'mod' => $mod)) ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($country): ?>
            <h4 style="border-bottom:none;"><?php echo __($isbuying ? 'Buying Leads from %1' : 'Selling Leads from %1', array('%1' => $country->getName())) ?></h4>
            <?php echo link_to(__('Back to Country List'), "@leads-action?action=byCountry&type_code=$type_code", 'class=bluelink hover') ?>
            <?php elseif ($category): ?>
            <h4 style="border-bottom:none;"><?php echo __($isbuying ? 'Buying Leads in %1 Category' : 'Sellign Leads in %1 Category', array('%1' => $category)) ?></h4>
            <?php echo link_to(__('Back to Category List'), "@leads-action?action=byCategory&type_code=$type_code", 'class=bluelink hover') ?>
            <?php elseif ($initial): ?>
            <h4 style="border-bottom:none;"><?php echo __($isbuying ? 'Browse Buying Leads by Name' : 'Browse Selling Leads by Name') ?></h4>
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $init): ?>
                <?php echo link_to($init, "@leads-dir?substitute=$init&type_code=$type_code", $initial == $init ? 'class=_on' : '' )?>
            <?php endforeach ?>
                <?php echo link_to('@', "@leads-dir?substitute=@&type_code=$type_code", $initial == '@' ? 'class=_on' : '')?>
            </div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            <div class="hor-filter">
                <?php echo $keyword ? __('Keyword:') . ' ' . link_to($keyword, "@leads-dir?substitute=$substitute&type_code=$type_code&page=$page", array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) : "" ?>
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