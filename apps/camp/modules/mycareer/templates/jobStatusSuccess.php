<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php include_partial('global/subNav_hr') ?>
<?php end_slot() ?>

<?php slot('footer') ?>
<?php include_partial('global/footer_hr') ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="breadcrumb">
        <ul>
            <li><?php echo link_to(__('My Jobs'), '@myjobs') ?></li>
            <li><?php echo link_to(__('Applied Jobs'), '@myjobs-applied') ?></li>
            <li><span><?php echo $job ?></span></li>
        </ul>
    </div>

    <div class="col_180">
    <?php if ($photo = $resume->getPhoto()): ?>
        <div class="box_180 txtCenter">
            <a class="editable-image" href="<?php echo url_for('@mycv-action?action=materials') ?>">
                <?php echo image_tag($photo->getMediumUri()) ?>
                <span class="edittag"><?php echo __('Change Photo') ?></span>
            </a>
        </div>
    <?php endif ?>
        <div class="col_180">
<?php include_partial('leftmenu', array('sesuser' => $sesuser))?>
        </div>

    </div>

    <div class="col_762">

        <div class="box_762">
            <h4>
                <div class="t_green"><?php echo $job ?></div>
                <div class="_right t_larger t_grey"><?php echo __('Job Application Status') ?></div>
                <span class="t_smaller t_grey"><?php echo $job->getOwner()->getHRProfile()->getName() ?></span>
            </h4>
            <div class="_noBorder pad-0">
                <div class="bubble ui-corner-all pad-2"><?php echo __('You have applied for this job at <strong>%1date</strong>.', array('%1date' => format_date($ujob->getCreatedAt('U'), 'f'))) ?></div>
                <div class="hrsplit-3"></div>
                <dl class="_table _noInput">
                    <?php if (isset($confirmterm)): ?>
                    <div class="pad-3 t_red">
                    <?php echo __('Are you sure you want to terminate your job application?') . link_to(__('Yes, Terminate!'), "@myjobs-applied-view?guid={$job->getGuid()}&act=term&do=commit&has=$confirmterm", 'class=action-button margin-l2 margin-r2 id=terminate') ?>
                    <?php echo link_to(__('Cancel'), "@myjobs-applied-view?guid={$job->getGuid()}", 'class=bluelink inherit-font hover') ?>
                    </div>
                    <?php endif ?>
                    <dt><?php echo emt_label_for('unatt', __('Status'). ':')?></dt>
                    <dd style="font-size: 18px;" class="t_orange">
                        <?php if (!isset($confirmterm) && in_array($ujob->getStatusId(), array(UserJobPeer::UJ_STATUS_EVALUATING, UserJobPeer::UJ_STATUS_PENDING))): ?>
                        <?php echo link_to(__('Terminate'), "@myjobs-applied-view?guid={$job->getGuid()}&act=term", 'class=action-button _right margin-l2 id=terminate') ?>
                        <?php endif ?>
                        <?php echo __(UserJobPeer::$statusLabels[$ujob->getStatusId()]) ?>
                    </dd>
                </dl>
                <div class="hrsplit-1"></div>
                <h4><?php echo __('Messagings') ?></h4>
                <div class="conversation">
                <?php foreach ($ujob->getMessagings()->getResults() as $message): ?>
                    <div class="transaction<?php echo ($message->getSenderTypeId() == PrivacyNodeTypePeer::PR_NTYP_USER && $message->getSender()->getID() == $sesuser->getId()) ? ' east' : ' west' ?>">
                        <div class="nodetag">
                            <?php echo image_tag($message->getSender()->getProfilePictureUri()) ?>
                            <span class="name"><?php echo $message->getSender() ?></span>
                            <span class="date"><?php echo format_date($message->getCreatedAt('U'), 'f') ?></span>
                        </div>
                        <div class="balloon"><?php echo $message->getBody() ?></div>
                    </div>
                <?php endforeach?>
                <?php if (in_array($ujob->getStatusId(), array(UserJobPeer::UJ_STATUS_EVALUATING, UserJobPeer::UJ_STATUS_PENDING))): ?>
                    <?php echo form_tag("@myemt.compose-message", 'class=ajax-enabled id=messageform') ?>
                    <?php echo input_hidden_tag('_ref', $_here) ?>
                    <?php echo input_hidden_tag('_s', $sesuser->getPlug()) ?>
                    <?php echo input_hidden_tag('_r', $job->getOwner()->getPlug()) ?>
                    <?php echo input_hidden_tag('_o', $job->getPlug()) ?>
                    <div class="transaction east">
                        <div class="nodetag">
                            <?php echo image_tag($sesuser->getProfilePictureUri()) ?>
                            <span class="name"><?php echo $sesuser ?></span>
                        </div>
                        <div class="balloon">
                            <?php echo textarea_tag("message", "", 'cols=50 rows=6') ?>
                            <?php echo submit_tag(__('Send'), 'class=green-button id=messageform-submit')?>
                        </div>
                    </div>
                    </form>
                <?php endif ?>
                </div>
            </div>
        </div>

    </div>

</div>
<?php echo javascript_tag("
$(function() {
    $('#terminate').dynabox({clickerOpenClass: '_btn_up', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
        loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, position: 'window'
    });
});
") ?>