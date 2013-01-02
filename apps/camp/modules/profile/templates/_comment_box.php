<?php use_helper('Date') ?>
<?php $sf_user->setAttribute('comment',$sf_user->getAttribute('comment', get_class($item).'/'.$item->getId())+1, get_class($item).'/'.$item->getId()) ?>
<?php $pitch = $sf_user->getAttribute('comment', get_class($item).'/'.$item->getId()) ?>
<div class="comment-box">
<?php if (!isset($cmnts)) $cmnts = CommentPeer::getCommentsFor($item) ?>
<?php if (count($cmnts)): ?>
<?php foreach ($cmnts as $comment): ?>
<div id="cm-<?php echo $comment->getHash()  ?>" class="comment">
<div class="thumb">
<?php echo link_to(image_tag($comment->getCommenter()->getProfilePictureUri(), array('title' => $comment->getCommenter())), $comment->getCommenter()->getProfileUrl()) ?>
</div>
<div class="info">
<p><?php echo $comment->getCommenter() ?></p>
<p><?php echo $comment->getText() ?></p>
<em><?php echo format_datetime($comment->getCreatedAt('U')) ?></em>
</div>
<div class="remove">
<?php echo ($sf_user->getUser() && ($sf_user->getUser()->isOwnerOf($comment->getItemId(), $comment->getItemTypeId()) ||
                                    $sf_user->getUser()->isOwnerOf($comment))) ? link_to_remote(__('x'), array('url' => '@cm.profile-action?action=comment&mod=rm&hash='.$comment->getHash(), 'update' => 'cm-'.$comment->getHash()), 'class=command') : '' ?>
</div>
</div>
<?php endforeach ?>
<?php endif ?>
<?php if ($user = $sf_user->getUser()): ?>
<div id="last-comment-<?php echo $pitch ?>"></div>
<div class="comment-form">
<p><em><?php echo __('Leave a comment :') ?></em></p>
<div class="thumb">
<?php echo link_to_function(image_tag($user->getProfilePictureUri(), array('title' => $user)), '#') ?>
</div>
<div class="form" id="comment-form-<?php echo $pitch ?>">
<?php echo form_tag('@cm.profile-action?action=comment&_ref='.urlencode($_SERVER['REQUEST_URI'])) ?>
<?php echo input_hidden_tag('i1', $item->getId()) ?>
<?php echo input_hidden_tag('i2', PrivacyNodeTypePeer::getTypeFromClassname(get_class($item))) ?>
<?php echo input_hidden_tag('c1', $user->getId()) ?>
<?php echo input_hidden_tag('c2', PrivacyNodeTypePeer::PR_NTYP_USER) ?>
<?php echo textarea_tag('comment-text', '', 'cols=50 rows=4') ?>
<?php if_javascript(); ?>
<?php echo submit_to_remote('comment', __('Leave Comment'), array('url' => '@cm.profile-action?action=comment', 'update' => 'last-comment-'.$pitch, 'position' => 'before', 'complete' => "jQuery('#comment-form-".$pitch." #comment-text').val('');".(isset($trigger)?$trigger:'')), 'class=command') ?>
<?php end_if_javascript(); ?>
<noscript><?php echo submit_tag(__('Leave Comment')) ?></noscript>
</form>
</div>
</div>
<?php else: ?>
<div class="hrsplit-1"></div>
<?php echo __('%1L or %2S to leave comment.', array('%1L' => link_to(__('Login'), '@myemt.login', array('query_string' => '_ref='.urlencode(sfContext::getInstance()->getRequest()->getUri()), 'absolute' => true)), '%2S' => link_to(__('Sign Up'), '@signup', array('query_string' => '_ref='.urlencode(sfContext::getInstance()->getRequest()->getUri()), 'absolute' => true)))) ?>
<?php endif ?>
</div>