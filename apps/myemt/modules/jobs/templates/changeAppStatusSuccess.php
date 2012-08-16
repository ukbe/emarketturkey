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
            
            <section id="boxContent">
                <h4 style="border-bottom: none;">
                    <?php echo __('Applicant for <span class="t_green">%1</span>', array('%1' => $job->getTitle())) ?>
                </h4>
                <div class="clear">
<?php $photo = $resume->getPhoto() ?>
<table class="cvcard">
<tr>
    <td class="col1"><?php echo image_tag($resume->getPhotoUri(MediaItemPeer::LOGO_TYP_SMALL)) ?></td>
    <td style="vertical-align: middle;"><strong><?php echo $resume->getUser() ?></strong>
        <div><?php echo __("Are you sure you want to change application status to %1?", array('%1' => '<span class="t_orange">'.UserJobPeer::$statusLabels[$status_id].'</span>')) ?></div>
        </td>
    </tr>
</table>
                </div>
                <div class="greyback ui-corner-all">
                    <div class="circle-bullet margin-r2">1</div>
                    <div><?php echo __('Yes, save status change') . __('') ?>
                        <?php echo form_tag("$jobroute&action=previewCV&act=chgstatus&appid={$app->getId()}") ?>
                        <?php echo input_hidden_tag('status_id', $status_id) ?>
                        <?php echo input_hidden_tag('do', 'commit') ?>
                        <div class="pad-3">
                            <?php echo radiobutton_tag('notify', 1, true, array('id' => 'notify_yes')) ?>
                            <?php echo emt_label_for('notify_yes', __('Send notification message to applicant.')) ?>
                                <dl id="template-data" class="_table">
                                    <dt><?php echo emt_label_for('template_id', __('Message Template')) ?></dt>
                                    <dd><?php echo select_tag('template_id', options_for_select($profile->getOrderedMessageTemplatesFor($status_id), $template->getId())) ?></dd>
                                    <dt><?php echo emt_label_for('message_content', __('Message')) ?></dt>
                                    <?php foreach ($templates as $temp): ?>
                                    <?php $ln = $resume->getUser()->getPreferredCulture($temp->getDefaultLang()) ?>
                                    <dd id="template_<?php echo $temp->getId() ?>" style="width: 530px;"<?php echo $template->getId() != $temp->getId() ? ' class="ghost"' : '' ?>><?php echo str_replace(array("\n", "#uname", "#oname", "#joblink", "#jobtitle") , array("<br />", $resume->getUser(), '<strong>'.$profile->getName().'</strong>', link_to($job->getDisplayTitle($ln), $job->getUrl()), $job->getDisplayTitle($ln)), $temp->getClob(JobMessageTemplateI18nPeer::CONTENT, $ln)) ?></dd>
                                    <?php endforeach ?>
                                </dl>
                            <div class="clear">
                            </div>
                            <?php echo radiobutton_tag('notify', 0, false, array('id' => 'notify_no')) ?>
                            <?php echo emt_label_for('notify_no', __('Do not send notification.')) ?>
                            <div class="hrsplit-3"></div>
                            <?php echo submit_tag(__('Apply Status Change'), "class=green-button") ?>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="pad-3">
                    <div class="circle-bullet margin-r2">2</div>
                    <div><?php echo link_to(__('No, cancel status change'), "$jobroute&action=previewCV&appid={$app->getId()}", 'class=t_blue larger') ?></div>
                </div>
                
            </section>
        </div>
    </div>

</div>
<?php use_javascript('jquery.customCheckbox.js'); ?>
<?php echo javascript_tag("
$(function() {
    $('#boxContent input').customInput();

    $('#template_id').change(function(){ $('#template-data dd[id^=template_]').hide();$('#template-data dd[id=template_'+$(this).val()+']').show(); });
    
    $('input[type=radio][name=notify]').click(function(){if ($(this).val()!=1) $('#template-data').addClass('t_grey').find('input,select,textarea').attr('disabled', true); else $('#template-data').removeClass('t_grey').find('input,select,textarea').attr('disabled', false);});
});
") ?>