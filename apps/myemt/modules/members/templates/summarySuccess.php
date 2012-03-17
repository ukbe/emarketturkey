<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('members/members', array('group' => $group)) ?>
        </div>

    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Summary') ?></h4>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <div class="box_180 _WhiteBox">
        <h3><?php echo __('Invite to Group') ?></h3>
        <div>
            <?php echo __('Send invitation to people or companies to join your group.') ?>
            <div class="hrsplit-1"></div>
            <?php echo link_to(__('Invite to Group'), "@group-members?action=invite&hash={$group->getHash()}", 'class=green-button margin-t2') ?>
        </div>
        </div>
        <?php /*?>
        <div class="clear pad-1">
        <a href="http://www.emarketturkey.com" class="hoverborder">
            <h3 style="background: url(/images/layout/icon/blue_circle_email.png) no-repeat left top; padding-left: 33px; font: 14px tahoma; height: 26px; color: #444; margin-top: 0px;">
                <?php echo __('Make Announcement') ?></h3>
            <div style="padding-left: 33px; font: 11px tahoma; color: #777; margin-top: 8px;">
                <?php echo __('Send message to all your group members at once.') ?>
            </div>
        </a>
        </div>
        */ ?>
        </div>
    </div>

</div>
    