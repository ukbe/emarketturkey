<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_678">
        <div class="box_678 _titleBG_Transparent _noBorder">
<style>
    .post-box ol.selecterlist
    {
        margin: 0px;
        padding: 0px;
    }
    .post-box ol.selecterlist li
    {
        height: 24px;
        background-image: none;
        margin: 0px;
    }
    .post-box ol.selecterlist li.selected
    {
        background: url(/images/layout/wall/post-indicator.png) no-repeat 11px bottom;
    }
    .post-box ol.selecterlist a
    {
        display: inline-block;
        border: none;
        text-decoration: none;
        color: #4772A7;
        font: 11px tahoma;
        vertical-align: middle;
        padding: 2px 2px;
        margin: 0px 8px;
        line-height: 13px;
    }
    .post-box ol.selecterlist img
    {
        border: none;
        margin: 0px 4px 0px 0px;
        vertical-align: middle;
    }
    .post-box ol.selecterlist a span
    {
        vertical-align: middle;
    }
    .post-box #target-box .bordered
    {
        border: solid 1px #88BCDF;
        margin-top: 23px;
        padding: 0px;
    }
    .post-box #target-box form
    {
        margin: 0px;
        padding: 0px;
    }
    .post-box #target-box div.p-status
    {
        padding: 0px;
    }
    .post-box #target-box div.p-status #msg, .clone-textarea
    {
        font: 12px arial;
        outline: none;
        width: 710px;
        margin: 0px;
        resize: none;
        padding: 3px;
        overflow: hidden;
        border: none;
        min-height: 16px;
    }
    .post-box #target-box div.p-link #plink
    {
        font: 12px arial;
        outline: none;
        width: 100%;
        margin: 0px;
        padding: 3px;
        min-height: 16px;
    }
    
</style>


<div class="column span-144 prepend-1 append-2 post-box">
<ol class="selecterlist column span-144" style="padding: 0px;margin: 0px;">
<li class="column"><?php echo __('Share :') ?></li>
<li id="p-status" class="column selected"><?php echo link_to_function(image_tag('layout/wall/post-status.png').'<span>'.__('Status').'</span>','') ?></li>
<?php /* ?>
<li id="p-link" class="column"><?php echo link_to_function(image_tag('layout/wall/post-link.png').'<span>'.__('Link').'</span>','') ?></li>
<li id="p-video" class="column"><?php echo link_to_function(image_tag('layout/wall/post-video.png').'<span>'.__('Video').'</span>','') ?></li>
*/ ?>
<li id="p-location" class="column"><?php echo link_to_function(image_tag('layout/wall/post-location.png').'<span>'.__('Location').'</span>','') ?></li>
<?php /* ?>
<li id="p-job" class="column"><?php echo link_to_function(image_tag('layout/wall/post-job.png').'<span>'.__('Job').'</span>','') ?></li>
<li id="p-opportunity" class="column"><?php echo link_to_function(image_tag('layout/wall/post-opportunity.png').'<span>'.__('Opportunity').'</span>','') ?></li>
 */ ?>
