<?php use_helper('Date') ?>
<div>
<ol class="activity">
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
<?php include_partial('global/comment_box', array('item' => ($object ? $object : $activity), 'cmnts' => $cmnts)) ?>
</div>
<?php endif ?>
<?php  ?>
</li>
<?php endforeach ?>
</ol>
</div>