<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('group/account', array('group' => $group)) ?>
        </div>

    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
            <?php if ($typ == 'parent'): ?>
            <h4><?php echo __('Select Parent Group') ?></h4>
            <?php elseif ($typ == 'subsidiary'): ?>
            <h4><?php echo __('Select Subsidiary Group') ?></h4>
            <?php else: ?>
            <h4><?php echo __('Select Parent or Subsidiary Group') ?></h4>
            <?php endif ?>
            <?php echo __('Please select the group which you want to setup a relation with.') ?>
            <div class="hrsplit-2"></div>
            <?php echo __('If the group you have been searching is not listed, then please repeat search by providing more details.') ?>
            <div class="hrsplit-2"></div>
            <?php echo form_tag("@group-account?action=relations&act=$act&hash={$group->getHash()}") ?>
            <dl class="_table">

                <dt><?php echo emt_label_for("relation_keyword", __('Group Name')) ?></dt>
                <dd><?php echo input_tag("relation_keyword", $sf_params->get('relation_keyword'), array('style' => 'width:200px;', 'maxlength' => 255)) ?></dd>
                <dd><?php echo input_hidden_tag("group_id", $sf_params->get('group_id')) ?></dd>
                <dt></dt>
                <dd><?php echo submit_tag(__('Search Group'), 'class=green-button') ?>&nbsp;&nbsp;
                        <?php echo link_to(__('Cancel'), "@group-account?action=relations&hash={$group->getHash()}", 'class=inherit-font bluelink hover') ?></dd>
            </dl>
            </form>
            <table class="pdd">
            <?php foreach ($groups as $grp): ?>
                <tr><td><?php echo link_to(__('Select'), "@group-account?action=relations&act=add&typ={$typ}&group_id={$grp->getId()}&hash={$group->getHash()}", 'class=selector') ?></td><td><?php include_partial('group/group', array('group' => $grp)) ?></td></tr>
            <?php endforeach ?>
            </table>
            <style>
                .pdd td { padding: 10px; margin: 10px; }
                .pdd tr:hover { background-color: #fffbe2; }
                .pdd tr a.selector { border: solid 1px; background-color: #2e395c; color: #fff;  padding: 3px 5px; }
            </style>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <?php include_partial('group/upgradeBox', array('group' => $group)) ?>
    </div>

</div>