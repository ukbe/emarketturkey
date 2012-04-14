<?php use_helper('Date') ?>
<?php if (!isset($refreshing) || isset($refreshing) && !$refreshing): ?>
<div>
<dl class="activity" style="display: block;">
<dt class="errortxt" style="display: none;"><?php echo __('Error Occured!') ?></dt>
<dt class="ref-loading a-center" style="display: none; width: 100%;"><?php echo image_tag('layout/icon/wind-loading.gif') ?></dt>
<?php endif ?>
<?php $due = (count($activities) ? $activities[0]->getCreatedAt('U') : time('U')); ?>
<?php foreach ($activities as $activity): ?>
<dt>
<?php echo link_to(image_tag($activity->getIssuer()->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL), array('title' => $activity->getIssuer())), $activity->getIssuer()->getProfileUrl()) ?>
</dt>
<dd>
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
<?php echo link_to_function(__('Comment'), "$('.na-{$activity->getId()}-cmn').toggle();", "class=na-{$activity->getId()}-cmn".(count($cmnts) ? " ghost" : "")) ?>
<div class="hrsplit-1"></div>
<div class="na-<?php echo $activity->getId() ?>-cmn<?php echo (!count($cmnts)) ? " ghost" : "" ?>">
<?php include_partial('profile/comment_box', array('item' => ($object ? $object : $activity), 'cmnts' => $cmnts)) ?>
</div>
<?php endif ?>
<?php  ?>
</dd>
<?php endforeach ?>
<?php $from = (isset($activity) ? $activity->getCreatedAt('U') : time('U')) ?>
<?php if (!isset($refreshing) || isset($refreshing) && !$refreshing): ?>
<dt class="old-loading first a-center" style="display: none; width: 100%;"><?php echo image_tag('layout/icon/wind-loading.gif') ?></dt>
<dt class="morelink first"><?php echo link_to_function(__('Older'), "$(this).closest('ol').update(1);") ?></dt>
</ol>
</div>
<?php echo javascript_tag("
$('.activity').attr('due', $due);
$('.activity').attr('from', $from);
$.fn.update = function(otype){
    otype = (otype === 1 ? 1 : 0);
    var o = $(this[0]);
    o.ref_loading = o.find('.ref-loading');
    o.old_loading = o.find('.old-loading');
    o.errorout = o.find('.errortxt');
    o.morelink = o.find('.morelink');
    if (otype) o.old_loading.show(); else o.ref_loading.show();
    $.ajax({
        url: '".url_for('network/refresh')."',
        success: function(data){if (otype) o.old_loading.before(data); else o.ref_loading.after(data);},
        beforeSend: function(){o.errorout.hide(); if (otype) o.morelink.hide();},
        complete: function(){if (otype) {o.old_loading.hide(); o.morelink.show();} else o.ref_loading.hide();},
        error: function(r, e){o.errorout.show(); },
        data: ({latest : o.attr('due'), from: o.attr('from'), type: otype})
    });
};
$.fn.readmore = function(maxlines){
    var o = $(this[0]);
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
            o.readmorelink = $('<a href=\"#\" class=\"readmorelink\">read more</a>');
            o.after(o.readmorelink);
            alert(o.readmorelink.length);
            o.readmorelink.click(function(){alert('gfdgf');});
        }
    }
};

var linkread = function(o){
    var o = $(o);
    var p = o.parent();
    p.html(p.html().replace(/\\n/g, '<br />'));
    p.find('span.more').show();
    p.find('a.readmorelink').hide();
}
$('a.readmorelink').click(function(){
    linkread(this);
});

") ?>
<?php else: ?>
<?php echo javascript_tag("
    if ($('.activity').attr('due')<$due) { $('.activity').attr('due', $due); }
    if ($('.activity').attr('from')>$from) { $('.activity').attr('from', $from); }
") ?>
<?php endif ?>