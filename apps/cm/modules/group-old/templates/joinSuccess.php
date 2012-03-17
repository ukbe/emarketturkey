<?php use_helper('Object') ?>
<?php if (count($userprops)): ?>
<?php $i = 0 ?>
<div class="network-items">
<?php foreach ($userprops as $prop): ?>
<?php $i++ ?>
<?php $ismember=$prop->isMemberOf($group->getId()) ?>
<?php $isowner=$prop->isMemberOf($group->getId(), RolePeer::RL_GP_OWNER) ?>
<?php $ispendingmember=$prop->isMemberOf($group->getId(), null, GroupMembershipPeer::STYP_PENDING) ?>
<?php $ru = $ismember ? $ismember->getRelationUpdate() : null ?>
<?php if ($ismember || $prop->can(ActionPeer::ACT_JOIN_GROUP, $group)): ?>
<div class="item span-105">
<div id="stat<?php echo $i ?>" class="hangright">
<?php if ($ismember && $prop->can(ActionPeer::ACT_LEAVE_GROUP, $group)): ?>
<?php echo emt_remote_link(__('Leave'), "stat$i", "@group-action?stripped_name={$group->getStrippedName()}&action=join&mod=leave&member={$ismember->getId()}&row=$i&token=".sha1(base64_encode($group.session_id())), null, null, array('class' => 'sibling')) ?>
<?php elseif ($ispendingmember): ?>
<?php echo __('Pending') ?>
<?php elseif (!$ismember && $prop->can(ActionPeer::ACT_JOIN_GROUP, $group)): ?>
<?php echo emt_remote_link(__('Join'), "stat$i", "@group-action?stripped_name={$group->getStrippedName()}&action=join&mod=commit&item={$prop->getId()}&itemtyp=".PrivacyNodeTypePeer::getTypeFromClassname($prop)."&row=$i&token=".sha1(base64_encode($group.session_id())), null, null, array('class' => 'sibling')) ?>
<?php endif ?>
</div>
<div id="stat<?php echo $i ?>error"></div>
<div class="logo"><?php echo link_to(image_tag($prop->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $prop->getProfileUrl()) ?></div>
<div class="info">
<b><?php echo link_to($prop, $prop->getProfileUrl()) ?></b><br />
<div class="hrsplit-1"></div>
<?php if ($isowner): ?>
<?php echo __('Owner') ?>
<?php elseif ($ismember): ?>
<?php echo select_tag("relation$i", 
                    options_for_select(_get_options_from_objects(RolePeer::getRolesRelatedTo(PrivacyNodeTypePeer::PR_NTYP_GROUP, $ismember->getObjectTypeId())), $ru ? $ru->getRoleId() : $ismember->getRoleId()), array(
      'include_custom' => __('select relationship type')
      )) ?></td>
<span id="changerel<?php echo $i ?>"><?php echo $ru?__('Pending Confirmation') : '' ?></span>
<?php echo observe_field("relation$i", array('update' => "changerel$i",
                'url' => '@group-action?stripped_name='.$group->getStrippedDisplayName().'&action=join&token='.sha1(base64_encode($group.session_id())), 
                'with' => "'mod=chanrel&member={$ismember->getId()}&relation=' + value"
            )) ?>
<?php endif ?>
</div>
</div>
<?php endif ?>
<?php endforeach ?>
</div>
<div class="hrsplit-1"></div>
<?php endif ?>