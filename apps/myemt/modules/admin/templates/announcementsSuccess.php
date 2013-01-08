<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('tasks/toolbar', array('sesuser' => $sesuser)) ?>

    <div class="col_180">

<?php include_partial('leftmenu', array('sesuser' => $sesuser)) ?>

    </div>

    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            <div class="_noBorder">
                <div class="_right">
                <?php echo pager_links($pager, array('pname' => 'page')) ?>
                </div>
                <div class="_left margin-b2"><?php echo link_to(__('New Announcement'), "@admin-action?action=announcement&act=new", 'class=greenspan led add-11px')?></div>
                <div class="clear">
                    <?php include_partial("layout_announcement", array('pager' => $pager, 'sort' => $sort, 'dir' => $dir)) ?>
                </div>
                <div class="hrsplit-2"></div>
                <div class="_right">
                <?php echo pager_links($pager, array('pname' => 'page')) ?>
                </div>
            </div>

        </div>

    </div>

</div>