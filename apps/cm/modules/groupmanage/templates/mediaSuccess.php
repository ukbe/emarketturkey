<?php use_helper('Number') ?>
<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Media Overview') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuMedia', array('group' => $group)) ?>
<?php end_slot() ?>
<div class="column span-107 append-1 divbox">
<span class="header"><?php echo __('Media') ?></span>
<div class="inside">
</div>
</div>