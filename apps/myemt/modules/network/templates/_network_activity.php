<?php use_helper('Date') ?>
<?php if (!isset($refreshing) || isset($refreshing) && !$refreshing): ?>
<div>
<ol class="activity" style="width: 100%;">
<li class="errortxt first" style="display: none;"><?php echo __('Error Occured!') ?></li>
<li class="ref-loading first a-center" style="display: none; width: 100%;"><?php echo image_tag('layout/icon/wind-loading.gif') ?></li>
<?php endif ?>
<?php $due = (count($activities) ? $activities[0]->getCreatedAt('U') : time('U')); ?>
<?php foreach ($activities as $activity): ?>
<li class="first">
<?php echo link_to(image_tag($activity->getIssuer()->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL), array('title' => $activity->getIssuer())), $activity->getIssuer()->getProfileUrl()) ?>
</li>
<li>
<p><?php echo $activity->toString() ?></p>
<?php if ($partial = $activity->getActionCase()->getAction()->getDetailPartial()): ?>
<div>
<?php include_partial($partial, array('item' => $activity->getObject())) ?>
</div>
<?php endif ?>
<em><?php echo format_datetime($activity->getCreatedAt('U'), 'MMM F, ' . ($activity->getCreatedAt('Y') < date('Y') ? 'yyyy' : '') . ' HH:mm') ?></em>
<?php  ?>
<?php if ($activity->getActionCase()->getAction()->getCommentable()): ?>
<span class="sepdot"></span>
<?php if ($object=$activity->getObject()): ?>
<?php $cmnts = CommentPeer::getCommentsFor($object) ?>
<?php else: ?>
<?php $cmnts = CommentPeer::getCommentsFor($activity) ?>
<?php endif ?>
<?php echo link_to_function(__('Comment'), "jQuery('.na-{$activity->getId()}-cmn').toggle();", "class=na-{$activity->getId()}-cmn".(count($cmnts) ? " ghost" : "")) ?>
<div class="hrsplit-1"></div>
<div class="na-<?php echo $activity->getId() ?>-cmn<?php echo (!count($cmnts)) ? " ghost" : "" ?>">
<?php include_partial('profile/comment_box', array('item' => ($object ? $object : $activity), 'cmnts' => $cmnts)) ?>
</div>
<?php endif ?>
<?php  ?>
</li>
<?php endforeach ?>
<?php $from = (isset($activity) ? $activity->getCreatedAt('U') : time('U')) ?>
<?php if (!isset($refreshing) || isset($refreshing) && !$refreshing): ?>
<li class="old-loading first a-center" style="display: none; width: 100%;"><?php echo image_tag('layout/icon/wind-loading.gif') ?></li>
<li class="morelink first"><?php echo link_to_function(__('Older'), "jQuery(this).closest('ol').update(1);") ?></li>
</ol>
</div>
<?php echo javascript_tag("
jQuery('.activity').attr('due', $due);
jQuery('.activity').attr('from', $from);
jQuery.fn.update = function(otype){
    otype = (otype === 1 ? 1 : 0);
    var o = jQuery(this[0]);
    o.ref_loading = o.find('.ref-loading');
    o.old_loading = o.find('.old-loading');
    o.errorout = o.find('.errortxt');
    o.morelink = o.find('.morelink');
    if (otype) o.old_loading.show(); else o.ref_loading.show();
    jQuery.ajax({
        url: '/network/refresh',
        success: function(data){if (otype) o.old_loading.before(data); else o.ref_loading.after(data);},
        beforeSend: function(){o.errorout.hide(); if (otype) o.morelink.hide();},
        complete: function(){if (otype) {o.old_loading.hide(); o.morelink.show();} else o.ref_loading.hide();},
        error: function(){o.errorout.show();},
        data: ({latest : o.attr('due'), from: o.attr('from'), type: otype})
    });
};
jQuery.fn.readmore = function(maxlines){
    var o = jQuery(this[0]);
    o.lineheight = o.css('line-height').replace('px', '');
    alert(o.lineheight);
    o.readmorelink = o.find('.readmorelink');
    if (o.height() > maxlines*o.lineheight)
    {
        alert('ss');
        o.css('height', maxlines*o.lineheight+'px');
        o.css('overflow', 'hidden');
        if (!o.readmorelink.length)
        {
            alert('poo');
            o.readmorelink = jQuery('<a href=\"#\" class=\"readmorelink\">read more</a>');
            o.after(o.readmorelink);
            alert(o.readmorelink.length);
            o.readmorelink.click(function(){alert('gfdgf');});
        }
    }
};

var linkread = function(o){
    var o = jQuery(o);
    var p = o.parent();
    p.html(p.html().replace(/\\n/g, '<br />'));
    p.find('span.more').show();
    p.find('a.readmorelink').hide();
}
jQuery('a.readmorelink').click(function(){
    linkread(this);
});

") ?>
<?php else: ?>
<?php echo javascript_tag("
    if (jQuery('.activity').attr('due')<$due) {jQuery('.activity').attr('due', $due);}
    if (jQuery('.activity').attr('from')>$from) {jQuery('.activity').attr('from', $from);}
") ?>
<?php endif ?>