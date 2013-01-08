<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">

<?php include_partial('leads', array('type_code' => $type_code, 'type_id' => $type_id)) ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __($isbuying ? 'Browse Buying Leads by Country' : 'Browse Selling Leads by Country') ?></h4>
            <?php $initial = '' ?>
            <ul class="two_columns">
            <?php foreach ($countries as $country): ?>
                <?php if ($initial != myTools::getInitial($country->getName(), true)): ?>
                <?php $initial = myTools::getInitial($country->getName(), true) ?>
                <li style="clear: both; width: 100%; margin-top: 10px; font-size: larger;"><strong><?php echo $initial ?></strong></li>
                <?php endif ?>
                <li><?php echo link_to($country->getName(), "@leads-dir?substitute={$country->getStrippedName()}&type_code=$type_code")?></li>
            <?php endforeach ?>
            </ul>
            
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>