<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

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
                <?php echo $keyword ? "<div>" . __('Keyword:') . ' ' . link_to($keyword, myTools::remove_querystring_var($sf_request->getUri(), 'keyword'), array('class' => 'filter-remove-link', 'title' => __('Remove Keyword Filter'))) . "</div>" : "" ?>
                <?php if (isset($countries) && count($countries)): ?>
                <div class="clear"><?php echo __('Country:') ?>
                <?php foreach ($countries as $code): ?>
                <?php echo link_to(format_country($code), myTools::remove_querystring_var($sf_request->getUri(), 'country[]', $code), array('class' => 'filter-remove-link', 'title' => __('Remove Country Filter'))) ?>
                <?php endforeach ?>
                </div>
                <?php endif ?>
                <?php if (isset($industries) && count($industries)): ?>
                <div class="clear"><?php echo __('Industry:') ?>
                <?php foreach ($industries as $sect_id): ?>
                <?php echo link_to(BusinessSectorPeer::retrieveByPK($sect_id), myTools::remove_querystring_var($sf_request->getUri(), 'industry[]', $sect_id), array('class' => 'filter-remove-link', 'title' => __('Remove Industry Filter'))) ?>
                <?php endforeach ?>
                </div>
                <?php endif ?>
                <?php if (isset($btypes) && count($btypes)): ?>
                <div class="clear"><?php echo __('Business Type:') ?>
                <?php foreach ($btypes as $btype): ?>
                <?php echo link_to(BusinessTypePeer::retrieveByPK($btype), myTools::remove_querystring_var($sf_request->getUri(), 'btype[]', $btype), array('class' => 'filter-remove-link', 'title' => __('Remove Business Type Filter'))) ?>
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