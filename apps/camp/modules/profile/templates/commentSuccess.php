<?php use_helper('Date') ?>
<div id="cm-<?php echo $cm->getHash()  ?>" class="comment">
<div class="thumb">
<?php echo link_to(image_tag($cm->getCommenter()->getProfilePictureUri(), array('title' => $cm->getCommenter())), $cm->getCommenter()->getProfileUrl()) ?>
</div>
<div class="info">
<p><?php echo $cm->getCommenter() ?></p>
<p><?php echo $cm->getText() ?></p>
<em><?php echo format_datetime($cm->getCreatedAt('U')) ?></em>
</div>
<div class="remove">
<?php echo ($sf_user->getUser() && ($sf_user->getUser()->isOwnerOf($cm->getItemId(), $cm->getItemTypeId()) ||
                                    $sf_user->getUser()->isOwnerOf($cm))) ? link_to_remote(__('x'), array('url' => '@profile-action?action=comment&mod=rm&hash='.$cm->getHash(), 'update' => 'cm-'.$cm->getHash()), 'class=command') : '' ?>
</div>
</div>