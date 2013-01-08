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
            <h4 style="border-bottom:none;"><?php echo __($isbuying ? 'Latest Buying Leads' : 'Latest Selling Leads') ?></h4>
            <div class="clear">
                <?php include_partial("layout_extended", array('results' => $latest)) ?>
            </div>
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>