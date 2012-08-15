<?php use_helper('Date', 'Number') ?>
<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>
<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            
            <section>
                <h4 style="border-bottom: none;">
                    <div class="_right">
                        <span class="btn_container ui-smaller" style="position: relative;top: auto; right: auto; float: right; margin-left: 10px;">
                        <?php echo $prevnext['PREV_ID'] ? link_to('&nbsp;', "$jobroute&action=previewCV&appid=".$prevnext['PREV_ID'], array('class' => 'left-arrow', 'title' => __('Previous Applicant'))) : '' ?>
                        <?php echo $prevnext['NEXT_ID'] ? link_to('&nbsp;', "$jobroute&action=previewCV&appid=".$prevnext['NEXT_ID'], array('class' => 'right-arrow', 'title' => __('Next Applicant'))) : '' ?>
                        </span>
                        <?php echo link_to(__('Back to Applicants'), "$jobroute&action=applicants", "class=bluelink") ?>
                        </div>
                    <?php echo __('Applicant for <span class="t_green">%1</span>', array('%1' => $job->getTitle())) ?>
                    <div><span class="tag trail-right-11px"><?php echo __('Applied at %1', array('%1' => format_datetime($app->getCreatedAt('U'), 'f'))) ?></span>
                     </div>
                </h4>
                <div class="clear">
<div id="cv-preview">
<div class="flagger _right">
<div>
<div class="items">
<?php echo link_to(__('Ignore'), "$jobroute&action=previewCV&appid={$app->getId()}&act=ignore", 'class=act a16px hand' . ($app->getFlagType() == UserJobPeer::UJ_EMPLYR_FLAG_IGNORE ? ' flagged' : '')) ?>
<?php echo link_to(__('Favourite'), "$jobroute&action=previewCV&appid={$app->getId()}&act=fav", 'class=act a16px star' . ($app->getFlagType() == UserJobPeer::UJ_EMPLYR_FLAG_FAVOURITE ? ' flagged' : '')) ?>
<?php echo link_to(__('None'), "$jobroute&action=previewCV&appid={$app->getId()}&act=unflag", 'class=act a16px' . (!$app->getFlagType() ? ' flagged' : '')) ?>
</div>
<div><?php echo __('Flag:') ?></div>
</div>
</div>
<div>
<?php echo link_to(__('Print'), 'mycareer/print', 'class=act a16px print') ?>
<?php echo link_to(__('Export<span id="CV"></span>'), 'mycareer/print', 'class=act a16px pdf') ?>
</div>
<div class="hrsplit-2"></div>
<table class="cvcard">
<tr>
    <td class="col1"><?php echo image_tag($app->getUser()->getProfilePictureUri()) ?></td>
    <td class="col2"><?php echo $app->getUser() ?>
        <table class="notepad">
        <tr><td><label><?php echo __('Birth Date') ?></label><?php echo format_date($app->getUser()->getBirthDate('U'), 'D') ?></td></tr>
        <tr><td><label><?php echo __('Gender / Marital Status') ?></label><?php echo __(UserProfilePeer::$Gender[$app->getUser()->getGender()]) . ($app->getUser()->getUserProfile() ? ' / ' . __(UserProfilePeer::$MaritalStatus[$app->getUser()->getUserProfile()->getMaritalStatus()]) : '') ?></td></tr>
        <tr><td><label><?php echo __('E-mail') ?></label><?php echo __('Not Specified') ?></td></tr>
        <tr><td><label><?php echo __('Phone Number') ?></label><?php echo __('Not Specified') ?></td></tr>
        <tr><td><label><?php echo __('Address') ?></label><?php echo __('Not Specified') ?></td></tr>
        <tr><td><label><?php echo __('Employment Status') ?></label><?php echo __('Not Specified') ?></td></tr>
        </table></td>
    <td class="col3">
        <div class="_dotted">
            <div class="_right t_orange"><?php echo $app->getStatusId() !== 0 ? __(UserJobPeer::$statusLabels[$app->getStatusId()]) : __('Pending') ?></div>
            <?php echo __('Current Status:') ?>
            <div class="clear"></div>
            <div class="stat-chg-switch _right"><?php echo link_to_function(__('change'), "$('.stat-chg-switch, .folder-chg-box').hide();$('.stat-chg-box, .folder-chg-switch').show();", 'class=bluelink') ?></div>
            <div class="stat-chg-box ghost">
                <?php echo __("Please select a new status for %1's application:", array('%1' => $app->getUser())) ?>
                <div class="hrsplit-1"></div>
                <?php echo form_tag("$jobroute&action=previewCV", 'method=GET') ?>
                <?php echo input_hidden_tag('appid', $app->getId()) ?> 
                <?php echo input_hidden_tag('act', 'chgstatus') ?> 
                <?php echo select_tag('status_id', options_for_select(UserJobPeer::$statusLabels, $app->getStatusId(), array('include_custom' => __('Please Select')))) ?>
                <div class="hrsplit-1"></div>
                <div class="_right"><?php echo link_to_function(__('cancel'), "$('.stat-chg-switch').show();$('.stat-chg-box').hide();", 'class=bluelink') ?></div>
                <?php echo submit_tag(__('Save Status'), 'class=green-button smaller') ?>
                </form>
            </div>
            <div class="clear"></div>
        </div>
        </td>
    </tr>
</table>
</div>

<?php echo error_message("This user does not have a CV.") ?>

                </div>
            </section>
        </div>
    </div>

</div>
<?php echo javascript_tag("
$(function() {
    $('#folder_id').branch({method: 'class', map: {new: '#folder_name'}});
});
") ?>