<div class="column">
<?php echo link_to('&nbsp;', '@homepage', array('class' => 'home', 'title' => __('Go to eMarketTurkey Home'))) ?>
</div>
<div style="text-align: center;">
<?php echo image_tag('layout/newlogo/help-us-out.'.$sf_user->getCulture().'.png') ?>
</div>
<style>
a.home {background: url(/images/layout/icon/home-grey.png) no-repeat; width: 31px; height: 29px; display: block;text-decoration: none;}
a.home:hover {background: url(/images/layout/icon/home-black.png)}
.tabs {text-align: center; padding: 80px 10px; height: 135px; vertical-align: middle;}
ol li a {border: solid 1px #DEDEDE; background-color: #F8F8F8; padding: 6px 10px 8px 10px; font: 12pt 'georgia'; color: #000000; text-decoration: none;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
}
ol li a.selected {background-color: #496181; color: #FFFFFF; border-color: #496181;}
.comments-block a {font: 12px arial; color: #888888; padding: 3px;}
.comments-block {font: 12px arial; color: #000000; float: left; margin: 0 auto; width: 465px; margin-left: 273px; padding-left: 2px;}
.comments-block a.dropped {display: inline-block; width: 100%; border-bottom: solid 1px #AAAAAA; text-align: left; text-decoration: none;}
.comments {padding: 15px 0px; width: 100%; float: left; text-align: left;}
.comments a {color: #000000; font-weight: bold;}
</style>
<div style="height: 30px;"></div>
<div class="column" style="text-align: center; width: 100%;">
<ol id="links" class="span-40" style="margin: 0px; padding: 0px; display: inline-block;text-align: center;">
<li class="column span-10"><?php echo link_to_function(1, "setTab(1);") ?></li>
<li class="column span-10"><?php echo link_to_function(2, "setTab(2);") ?></li>
<li class="column span-10"><?php echo link_to_function(3, "setTab(3);") ?></li>
<li class="column span-10"><?php echo link_to_function(4, "setTab(4);") ?></li>
</ol>
</div>
<div class="hrsplit-1"></div>
<div style="border: solid 2px #E8E7E7; width: 100%; text-align: center; float: left;">
<div class="tabs tab-1 ghost">
<?php echo image_tag('layout/newlogo/logo-1.png') ?>
</div>
<div class="comments-block tab-1 ghost">
<?php echo link_to_function(__('Comments(%1)', array('%1' => ($cnt = CommentPeer::countCommentsFor($options[0])))), "jQuery(this).parent().find('.comments').slideToggle('fast');jQuery(this).toggleClass('dropped');") ?>
<div class="comments ghost">
<?php echo $cnt == 0 ? __('No comments for this logo, yet. Be the first to comment on this logo.').'<br /><br />' : '' ?>
<?php include_partial('global/comment_box', array('item' => $options[0])) ?>
</div>
</div>
<div class="tabs tab-2 ghost">
<?php echo image_tag('layout/newlogo/logo-2.png') ?>
</div>
<div class="comments-block tab-2 ghost">
<?php echo link_to_function(__('Comments(%1)', array('%1' => ($cnt = CommentPeer::countCommentsFor($options[1])))), "jQuery(this).parent().find('.comments').slideToggle('fast');jQuery(this).toggleClass('dropped');") ?>
<div class="comments ghost">
<?php echo $cnt == 0 ? __('No comments for this logo, yet. Be the first to comment on this logo.').'<br /><br />' : '' ?>
<?php include_partial('global/comment_box', array('item' => $options[1])) ?>
</div>
</div>
<div class="tabs tab-3 ghost">
<?php echo image_tag('layout/newlogo/logo-3.png') ?>
</div>
<div class="comments-block tab-3 ghost">
<?php echo link_to_function(__('Comments(%1)', array('%1' => ($cnt = CommentPeer::countCommentsFor($options[2])))), "jQuery(this).parent().find('.comments').slideToggle('fast');jQuery(this).toggleClass('dropped');") ?>
<div class="comments ghost">
<?php echo $cnt == 0 ? __('No comments for this logo, yet. Be the first to comment on this logo.').'<br /><br />' : '' ?>
<?php include_partial('global/comment_box', array('item' => $options[2])) ?>
</div>
</div>
<div class="tabs tab-4 ghost">
<?php echo image_tag('layout/newlogo/logo-4.png') ?>
</div>
<div class="comments-block tab-4 ghost">
<?php echo link_to_function(__('Comments(%1)', array('%1' => ($cnt = CommentPeer::countCommentsFor($options[3])))), "jQuery(this).parent().find('.comments').slideToggle('fast');jQuery(this).toggleClass('dropped');") ?>
<div class="comments ghost">
<?php echo $cnt == 0 ? __('No comments for this logo, yet. Be the first to comment on this logo.').'<br /><br />' : '' ?>
<?php include_partial('global/comment_box', array('item' => $options[3])) ?>
</div>
</div>
<div class="hrsplit-1"></div>
</div>
<div class="hrsplit-2"></div>
<div style="text-align: center; width: 100%;">
<?php if (!$vote): ?>
<?php echo form_tag('poll/index') ?>
<?php echo input_hidden_tag('poll', $poll->getGuid()) ?>
<?php echo input_hidden_tag('selection', $poll->getOptionBySequenceId($selection)->getGuid()) ?>
<?php echo submit_image_tag('layout/newlogo/save.'.$sf_user->getCulture().'.png') ?>
</form>
<?php else: ?>
<div id="selectedvote" style="font: bold 12pt helvetica; color: #5FB51A;"><?php echo __('You have submitted this logo.') ?></div>
<?php endif ?>
</div>
<?php echo javascript_tag("
var opts = ".array_or_string_for_javascript($poll->getOptionGuids()).";
function setTab(x)
{
    jQuery('.tabs,.comments-block').hide();
    jQuery('#links a').removeClass('selected');
    jQuery('.tab-'+x).show();
    jQuery('#links li:nth-child('+x+') a').addClass('selected');
    if ('#selection') jQuery('#selection').val(opts[x-1]);
    " .
    ($vote ?
   "if (x=={$vote->getPollItem()->getSequenceId()}) jQuery('#selectedvote').show();
    else jQuery('#selectedvote').hide();" : "") .
   "jQuery.cookie('tmpollsel', x, 0);
} 
setTab((a=jQuery.cookie('tmpollsel'))?a:$selection);
if (document.location.hash.substring(1) == 'comments') {jQuery('.tab-$selection').find('.comments').slideToggle('fast');jQuery('[class~=\'comments-block\'][class~=\'tab-$selection\'] > a').toggleClass('dropped');}
    "); ?>