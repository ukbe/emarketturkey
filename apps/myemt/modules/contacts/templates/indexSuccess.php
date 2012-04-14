<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="box_948" style="overflow: visible;">
    <h4 class="margin-t1">
        <div class="_right" style="margin-top: -5px;">
            <div class="select margin-b1">
            <span><?php echo __('View:') ?><span class="selected<?php echo $role ? ' bold' : '' ?>"><?php echo $role ? $labels[$role_name] : __('Select List') ?></span></span>
            <ul>
                <?php foreach ($labels as $key => $label): ?>
                <?php if ($key != $role_name): ?>
                <li><?php echo link_to($label, "@contacts?relation=$key") ?></li>
                <?php endif ?>
                <?php endforeach ?>
            </ul></div></div>
        <?php echo __('My Connections') ?>
    </h4>
    </div>
    <div class="col_180">
        <div class="box_180"></div>
<?php // include_partial("leftmenu_$role_name", array('sesuser' => $sesuser)) ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <?php /* ?>
                <h4 class="margin-t1">
            <div class="indexlinks">
            <?php foreach (($alp = range('A', 'Z')) as $key => $initial): ?>
                <?php echo link_to($initial, "@contacts?relation=$role_name&substitute=$initial")?>
            <?php endforeach ?>
                <?php echo link_to('@', "@contacts?relation=$role_name&substitute=@")?>
            </div>
                </h4>
                <?php */ ?>
                <div class="contact-list">
                <div class="hrsplit-1"></div>
                <div class="_right">
                <?php echo pager_links($pager, array('pname' => 'page')) ?>
                </div>
                <div class="clear">
                    <?php include_partial("layout_extended_$partial_name", array('pager' => $pager)) ?>
                </div>
                <div class="hrsplit-2"></div>
                <div class="_right">
                <?php echo pager_links($pager, array('pname' => 'page')) ?>
                </div>
                </div>
            </section>

        </div>

    </div>

    <div class="col_180">
    </div>
</div>
