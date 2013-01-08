<div class="hrsplit-2"></div>
<div id="here-diverror"></div>
<div id="here-div">
<?php $token = sha1(base64_encode($user.session_id())) ?>
<?php echo emt_remote_form('here-div', "@user-action", array('action' => 'add', 'id' => $user->getId(), 'mod' => 'commit', 'token' => $token)) ?>
<?php echo input_hidden_tag('ref', $sf_params->get('ref')) ?>
<ol class="column span-110">
<li class="column span-13 append-2 center">
<?php echo ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $user) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $user)) ? link_to(image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $user->getProfileUrl()) : image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)) ?>
</li>
<li class="column span-95">
<h3><?php echo ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $user) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $user)) ? link_to($user, $user->getProfileUrl()) : $user ?></h3>
<div class="hrsplit-1"></div>
<?php echo __('A friendship request will be sent to %1', array('%1' => $user)) ?>
<div class="hrsplit-1"></div>
<?php echo __('You may attach a message to your friendship request :') ?>
<div class="hrsplit-1"></div>
<?php echo textarea_tag('invite_message', '', 'rows=4 style=width:390px;background:#FEFEFE') ?>
<div class="hrsplit-1"></div>
<?php echo submit_tag(__('Send Invitation'), 'class=sibling') ?>
</li>
</ol>
</form>
</div>