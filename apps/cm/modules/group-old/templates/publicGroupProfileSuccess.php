<?php use_helper('Date') ?>
<?php if ($group): ?>
<?php slot('leftcolumn') ?>
<div class="column span-41">
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PHOTOS, $group)): ?>
<?php echo link_to(image_tag($group->getProfilePictureUri(true), array('width' => '200', 'title' => __('Group Photos'))), $group->getPhotosUrl()) ?>
<?php else: ?>
<?php echo image_tag($group->getProfilePictureUri(true), array('width' => '200')) ?>
<?php endif ?>
<ol class="profile-actions">
<li><?php echo link_to(__('Photos'), $group->getPhotosUrl()) ?></li>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $group)): ?>
<li><?php echo link_to(__('Send Message'), 'messages/compose', array('query_string' => 'rcpu='.$group->getId().'&_ref='.$sf_request->getUri())) ?></li>
<?php endif ?>
<?php if (!$sesuser->getGroupMembership($group->getId())): ?>
<li>
<?php if ($sesuser->isNew()): ?>
<?php echo link_to(__('Join Group'), '@lobby.signup', array('query_string' => 'ref='.urlencode(url_for('@group-profile?stripped_name='.$sf_params->get('stripped_name').'&trigger=join&cid='.$group->getId())), 'title' => __('Join Group'))) ?>
<?php else: ?>
<?php echo link_to(__('Join Group'), '@group-action?stripped_name='.$sf_params->get('stripped_name').'&action=join', array('query_string' => 'cid='.$group->getId().'&width=560&height=200', 'class' => 'thickbox', 'title' => __('Join Group'), 'id' => 'join-group-link')) ?>
<?php endif ?>
    <div id="joinas" onmouseover="jQuery('#joinas').show();" onmouseout="jQuery('#joinas').hide();">
        <ol>
        <li><?php echo link_to('emarketturkey', '@homepage') ?></li>
        <li><?php echo link_to('igid', '@homepage') ?></li>
        </ol></div></li>
<?php endif ?>
<li class="left-box">
<span class="header"><?php echo __('People').'('.count($people).')' ?>
<?php echo link_to_function(__('see all'), "jQuery('#profile-tabs').tabs('option', 'selected', jQuery('#people').parent().prevAll().length );", 'class=action') ?></span>
<?php $mc = 0; ?>
<?php if (count($people)> 0): ?>
<table cellspacing="0" cellpadding="0">
<?php foreach ($people as $person): ?>
<?php $mc++ ?>
<?php if ($mc % 3 == 1) echo "<tr>" ?>
<td>
<?php echo link_to(image_tag($person->getProfilePictureUri()), $person->getProfileUrl()) ?><br />
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $person)): ?>
<?php echo link_to($person, $person->getProfileUrl()) ?>
<?php else: ?>
<?php echo $person ?>
<?php endif ?>
</td>
<?php if ($mc % 3 == 0 || $mc==count($people) || $mc > 5) echo "</tr>" ?>
<?php if ($mc > 5) break; ?>
<?php endforeach ?>
</table>
<?php endif ?>
</li>
<li class="left-box">
<span class="header"><?php echo __('Companies').'('.count($companies).')' ?>
<?php echo link_to_function(__('see all'), "jQuery('#profile-tabs').tabs('option', 'selected', jQuery('#companies').parent().prevAll().length );", 'class=action') ?></span>
<?php $mc = 0; ?>
<?php if (count($companies)> 0): ?>
<table cellspacing="0" cellpadding="0">
<?php foreach ($companies as $company): ?>
<?php $mc++ ?>
<?php if ($mc % 3 == 1) echo "<tr>" ?>
<td style="text-align: center; vertical-align: middle;">
<?php echo link_to(image_tag($company->getProfilePictureUri(), array('title' => $company)), $company->getProfileUrl()) ?>
</td>
<?php if ($mc % 3 == 0 || $mc==count($companies) || $mc > 5) echo "</tr>" ?>
<?php if ($mc > 5) break; ?>
<?php endforeach ?>
</table>
<?php endif ?>
</li>
</ol>
</div>
<?php end_slot() ?>
<?php endif ?>
<div class="pad-2">
<h3 style="margin-top: 0px;padding-top: 0px;"><?php echo $group->getDisplayName() ?></h3>
<div id="status_upd" class="column"><?php echo $group->getStatusUpdate() ?></div>
</div>
<div class="hrsplit-2"></div>
<div id="profile-tabs">
     <ul>
     <?php foreach ($tabs as $key => $tab): ?>
         <li><?php echo link_to('<span>'.__($tab[0]).'</span>', $tab[1], "id=$key") ?></li>
     <?php endforeach ?>
     </ul>
     <div class="ajax-loading ghost"></div>
</div>
<?php echo javascript_tag("
var \$pgt = jQuery('#profile-tabs').tabs({ 
                spinner: '',
                cache: true,
                selected: $tabindex, 
                ajaxOptions: {
                            beforeSend: function(event, ui) {
                                            jQuery('#profile-tabs .ajax-loading').show();
                            },
                            success: function(event, ui) {
                                        jQuery('#profile-tabs .ajax-loading').hide();
                            }
                         }, 
              });
".($sf_params->get('trigger')=='join' ? "jQuery('#join-group-link').click();" : "")."
") ?>