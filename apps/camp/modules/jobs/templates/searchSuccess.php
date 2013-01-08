<?php slot('subNav') ?>
<?php include_partial('global/subNav_hr') ?>
<?php end_slot() ?>

<?php slot('footer') ?>
<?php include_partial('global/footer_hr') ?>
<?php end_slot() ?>

<div class="col_948" style="min-height: 450px;">
<?php include_partial('global/jobs_search_bar', array('params' => $params, 'open' => !$commit)) ?>

    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            <section>
            <?php if ($commit): ?>
            <h4 style="border-bottom:none;"><?php echo isset($params['keyword']) ? __('Search Results for Keyword "%1str"', array('%1str' => $params['keyword'])) : __('Search Results') ?></h4>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <div class="hrsplit-1"></div>
            <div class="clear">
                <?php include_partial("layout_extended", array('pager' => $pager)) ?>
            </div>
            <div class="hrsplit-1"></div>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <div class="hrsplit-3"></div>
            <?php endif ?>
            </section>
        </div>

    </div>

    <div class="col_180">
    
        <div class="box_180 _titleBG_White">
            <?php if ($commit): ?>
            <h3><?php echo __('Filter Results') ?></h3>
            <div>
                <ul class="search-filter">
                <?php foreach ($filter->getSections() as $section): ?>
                    <li><span><?php echo $section->getLabel() ?></span>
                        <ul>
                        <?php foreach ($section->getItems() as $item): ?>
                            <li><?php echo link_to($item->getLabel(), myTools::remove_querystring_var($sf_request->getUri(), $section->getFormId(), $item->getValue()), array('title' => __('Remove %1f Filter', array('%1f' => $section->getLabel())))) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
                </ul>
            </div>
            <?php endif ?>
        </div>

    </div>

    <div class="timer-bottom-line"><?php echo __('load time: %1t ms', array('%1t' => number_format($timer->getElapsedTime(), 2))) ?></div>
</div>