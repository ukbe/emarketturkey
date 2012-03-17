<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Pending Members') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuMembers', array('group' => $group)) ?>
<?php end_slot() ?>
<?php slot('rightcolumn') ?>
<div>
<?php if (count($tips)): ?>
<div class="iconed-header">
<span><?php echo image_tag('layout/icon/tips-icon.png') ?></span>
<span><?php echo __('Tips') ?></span></div>
<div>
<ul class="circled-list">
<?php foreach ($tips as $label => $tip): ?>
<li><?php echo link_to(__($label), $tip[0]) . '<br />' . __($tip[1]) ?></li>
<?php endforeach ?>
</ul>
</div>
<?php endif ?>
</div>
<?php end_slot() ?>

<div class="column span-113">
<?php if (!count($people) && !count($companies) && !count($groups)): ?>
<?php echo __('There are no pending membership requests, at the moment.') ?><br /><br />
<?php endif ?>
<?php $i=0 ?>
<?php if (count($people)): ?>
<h3 class="stylish"><span><?php echo __('People').'('.count($people).')' ?></span></h3>
<table cellpadding="0" cellspacing="5" class="network-list span-113">
<?php foreach ($people as $person): ?>
<?php $i++ ?>
<?php if ($i % 3 == 1): ?>
<tr>
<?php endif ?>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $person) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $person)): ?>
<?php echo link_to(image_tag($person->getProfilePictureUri()), $person->getProfileUrl()) ?>
<?php echo link_to($person, $person->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($person->getProfilePictureUri()) ?>
<?php echo $person ?><br />
<?php endif ?>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $person)) echo link_to(__('Send Message'), '@myemt.compose-message', array('query_string' => 'rcpu='.$person->getId().'&rcptyp='.PrivacyNodeTypePeer::PR_NTYP_USER.'&_ref='.$sf_request->getUri(), 'class' => 'action')) ?>
</td>
<td width="115">
<div id="prs<?php echo $i ?>error"></div>
<div  id="prs<?php echo $i ?>">
<?php echo emt_remote_link(__('Confirm'), "prs$i", '@group-manage', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'editPendingMember',
            'mod'           => 'confirm',
            'obj'           => $person->getId(),
            'objtyp'        => PrivacyNodeTypePeer::PR_NTYP_USER
            ), null, array('class' => 'sibling')) ?>
&nbsp;
<?php echo emt_remote_link(__('Reject'), "prs$i", '@group-manage', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'editPendingMember',
            'mod'           => 'reject',
            'obj'           => $person->getId(),
            'objtyp'        => PrivacyNodeTypePeer::PR_NTYP_USER
            ), null, array('class' => 'sibling')) ?>
</div>
</td>
<?php if ($i % 3 == 0): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if ($i % 3 != 0): ?> 
</tr>
<?php endif ?>
</table>
<div class="hrsplit-3"></div>
<?php endif ?>
<?php if (count($groups)): ?>
<h3 class="stylish"><span><?php echo __('Groups').'('.count($groups).')' ?></span></h3>
<table cellpadding="0" cellspacing="5" class="network-list span-113">
<?php foreach ($groups as $group): ?>
<?php $i++ ?>
<?php if ($i % 3 == 1): ?>
<tr>
<?php endif ?>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $group) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $group)): ?>
<?php echo link_to(image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $group->getProfileUrl()) ?>
<?php echo link_to($group, $group->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($group->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)) ?>
<?php echo $group ?><br />
<?php endif ?>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $group)) echo link_to(__('Send Message'), '@myemt.compose-message', array('query_string' => 'rcpu='.$group->getId().'&rcptyp='.PrivacyNodeTypePeer::PR_NTYP_GROUP.'&_ref='.$sf_request->getUri(), 'class' => 'action')) ?>
</td>
<td width="115">
<div id="grp<?php echo $i ?>error"></div>
<div  id="grp<?php echo $i ?>">
<?php echo emt_remote_link(__('Confirm'), "grp$i", '@group-manage', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'editPendingMember',
            'mod'           => 'confirm',
            'obj'           => $group->getId(),
            'objtyp'        => PrivacyNodeTypePeer::PR_NTYP_GROUP
            ), null, array('class' => 'sibling')) ?>
&nbsp;
<?php echo emt_remote_link(__('Reject'), "grp$i", '@group-manage', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'editPendingMember',
            'mod'           => 'reject',
            'obj'           => $group->getId(),
            'objtyp'        => PrivacyNodeTypePeer::PR_NTYP_GROUP
            ), null, array('class' => 'sibling')) ?>
</div>
</td>
<?php if ($i % 3 == 0): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if ($i % 3 != 0): ?> 
</tr>
<?php endif ?>
</table>
<div class="hrsplit-3"></div>
<?php endif ?>
<?php if (count($companies)): ?>
<h3 class="stylish"><span><?php echo __('Companies').'('.count($companies).')' ?></span></h3>
<table cellpadding="0" cellspacing="3" class="network-list span-113">
<?php foreach ($companies as $company): ?>
<?php $i++ ?>
<?php if ($i % 3 == 1): ?>
<tr>
<?php endif ?>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $company) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $company)): ?>
<?php echo link_to(image_tag($company->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $company->getProfileUrl()) ?>
<?php echo link_to($company, $company->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($company->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)) ?>
<?php echo $company ?><br />
<?php endif ?>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $company)) echo link_to(__('Send Message'), '@myemt.compose-message', array('query_string' => 'rcpu='.$company->getId().'&rcptyp='.PrivacyNodeTypePeer::PR_NTYP_COMPANY.'&_ref='.$sf_request->getUri(), 'class' => 'action')) ?>
</td>
<td width="115">
<div id="cmp<?php echo $i ?>error"></div>
<div  id="cmp<?php echo $i ?>">
<?php echo emt_remote_link(__('Confirm'), "cmp$i", '@group-manage', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'editPendingMember',
            'mod'           => 'confirm',
            'obj'           => $company->getId(),
            'objtyp'        => PrivacyNodeTypePeer::PR_NTYP_COMPANY
            ), null, array('class' => 'sibling')) ?>
&nbsp;
<?php echo emt_remote_link(__('Reject'), "cmp$i", '@group-manage', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'editPendingMember',
            'mod'           => 'reject',
            'obj'           => $company->getId(),
            'objtyp'        => PrivacyNodeTypePeer::PR_NTYP_COMPANY
            ), null, array('class' => 'sibling')) ?>
</div>
</td>
<?php if ($i % 3 == 0): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if ($i % 3 != 0): ?> 
</tr>
<?php endif ?>
</table>
<?php endif ?>
</div>
