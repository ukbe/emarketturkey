<?php use_helper('Object') ?>
<?php $token = sha1(base64_encode($user.session_id())); ?>
<div class="hrsplit-2"></div>
<ol class="column span-100">
<li class="column span-13 append-2 center">
<?php echo ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $user) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $user)) ? link_to(image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)), $user->getProfileUrl()) : image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYP_SMALL)) ?>
</li>
<li class="column span-85">
<h3><?php echo ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $user) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $user)) ? link_to($user, $user->getProfileUrl()) : $user ?></h3>
<div class="hrsplit-1"></div>
<?php echo __('You may update your relationship status with %1 :', array('%1' => $user->getName())) ?>
<div class="hrsplit-1"></div>
<?php echo select_tag("relation", 
                    options_for_select(_get_options_from_objects(RolePeer::getRolesRelatedTo(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_USER)), ($ru = $relation->getRelationUpdate()) ? $ru->getRoleId() : $relation->getRoleId()), array(
      'include_custom' => __('select relationship type')
      )) ?></td>
<span id="changerel"><?php echo $ru?__('Pending Confirmation') : '' ?></span>
<?php echo observe_field("relation", array('update' => "changerel",
                'url' => '@user-action?action=add&id='.$user->getId(), 
                'with' => "'mod=chanrel&token=$token&relation=' + value"
            )) ?>
</li>
</ol>