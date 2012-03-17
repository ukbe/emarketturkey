<?php slot('uppermenu') ?>
<?php include_partial('network/uppermenu') ?>
<?php end_slot() ?>
<div class="network-panel">
<style>
#request-list
{
    border-top: solid 1px #888888;
    width: 100%;
} 
#request-list td
{
    border-bottom : solid 1px #E0DEDE;
    padding: 10px;
}
#request-list input[type=button]
{
    background-color: #60678A;
    border: solid 1px #3D4051;
    padding: 3px 6px;
    margin-right: 8px;
    color: #F9F9F9;
}
#request-list td:last-child
{
    width: 160px;
    text-align: right;
}
</style>
<h2><?php echo __('Network Requests') ?></h2>
<?php if ((count($friend_requests) || count($group_requests) || count($group_invitations) || count($relation_updates))): ?>
<table id="request-list" cellspacing="0" cellpadding="0">
<?php foreach ($friend_requests as $request): ?>
<tr>
<td>
<?php $person = $request->getUserRelatedByUserId() ?>
<?php echo link_to(image_tag($person->getProfilePictureUri()), $person->getProfileUrl()) ?>
</td>
<td><?php echo __('%1 wants to be friends with you.', array('%1' => link_to($person, $person->getProfileUrl()))) ?></td>
<td><?php echo button_to(__('Accept'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$request->getId().'&act=21')) ?>
<?php echo button_to(__('Ignore'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$request->getId().'&act=49')) ?></td>
</tr>
<?php endforeach ?>
<?php foreach ($relation_updates as $rupdate): ?>
<tr>
<td>
<?php $person = $rupdate->getSubject() ?>
<?php echo link_to(image_tag($person->getProfilePictureUri()), $person->getProfileUrl()) ?>
</td>
<td><?php echo __('%1 updated %2 relationship status with you to <b>%3</b>.', array('%1' => link_to($person, $person->getProfileUrl()), '%2' => $person->getAdjective(), '%3' => $rupdate->getRole())) ?></td>
<td><?php echo button_to(__('Accept'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$rupdate->getId().'&typ=stat&act=21')) ?>
<?php echo button_to(__('Ignore'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$rupdate->getId().'&typ=stat&act=49')) ?></td>
</tr>
<?php endforeach ?>
<?php foreach ($group_invitations as $invite): ?>
<tr>
<td>
<?php $inviter = $invite->getInviter() ?>
<?php echo link_to(image_tag($invite->getGroup()->getProfilePictureUri()), $invite->getGroup()->getProfileUrl()) ?>
</td>
<td>
<?php echo __('%1 invited you to join the group %2.', array('%1' => link_to($inviter, $inviter->getProfileUrl()), '%2' => link_to($invite->getGroup(), $invite->getGroup()->getProfileUrl()))) ?>
</td>
<td>
<?php echo button_to(__('Accept'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$invite->getId().'&typ=inv&act=21')) ?>
<?php echo button_to(__('Ignore'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$invite->getId().'&typ=inv&act=49')) ?>
</td>
</tr>
<?php endforeach ?>
<?php foreach ($group_requests as $grequest): ?>
<tr>
<td>
<?php $member = $grequest->getMember() ?>
<?php echo link_to(image_tag($member->getProfilePictureUri()), $member->getProfileUrl()) ?>
</td>
<td>
<?php echo __('%1 wants to join the group %2.', array('%1' => link_to($member, $member->getProfileUrl()), '%2' => link_to($grequest->getGroup(), $grequest->getGroup()->getProfileUrl()))) ?>
</td>
<td>
<?php echo button_to(__('Accept'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$grequest->getId().'&typ=grp&act=21')) ?>
<?php echo button_to(__('Ignore'), 'network/respond', array('query_string' => 'ref='.url_for('network/requests', true).'&rid='.$grequest->getId().'&typ=grp&act=49')) ?>
</td>
</tr>
<?php endforeach ?>
</table> 
<?php else: ?>
<?php echo __('You don\'t have any awaiting network requests.') ?><br /><br />
<?php endif ?>
</div>