</ol>
<div id="target-box">
<div class="p-status">
<?php echo form_tag('profile/updateStatus') ?>
<div class="bordered">
<?php echo textarea_tag('msg', '', 'class=span-145 rows=1') ?>
<?php echo javascript_tag("
var tx='".__('Type your status message ..')."'; 
jQuery('.p-status #msg').focus(function(){if (jQuery(this).val()==tx) jQuery(this).removeClass('blurred-input-tip').val('');});
jQuery('.p-status #msg').blur(function(){if (jQuery(this).val()=='') jQuery(this).addClass('blurred-input-tip').val(tx);}).blur();
") ?>
</div>
<div class="out-p-status p-status-post a-right ghost-sub" style="margin-top: 5px;">
<span id="p-status-error" class="ghost"><?php echo __('Error Occured!') ?></span>
<?php if_javascript(); ?>
<?php echo submit_to_remote('status-message-post', __('Share'), array(
                    'url' => '/profile/updateStatus',
                    'update' => 'status-message',
                    'success' => "jQuery('.p-status #msg').val('');jQuery('div#target-box #msg').keyup();jQuery('.activity').update();",
                    'script' => true,
                    'before' => "jQuery('#p-status-error').hide()",
                    'failure' => "jQuery('#p-status-error').show()"), array('type' => 'link', 'class' => 'nice')) ?>
<?php end_if_javascript(); ?>
<noscript><?php echo submit_tag(__('Share')) ?></noscript>
</div>
</form>
</div>
<div class="p-link ghost bordered">
<?php echo form_tag('profile/post?type='.PrivacyNodeTypePeer::PR_NTYP_POST_LINK) ?>
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="vertical-align: middle; text-align: left;">
<tr>
<td><?php echo input_tag('plink', '', "style=margin: 4px;") ?>
<?php echo javascript_tag("
var px='".__('http://')."';
jQuery('.p-link #plink').focus(function(){if (jQuery(this).val()==px) jQuery(this).removeClass('blurred-input-tip').val('');});
jQuery('.p-link #plink').blur(function(){if (jQuery(this).val()=='') jQuery(this).addClass('blurred-input-tip').val(px);}).blur();
") ?></td>
<td><?php echo submit_tag(__('Share')) ?></td>
</tr>
</table>
</form>
</div>
</div>
<?php echo javascript_tag("
jQuery('.post-box a').click(function(){
    jQuery('.post-box li').removeClass('selected');
    jQuery(this).closest('li').addClass('selected');
    jQuery('div#target-box div[class^=\"p-\"]').addClass('ghost');
    jQuery('div[class^=\"out-\"]').addClass('ghost');
    jQuery('div#target-box div.'+jQuery(this).closest('li').attr('id')).removeClass('ghost');
    jQuery('div.out-'+jQuery(this).closest('li').attr('id')).removeClass('ghost');
});
function FitToContent(id, maxHeight)
{
   var text = id && id.style ? id : document.getElementById(id);
   if (!text) return;
   jQuery('#clonediv').html(jQuery(text).val().replace(/\\n$/g, '<br />&nbsp;').replace(/\\n/g, '<br />'));
   jQuery(text).height(jQuery('#clonediv').height());
}

window.onload = function() {
    jQuery('div#target-box #msg').keyup(function() {
        FitToContent(this);
      });
    jQuery('div#target-box #msg').focus(function(){jQuery('.p-status-post').removeClass('ghost-sub');});
    };

") ?>
<div id="clonediv" class="clone-textarea ghost" style="word-wrap: break-word;"></div>
</div>
<div class="hrsplit-1"></div>
<div class="append-1">
<h3 style="font: bold 13px 'trebuchet ms'; color: #4D4D4D; border-bottom: solid 2px #F1F1F1;padding: 3px 5px;margin-bottom: 10px;"><?php echo __('Updates') ?>&nbsp;<?php echo link_to_function(__('(refresh)'), "jQuery('.activity').update(0);", 'class=action') ?></h3>
<?php include_partial('network/network_activity', array('activities' => $activities)) ?>
</div>
        
        </div>
    </div>

    <div class="col_264">
        <div class="box_264">
            <h3><?php echo __('Companies') ?>
            <?php echo link_to(__('Add Company'), '@register-comp', 'class=action') ?></h3>
            <div>
            <?php if (count($companies)): ?>
            <ol class="column span-45" style="padding: 0px; margin: 0px;">
            <?php foreach ($companies as $company): ?>
            <li class="column span-10 append-2 first">
            <?php echo link_to(image_tag($company->getProfilePictureUri()), $company->getProfileUrl()) ?>
            </li>
            <li class="column span-33">
            <?php echo link_to($company->getName(), $company->getProfileUrl()) ?><br />
            <em class="tip"><?php echo $company->getBusinessSector() ?></em><br />
            <?php echo link_to(__('Manage'), '@company-manage?hash='.$company->getHash()) ?>
            </li>
            <?php endforeach ?>
            </ol>
            <?php else: ?>
            <?php echo __('A large number of companies use eMarketTurkey B2B for their business operations.') ?>
            <div class="hrsplit-1"></div>
            <?php echo __('Register your company and get listed on eMarketTurkey B2B Directory.') ?>
            <div class="hrsplit-1"></div>
            <?php echo link_to(__('Register Your Company'), '@register-comp') ?>
            <?php endif ?>
            </div>
        </div>
        
        <div class="box_264">
            <h3><?php echo __('Groups') ?>
            <?php echo link_to(__('Add Group'), '@group-start', 'class=action') ?></h3>
            <div>
            <?php if (count($groups)): ?>
            <ol class="column span-45" style="padding: 0px; margin: 0px;">
            <?php foreach ($groups as $group): ?>
            <li class="column span-10 append-2 first">
            <?php echo link_to(image_tag($group->getProfilePictureUri()), $group->getProfileUrl()) ?>
            </li>
            <li class="column span-33">
            <?php echo link_to($group->getName(), $group->getProfileUrl()) ?><br />
            <em class="tip"><?php echo __('%1 Members', array('%1' => $group->countMembers())) ?></em><br />
            <?php echo link_to(__('Manage'), '@group-manage?action=manage&hash='.$group->getHash()) ?>
            </li>
            <?php endforeach ?>
            </ol>
            <?php else: ?>
            <?php echo __('Business groups, alumni groups or even social organisations get connected on eMarketTurkey Community.') ?>
            <div class="hrsplit-1"></div>
            <?php echo __('You can start your own group and invite friends in your network.') ?>
            <div class="hrsplit-1"></div>
            <?php echo link_to(__('Start Your Group'), '@group-start') ?>
            <?php endif ?>
            </div>
        </div>
        
        <?php $advises = $sesuser->getSuggestedFriendsPager(null, true, 3) ?>
        <?php if (count($advises)): ?>
        <div class="box_264">
            <h3><?php echo __('People You May Know') ?>
            <?php echo link_to(__('See All'), '@cm.pymk', 'class=action') ?></h3>
            <div>
            <ol class="column span-45" style="padding: 0px; margin: 0px;">
            <?php $myfriends = $sesuser->getFriends() ?>
            <?php foreach ($advises as $friend): ?>
            <li class="column span-10 append-2 first">
            <?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?>
            </li>
            <li class="column span-33">
            <?php echo link_to($friend, $friend->getProfileUrl(), 'class=name') ?><br />
            <?php 
                    $hisfriends = $friend->getFriends();
                    $comm = array_intersect($hisfriends, $myfriends);
                    $fcount = count($comm);
             ?>
            <em class="tip"><a href="<?php echo "#TB_inline?height=155&width=400&inlineId=commonFriend_{$friend->getId()}" ?>" class="thickbox"><?php echo format_number_choice(__('[0]No common friends|[1]%1 friend in common|(1,+Inf]%1 friends in common'), 
                             array('%1' => $fcount), $fcount) ?></a></em><br />
            <?php if (!$friend->isFriendsWith($sesuser->getId()) && $sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $friend)) 
                        echo link_to(__('Add as Friend'), 'network/add', array('query_string' => 'cid='.$friend->getId().'&width=560&height=220', 'class' => 'thickbox action plus')) ?>
            <div id="commonFriend_<?php echo $friend->getId() ?>" class="ghost">
            <table cellspacing="0" cellpadding="5" border="0" width="100%" class="network-list">
            <?php foreach ($comm as $com): ?>
            <tr>
            <td><?php echo image_tag($com->getProfilePictureUri()) ?></td>
            <td width="90%" class="name">
            <?php echo $com ?>
            </td>
            </tr>
            <?php endforeach ?>
            </table>
            </div>
            </li>
            <?php endforeach ?>
            </ol>
            </div>
        </div>
        <?php endif ?>
        
    </div>
    
    
</div>
<div class="column span-144 append-2 prepend-1 home-top" style="position: relative;">
<?php echo javascript_tag("
var inside = false;
function focusFloat(trigger, force)
{
    if (force)
    {
        jQuery('.floating-block').addClass('focus');
        inside = true;
    }
    else if (trigger && onn)
    {
        jQuery('.floating-block').addClass('focus');
    }
    else
    {
        inside = false;
        jQuery('.floating-block').removeClass('focus');
    }
}
") ?>
<ol class="column" style="padding: 0px; margin: 0px;">
<li class="column span-10 append-3" style="text-align: center;"><?php echo link_to(image_tag($sesuser->getProfilePictureUri()), $sesuser->getProfileUrl(), array('class' => 'profile-picture', 'title' => __('Go to My Profile'))) ?><br />
    <?php echo link_to(__('Edit Picture'), '@setup-profile', array('class' => 'tiny-grey show', 'style' => 'display: block; margin-top: 2px;')) ?>
</li>
<li class="column">
<h3 style="margin: 0px;"><?php echo $sesuser ?></h3>
<?php $occ = $sesuser->getCurrentEmployments(true) ?>
<?php $sch = $sesuser->getCurrentEducations(true) ?>
<?php if ($occ): ?>
<span class="occupation"><?php echo __('%1p at %2c' , array('%1p' => $occ->getJobTitle(), '%2c' => $occ->getCompanyName())) ?></span>
<?php elseif ($sch): ?>
<span class="occupation"><?php echo __('%1d student at %2s on %3m' , array('%1d' => $sch->getResumeSchoolDegree(), '%2s' => $sch->getSchool(), '%3m' => $sch->getMajor())) ?></span>
<?php endif ?>
<div id="status-message" class="span-120 status-message readmore hide"><?php echo 
($status = $sesuser->getStatusUpdate()) ? 
(mb_strlen($status->getMessage())> 200 ? mb_substr($status->getMessage(), 0, 200).link_to_function(__('read more'), "", 'class=readmorelink')."<span class='more'>".mb_substr($status->getMessage(), 200)."</span>": $status->getMessage()) 
: '' ?></div>
<div class="hrsplit-1"></div>
<?php /*
<ol class="horizontal-menu show ghost" style="margin: 0px; padding: 0px;">
<li><?php echo link_to(__('Edit Profile'), '@profile-edit') ?></li>
<li><?php echo link_to(__('Photos'), $sesuser->getPhotosUrl()) ?></li>
<li><?php echo $sesuser->getResume() ? link_to(__('Edit CV'), '@hr.hr-cv') : link_to(__('Create CV'), '@hr.hr-cv-create') ?></li>
<li><?php echo link_to(__('Contacts'), '@cm.network') ?></li>
</ol>
*/ ?>
</li>
</ol>
</div>
<?php echo javascript_tag("
    //jQuery('.readmore').readmore(2);
") ?>
</div>