<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map' => array(__('Network') => '@network',
                                                                   __('Add Contact') => null)
                                                   )) ?> 
<?php end_slot() ?>

<div class="column dialog">
<ol class="column span-102">
<li class="column span-100 pad-1"><h2><?php echo __('Add to Network') ?></h2></li>
<li class="column span-15 right append-2"><?php echo link_to(image_tag($user->getProfilePictureUri(), 'width=60'), $user->getProfileUrl()) ?></li>
<li class="column span-75">
<?php $token = sha1(base64_encode($user.session_id())) ?>
<?php echo form_tag("@user-action?action=add&id={$user->getId()}&mod=commit&token=$token") ?>
<?php echo input_hidden_tag('ref', $sf_params->get('ref')) ?>
<ol class="column span-75">
<li><?php echo __('A network invitation will be sent to %1', array('%1' => $user->can(ActionPeer::ACT_VIEW_PROFILE, $user)?link_to($user, $user->getProfileUrl()):"<b>$user</b>")) ?></li>
<li><?php echo __('You may include a message in your invitation') ?></li>
<li><?php echo textarea_tag('invite_message', '', 'rows=4 style=width:390px;background:#FEFEFE') ?></li>
<li class="right"><?php echo submit_tag(__('Send Invitation'), 'class=sibling') ?></li>
</ol></form></li>
</ol>
</div>