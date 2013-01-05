<div class="col_948">
    <div class="col_180">

<?php include_partial('events') ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('Browse Events by Country') ?></h4>
            <?php $initial = '' ?>
            <ul class="two_columns">
            <?php foreach ($countries as $country): ?>
                <?php if ($initial != myTools::getInitial($country->getName(), true)): ?>
                <?php $initial = myTools::getInitial($country->getName(), true) ?>
                <li style="clear: both; width: 100%; margin-top: 10px; font-size: larger;"><strong><?php echo $initial ?></strong></li>
                <?php endif ?>
                <li><?php echo link_to($country->getName(), "@events-dir?substitute={$country->getStrippedName()}")?></li>
            <?php endforeach ?>
            </ul>
            
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>