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

<?php echo form_tag('@group-manage?action=invite&stripped_name='.$group->getStrippedName()) ?>
<div class="column span-110" style="text-align: center;"><?php if (count($friends)): ?>
<div class="framed-list">
<table class="friend-list" cellspacing="0" cellpadding="3">
<?php foreach ($friends as $friend): ?>
    <tr>
        <td><?php echo checkbox_tag('friends[]', $friend->getId(), false, array('id' => 'f_'.$friend->getId())) ?></td>
        <td><?php echo link_to_function(image_tag($friend->getProfilePictureUri()), '') ?></td>
        <td><?php echo link_to_function($friend, '', 'id=a2') ?></td>
    </tr>
    <?php endforeach ?>
</table>
</div>
<table cellspacing="5" cellpadding="0" width="100%">
    <tr>
        <td align="left"><?php echo __('%1 friends total', array('%1' => count($friends))) ?></td>
        <td align="right"><?php echo link_to_function(__('Select All'), "jQuery('.framed-list :input[type=checkbox]').attr('checked', 'checked');setcount();updatebg();") ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo link_to_function(__('De-Select All'), "jQuery('.framed-list :input[type=checkbox]').attr('checked', '');setcount();updatebg();") ?></td>
</table>
    <?php echo javascript_tag("

function setcount(){
    var \$num = jQuery('.framed-list :input:checked').length;
    jQuery('#num').html(\$num); if (\$num>0) jQuery('#submit-invite').removeClass('ghost'); else jQuery('#submit-invite').addClass('ghost');}
function updatebg(){ jQuery('.framed-list :input[type=checkbox]').each(function(){if (this.checked){jQuery(this).parent().parent().addClass('selected');} 
        else {jQuery(this).parent().parent().removeClass('selected');}}); }

jQuery('.framed-list :input[type=checkbox]').click(
    function(){
        if (this.checked){jQuery(this).parent().parent().addClass('selected');} 
        else {jQuery(this).parent().parent().removeClass('selected');}
        setcount();
    });
jQuery('.framed-list a').click(function(){
    \$check = jQuery(this).parent().parent().find('input[id^=f_]');
    \$check.attr('checked', !\$check.is(':checked'));
    if (\$check.is(':checked')) {\$check.parent().parent().addClass('selected');}
    else {\$check.parent().parent().removeClass('selected');}
    setcount();
    });
") ?> <?php else: ?> <?php echo __("You don't have any person in your network.") ?>
<?php endif ?></div>

    <?php slot('rightcolumn') ?>
<div><span id="selected-friends"><?php echo __('<span id="num">0</span> Friends Selected') ?></span>
</div>
<div><br /><?php echo submit_image_tag("layout/button/group/invite.{$sf_user->getCulture()}.png", 'id=submit-invite class=ghost') ?>
</div>
</form>
    <?php end_slot() ?>