<div class="col_948">
    <div class="col_180">

<?php include_partial('venues') ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <h4 style="border-bottom:none;"><?php echo __('Browse Venues by Name') ?></h4>
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $initial): ?>
                <?php echo link_to($initial, "@venues-dir?substitute=$initial")?>
            <?php endforeach ?>
                <?php echo link_to('@', "@venues-dir?substitute=@")?>
            </div>
            <div class="hrsplit-3"></div>
            <div class="pad-3 bubble ui-corner-all">
                <?php echo __('Click a link above to browse trade shows by name.') ?>
            </div>
            
            </section>
        </div>

    </div>

    <div class="col_180">
    </div>

</div>