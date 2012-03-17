<?php slot('uppermenu') ?>
<?php include_partial('network/uppermenu') ?>
<?php end_slot() ?>
<div class="network-panel">
<div class="column span-146 last">
<div class="column span-143 append-1">
<ol id="tabs" class="column" style="margin: 0px;">
<li class="column"><?php echo link_to_function(__('People').'('.count($friends).')', "jQuery('.network-list').slideUp();jQuery('#network-people').slideDown();jQuery('#tabs a').removeClass('selected');jQuery(this).addClass('selected');", ($tab=='people'||$tab=='')?'class=selected':'') ?></li>
<li class="column"><?php echo link_to_function(__('Groups').'('.count($groups).')', "jQuery('.network-list').slideUp();jQuery('#network-groups').slideDown();jQuery('#tabs a').removeClass('selected');jQuery(this).addClass('selected');", ($tab=='groups')?'class=selected':'') ?></li>
<li class="column"><?php echo link_to_function(__('Companies').'('.count($companies).')', "jQuery('.network-list').slideUp();jQuery('#network-companies').slideDown();jQuery('#tabs a').removeClass('selected');jQuery(this).addClass('selected');", ($tab=='companies')?'class=selected':'') ?></li>
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
<?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?>
<?php echo link_to($friend, $friend->getProfileUrl(), 'class=name') ?><br />
<?php echo link_to(__('Send Message'), '@myemt.compose-message', array('query_string' => 'rcpu='.$friend->getId().'&_ref='.urlencode($sf_request->getUri()), 'class' => 'action')) ?>
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
<?php echo link_to(__('Go to Friend Finder'), '@friendfinder', 'class=sibling') ?>
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
    <?php $member_friends = $sesuser->getFriendsMemberOf($group->getId(), 5, true) ?>
    <?php if (count($member_friends)): ?>
    <?php foreach ($member_friends as $mfriend): ?>
    <?php echo link_to(image_tag($mfriend->getProfilePictureUri(), array('width' => 30, 'title' => $mfriend)), $mfriend->getProfileUrl()) ?>
    <?php endforeach ?>
    <?php endif ?></td>
</tr>
<?php endforeach ?>
<?php else: ?>
<tr><td><?php echo __('You are not a member of any groups, yet.<br />You may browse groups on eMarketTurkey Community.') ?><br /><br />
<?php echo link_to(__('Visit eMarketTurkey Groups'), '@groups', 'class=sibling') ?>
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
<tr><td><?php echo __('You don\'t have any companies in your network, yet.<br />You may browse companies on eMarketTurkey B2B Directory.') ?><br /><br />
<?php echo link_to(__('Visit eMarketTurkey B2B Directory'), '@b2b.companies', 'class=sibling') ?>
</td></tr>
<?php endif ?>
</table>
</div>
</div>
</div>