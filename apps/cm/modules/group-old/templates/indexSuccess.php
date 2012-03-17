<?php use_helper('Date') ?>
<?php if ($group): ?>
<?php slot('leftcolumn') ?>
<div class="column span-41">
<div class="span-41" style="display: table-cell;text-align: center;">
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PHOTOS, $group)): ?>
<?php echo link_to(image_tag($group->getProfilePictureUri(true), array('title' => __('Group Photos'))), $group->getPhotosUrl()) ?>
<?php else: ?>
<?php echo image_tag($group->getProfilePictureUri(true), array()) ?>
<?php endif ?>
</div>
<ol class="profile-actions">
<li><?php echo link_to(__('Photos'), $group->getPhotosUrl()) ?></li>
<?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $group)): ?>
<li><?php echo link_to(__('Send Message'), 'messages/compose', array('query_string' => 'rcpu='.$group->getId().'&_ref='.$sf_request->getUri())) ?></li>
<?php endif ?>
<li><?php echo link_to(count($userprops)>1 ? __('Edit Membership') : __('Join Group'), '@group-action?stripped_name='.$sf_params->get('stripped_name').'&action=join', array('query_string' => 'cid='.$group->getId().'&width=560&height=200', 'class' => 'thickbox', 'title' => count($userprops)>1 ? __('Edit Membership') : __('Join Group'))) ?></li>
<li class="left-box">
<span class="header"><?php echo __('People').'(<span id="group-people-count">'.count($people).'</span>)' ?>
<?php echo link_to_function(__('see all'), "jQuery('#profile-tabs').tabs('option', 'selected', jQuery('#people').parent().prevAll().length );", 'class=action') ?></span>
<?php $mc = 0; ?>
<table cellspacing="0" cellpadding="0">
<?php foreach ($people as $person): ?>
<?php $mc++ ?>
<?php if ($mc % 3 == 1) echo "<tr>" ?>
<td id="summary-person-<?php echo $person->getId() ?>">
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $person) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $person)): ?>
<?php echo link_to(image_tag($person->getProfilePictureUri()), $person->getProfileUrl()) ?><br />
<?php echo link_to($person, $person->getProfileUrl()) ?>
<?php else: ?>
<?php echo image_tag($person->getProfilePictureUri()) ?><br />
<?php echo $person ?>
<?php endif ?>
</td>
<?php if ($mc < 6 && $mc==count($people)) echo '<td id="summary-new-person"></td>' ?>
<?php if ($mc % 3 == 0 || $mc==count($people) || $mc > 5) echo "</tr>" ?>
<?php if ($mc > 5) break; ?>
<?php endforeach ?>
<?php if ($mc==0) echo '<tr><td id="summary-new-person"></td></tr>' ?>
</table>
</li>
<li class="left-box">
<span class="header"><?php echo __('Companies').'(<span id="group-companies-count">'.count($companies).'</span>)' ?>
<?php echo link_to_function(__('see all'), "jQuery('#profile-tabs').tabs('option', 'selected', jQuery('#companies').parent().prevAll().length );", 'class=action') ?></span>
<?php $mc = 0; ?>
<table cellspacing="0" cellpadding="0" style="text-align: center; vertical-align: middle;">
<?php foreach ($companies as $company): ?>
<?php $mc++ ?>
<?php if ($mc % 3 == 1) echo "<tr>" ?>
<td id="summary-company-<?php echo $company->getId() ?>">
<?php echo link_to(image_tag($company->getProfilePictureUri(), array('title' => $company)), $company->getProfileUrl()) ?>
</td>
<?php if ($mc < 6 && $mc==count($companies)) echo '<td id="summary-new-company"></td>' ?>
<?php if ($mc % 3 == 0 || $mc==count($companies) || $mc > 5) echo "</tr>" ?>
<?php if ($mc > 5) break; ?>
<?php endforeach ?>
<?php if ($mc==0) echo '<tr><td id="summary-new-company"></td></tr>' ?>
</table>
</li>
</ol>
</div>
<?php end_slot() ?>
<?php endif ?>
<div class="pad-2">
<?php if ($sesuser->isOwnerOf($group)): ?>
<div style="float: right;"><?php echo link_to(__('Manage Group'), '@group-manage?action=manage&stripped_name='.$group->getStrippedName(), array('class' => 'command')) ?></div>
<?php endif ?>
<h3 style="margin-top: 0px;padding-top: 0px;"><?php echo $group->getDisplayName() ?></h3>
<div id="status_upd" class="column"><?php echo $group->getStatusUpdate() ?></div>
<?php if ($sesuser->isOwnerOf($group)): ?>
<?php echo javascript_tag("
new Ajax.InPlaceEditor('status_upd', '/group/updateStatus?id={$group->getId()}', 
        {cancelText:'".__('Cancel')."', 
         cols:60, 
         savingText:'',
         emptyText:'".__('click to set a status message')."',
         okText:'".__('Save')."', 
         rows:2,
         });
") ?>
<?php endif ?>
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
") ?>