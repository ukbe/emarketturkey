<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('members/members', array('group' => $group)) ?>
        </div>
<?php $route = "@group-members?hash={$group->getHash()}&action=list" ?>
    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Messaging') ?></h4>
                
                <?php foreach ($undelivered as $ann): ?>
                <?php echo $ann->getContentForRecipient(15, 1) ?>
                <?php endforeach ?>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White" style="margin-top: 42px;">
            <h3><?php echo __('Messaging Options') ?></h3>
            <div>
                <ul class="side-menu">
                    <li><?php echo link_to(__('Send Message'), "@compose-message?_s={$group->getPlug()}&_ref=$_here", 'id=send-message style=background: url(/images/layout/icon/led-icons/email.png) no-repeat 1px center; padding-left: 22px;') ?></li>
                    <li><?php echo link_to(__('Send SMS'), '@homepage', 'style=background: url(/images/layout/icon/sms_message.png) no-repeat 0px center; padding-left: 22px;') ?></li>
                    <li><?php echo link_to(__('Make Announcement'), '@homepage', 'style=background: url(/images/layout/icon/blue_circle_email-16px.png) no-repeat 1px center; padding-left: 22px;') ?></li>
                </ul>
            </div>
        </div>
    </div>

</div>
    