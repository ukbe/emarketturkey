<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Invite People') => '@group-manage?action=sendMail&stripped_name='.$group->getStrippedName(),
                                                                  __('Invite Mail Sent') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuMembers', array('group' => $group)) ?>
<?php end_slot() ?>
<h1><?php echo __('Invitations Sent') ?></h1>
<?php echo format_number_choice('[0]No friends were invited|[1]1 friend was invited|(1,+Inf]%1% friends were invited', array('%1%' => count($sent)), count($sent)) ?>
<?php slot('rightcolumn') ?>
<div class="column">
<?php echo image_tag('content/invite/template-1/network.png', 'width=200') ?>
</div>
<?php end_slot() ?>
