<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('companies') ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('Browse Companies by Industry') ?></h4>
            <?php $initial = '' ?>
            <ul class="two_columns">
            <?php foreach ($industries as $industry): ?>
                <?php if ($initial != myTools::getInitial($industry->getName(), true)): ?>
                <?php $initial = myTools::getInitial($industry->getName(), true) ?>
                <li style="clear: both; width: 100%; margin-top: 10px; font-size: larger;"><strong><?php echo $initial ?></strong></li>
                <?php endif ?>
                <li><?php echo link_to($industry, "@companies-dir?substitute={$industry->getStrippedName()}")?></li>
            <?php endforeach ?>
            </ul>
            
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>