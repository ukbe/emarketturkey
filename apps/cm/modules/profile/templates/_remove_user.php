<div class="hrsplit-2"></div>
<?php $token = sha1(base64_encode($user.session_id())); ?>
<ol class="column span-100">
<li class="column span-13 append-2 center">
<?php echo ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $user) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $user)) ? link_to(image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $user->getProfileUrl()) : image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)) ?>
</li>
<li class="column span-85">
<h3><?php echo ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $user) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $user)) ? link_to($user, $user->getProfileUrl()) : $user ?></h3>
<div class="hrsplit-1"></div>
<?php echo __('Are you sure that you want to remove %1 from your friends?', array('%1' => $user->getName())) ?>
<div class="hrsplit-2"></div>
<?php echo link_to(__('Yes do it!'), "@user-action?action=add&id={$user->getId()}", array('query_string' => "token=$token&mod=remove&confirm=do&_ref=".$sf_params->get('ref'), 'class' => 'sibling')) ?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo link_to_function(__('Cancel'), 'tb_remove()', array('class' => 'sibling')) ?>
</li>
</ol>