<?php if ($membership->getStatus()==GroupMembershipPeer::STYP_ACTIVE): ?>
<?php echo emt_remote_link(__('Leave'), "stat".$row, '@group-action', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'join',
            'mod'           => 'leave',
            'member'        => $membership->getId(),
            'row'           => $row
            ), null, array('class' => 'sibling', 'id' => "stat".$row)) ?>
<script>
<?php if ($membership->getObjectTypeID() == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
var $cnt = jQuery('#group-people-count');
if ($cnt.html()<6)
{
<?php $html = "" ?>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $item) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $item)): ?>
<?php $html .= link_to(image_tag($item->getProfilePictureUri()), $item->getProfileUrl()).'<br />' ?>
<?php $html .= link_to($item, $item->getProfileUrl()) ?>
<?php else: ?>
<?php $html .= image_tag($item->getProfilePictureUri()) . '<br />' ?>
<?php $html .= $item ?>
<?php endif ?>
    jQuery('#summary-new-person').html("<?php echo escape_javascript($html) ?>");
    jQuery('#summary-new-person').attr('id', 'summary-person-<?php echo $item->getId() ?>');
}
$cnt.html('<?php echo $group->getActivePeople(true); ?>');
<?php elseif ($membership->getObjectTypeID() == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
var $cnt = jQuery('#group-companies-count');
if ($cnt.html()<6)
{
<?php $html = link_to(image_tag($item->getProfilePictureUri(), array('title' => $item)), $item->getProfileUrl()) ?>
    jQuery('#summary-new-company').html("<?php echo escape_javascript($html) ?>")
    jQuery('#summary-new-company').attr('id', 'summary-company-<?php echo $item->getId() ?>');
}
$cnt.html('<?php echo $group->getActiveCompanies(true); ?>');
<?php else: ?>
<?php endif ?>
</script>
<?php elseif ($membership->getStatus()==GroupMembershipPeer::STYP_PENDING): ?>
<?php echo __('Pending') ?>
<?php endif ?>