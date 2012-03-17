<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Invite People') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuMembers', array('group' => $group)) ?>
<?php end_slot() ?>
<style>
table.friend-list {
    width: 100%;
}

table.friend-list td:first-child {
    width: 16px;
}

table.friend-list td:last-child {
    width: auto;
}

table.friend-list td {
    border-bottom: solid 1px #E0DEDE;
    padding: 6px;
    text-align: left;
    width: 60px;
    height: 50px;
    vertical-align: middle;
}

table.friend-list tr.selected td {
    background-color: #EEF0FD;
}

table.friend-list td img {
    margin: 0 auto;
    display: block;
}

table.friend-list td a {
    font: 13px arial;
    color: #313131;
    text-decoration: none;
}

table.friend-list tr:last-child td {
    border-bottom: none;
}

div.framed-list {
    height: 314px;
    overflow: auto;
    width: auto;
    border: solid 2px #E0DEDE;
}

#selected-friends {
    font: 18px helvetica;
    color: #000000;
}
</style>
<div class="column span-110">
<?php if (count($invited)): ?>
<h3><?php echo __('%1 of your friends were invited to join %2.', array('%1' => count($invited), '%2' => link_to($group->getName(), $group->getProfileUrl()))) ?></h3>
<div class="hrsplit-3"></div>
<?php echo link_to_function(__('See invited friend list'), "jQuery('.invited-list').slideToggle();", 'class=invited-list') ?>
<div class="framed-list invited-list ghost">
<table class="friend-list" cellspacing="0" cellpadding="3">
<?php foreach ($invited as $friend): ?>
    <tr>
        <td><?php echo checkbox_tag('friends[]', $friend->getId(), false, array('id' => 'f_'.$friend->getId())) ?></td>
        <td><?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?></td>
        <td><?php echo link_to_function($friend, $friend->getProfileUrl()) ?></td>
    </tr>
    <?php endforeach ?>
</table>
</div>
<?php else: ?>
<h3><?php echo __('No friends were invited!') ?></h3>
<?php endif ?>
    <?php slot('rightcolumn') ?>
    <?php end_slot() ?>