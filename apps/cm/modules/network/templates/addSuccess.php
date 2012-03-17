<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map' => array(__('MyEMT') => '@homepage', 
                                                                   __('Network') => '@network',
                                                                   __('Add Contact') => null)
                                                   )) ?> 
<?php end_slot() ?>

<div class="column dialog">
<ol class="column span-102">
<li class="column span-100 pad-1"><h2><?php echo __('Add to Network') ?></h2></li>
<li class="column span-15 right append-2"><?php echo link_to(image_tag($contact->getProfilePictureUri(), 'width=60'), $contact->getProfileUrl()) ?></li>
<li class="column span-75">
<?php echo form_tag('network/add') ?>
<?php echo input_hidden_tag('cid', $contact->getId()) ?>
<ol class="column span-75">
<li><?php echo __('A network invitation will be sent to %1', array('%1' => $user->can(ActionPeer::ACT_VIEW_PROFILE, $contact)?link_to($contact, $contact->getProfileUrl()):"<b>$contact</b>")) ?></li>
<li><?php echo __('You may include a message in your invitation') ?></li>
<li><?php echo textarea_tag('invite_message', '', 'rows=4 style=width:390px;background:#FEFEFE') ?></li>
<li class="right"><?php echo submit_tag(__('Send Invitation'), 'class=sibling') ?></li>
</ol></form></li>
</ol>
</div>