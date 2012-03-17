<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map' => array(__('MyEMT') => '@homepage', 
                                                                   __('My Network') => null)
                                                   )) ?> 
<?php end_slot() ?>

<?php slot('pagecommands') ?>
<ol class="inline-form">
<li><?php echo __('Search in Network :') ?></li>
<li><?php echo input_auto_complete_tag('network_keyword', '' , 'network/search', array('autocomplete' => 'off'), array('use_style' => false)) ?></li></ol>
<?php end_slot() ?>

<?php slot('rightcolumn') ?>
<div class="column span-49 pad-1">
<h3><?php echo __('Networking Tools') ?></h3>
<?php echo link_to(__('Friend Finder'), 'friendfinder/index') ?>
</div>
<div class="hrsplit-3"></div>
<div class="column span-49">
<ol class="column command-menu" style="margin: 0px;padding: 0px;">
<li><?php echo link_to(__('Requests').($req_count?' ('.$req_count.')':''), 'network/requests') ?></li>
</ol></div>
<?php end_slot() ?>
<style>
ol#tabs li
{
    margin: 0px 15px 0px 0px;
}
ol#tabs li a
{
    font: bold 12px helvetica;
    text-decoration: none;
    padding: 2px 4px;
    color: #236679;
    border: solid 1px transparent;
}
ol#tabs li a.selected
{
    background-color: #236679;
    color: #FFFFFF;
    border: solid 1px #164D5D;
}
table#network-groups a
{
    font: bold 14px verdana;
    text-decoration: none;
    color: #333333;
}
</style>
<div class="column span-146 last">
<div class="column span-143 append-1">
<ol id="tabs" class="column" style="margin: 0px;">
<li class="column"><?php echo link_to_function(__('People').'('.count($friends).')', "jQuery('.network-list').slideUp();jQuery('#network-people').slideDown();jQuery('#tabs :a').removeClass('selected');jQuery(this).addClass('selected');", ($tab=='people'||$tab=='')?'class=selected':'') ?></li>
<li class="column"><?php echo link_to_function(__('Groups').'('.count($groups).')', "jQuery('.network-list').slideUp();jQuery('#network-groups').slideDown();jQuery('#tabs :a').removeClass('selected');jQuery(this).addClass('selected');", ($tab=='groups')?'class=selected':'') ?></li>
<li class="column"><?php echo link_to_function(__('Companies').'('.count($companies).')', "jQuery('.network-list').slideUp();jQuery('#network-companies').slideDown();jQuery('#tabs :a').removeClass('selected');jQuery(this).addClass('selected');", ($tab=='companies')?'class=selected':'') ?></li>
</ol>
<?php $i=0 ?>
<table id="network-people" cellpadding="0" cellspacing="5" class="network-list span-143<?php echo ($tab=='people'||$tab=='')?'':' ghost' ?>">
<?php if (count($friends)): ?>
<?php foreach ($friends as $friend): ?>
<?php $i++ ?>
<?php if ($i % 3 == 1): ?>
<tr>
<?php endif ?>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $friend)): ?>
<?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?>
<?php echo link_to($friend, $friend->getProfileUrl(), 'class=name') ?><br />
<?php else: ?>
<?php echo image_tag($friend->getProfilePictureUri()) ?>
<?php echo $friend ?><br />
<?php endif ?>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $friend)) echo link_to('Send Message', 'messages/compose', array('query_string' => 'rcpu='.$friend->getId()."&_ref=$_here", 'class' => 'action')) ?>
</td>
<?php if ($i % 3 == 0): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if ($i % 3 != 0): ?> 
</tr>
<?php endif ?>
<?php else: ?>
<tr><td><?php echo __('You don\'t have any people in your network, yet.<br />Friend Finder may help you find your friends online.') ?><br /><br />
<h3><?php echo __('Networking Tools') ?></h3>
<ol>
<li>
<?php echo link_to('Friend Finder', 'friendfinder/index') ?>
</li>
</ol>
</td></tr>
<?php endif ?>
</table>
<table id="network-groups" cellpadding="0" cellspacing="5" class="network-list span-143<?php echo $tab=='groups'?'':' ghost' ?>">
<?php if (count($groups)): ?>
<?php foreach ($groups as $group): ?>
<tr>
<td width="40"><?php echo link_to(image_tag($group->getProfilePictureUri()), $group->getProfileUrl()) ?></td>
<td><?php echo link_to($group, $group->getProfileUrl()) ?>
    <div style="font: 11px tahoma;"><?php echo __('%1 Members', array('%1' => $group->countMembers())) ?></div>
    <div class="hrsplit-1"></div>
    <?php $member_friends = $user->getFriendsMemberOf($group->getId(), 5, true) ?>
    <?php if (count($member_friends)): ?>
    <?php foreach ($member_friends as $mfriend): ?>
    <?php echo link_to(image_tag($mfriend->getProfilePictureUri(), array('width' => 30, 'title' => $mfriend)), $mfriend->getProfileUrl()) ?>
    <?php endforeach ?>
    <?php endif ?></td>
</tr>
<?php endforeach ?>
<?php else: ?>
<tr><td><?php echo __('You are not a member of any groups, yet.<br />You may try searching groups on eMT Community.') ?><br /><br />
</td></tr>
<?php endif ?>
</table>
<table id="network-companies" cellpadding="0" cellspacing="5" class="network-list span-143<?php echo $tab=='companies'?'':' ghost' ?>">
<?php if (count($companies)): ?>
<?php foreach ($companies as $company): ?>
<tr>
<td width="40"><?php echo link_to(image_tag($company->getProfilePictureUri()), $company->getProfileUrl()) ?></td>
<td><div style="font: bold 15px tahoma;"><?php echo link_to($company, $company->getProfileUrl()) ?></div>
    <div class="hrsplit-1"></div>
    <div style="font: bold 11px tahoma;">
    <?php echo $company->getBusinessSector() ?><br />
    <em><?php echo $company->getBusinessType() ?></em>
    </div></td>
</tr>
<?php endforeach ?>
<?php else: ?>
<tr><td><?php echo __('You don\'t have any companies in your network, yet.<br />You may try Friend Finder or search for companies on eMT B2B Directory.') ?><br /><br />
<?php echo link_to('Friend Finder', 'friendfinder/index') ?>
</td></tr>
<?php endif ?>
</table>
</div>
</div>
