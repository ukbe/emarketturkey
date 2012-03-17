<?php echo emt_remote_link(__('Join'), "stat".$sf_params->get('row'), '@group-action', array(
            'stripped_name' => $group->getStrippedName(),
            'action'        => 'join',
            'mod'           => 'commit',
            'item'          => $membership->getObjectId(),
            'itemtyp'       => $membership->getObjectTypeId(),
            'row'           => $sf_params->get('row')
            ), null, array('class' => 'sibling', 'id' => "stat".$sf_params->get('row'))) ?>
<script>
<?php if ($membership->getObjectTypeID() == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
var $cnt = jQuery('#group-people-count');
var $item = jQuery("#summary-person-<?php echo $membership->getObjectId() ?>");
if ($item) $item.remove();
$cnt.html('<?php echo $group->getActivePeople(true); ?>');
<?php elseif ($membership->getObjectTypeID() == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
var $cnt = jQuery('#group-companies-count');
var $item = jQuery("#summary-company-<?php echo $membership->getObjectId() ?>");
if ($item) $item.remove();
$cnt.html('<?php echo $group->getActiveCompanies(true); ?>');
<?php else: ?>
<?php endif ?>
</script>