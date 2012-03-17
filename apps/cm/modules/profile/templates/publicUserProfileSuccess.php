<?php use_helper('Date') ?>
<?php $token = sha1(base64_encode($user.session_id())); ?>
<?php if ($profile): ?>
<?php slot('leftcolumn') ?>
<div class="column span-41">
<?php $canviewphotos = $sesuser->can(ActionPeer::ACT_VIEW_PHOTOS, $user) ?>
<?php if ($canviewphotos): ?>
<?php echo link_to(image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_LARGE), array('width' => '200', 'title' => $sesuser->getId()==$user->getId() ? __('My Photos') : __("%1's Photos", array('%1' => $user)))), $user->getPhotosUrl()) ?>
<?php else: ?>
<?php echo image_tag($user->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_LARGE), 'width=200') ?>
<?php endif ?>
<ol class="profile-actions">
<?php if ($canviewphotos): ?>
<li><?php echo link_to(($sesuser->getId()==$user->getId()) ? __('My Photos') : __('Photos'), $user->getPhotosUrl()) ?></li>
<?php endif ?>
<?php if ($sesuser->getId()!=$user->getId() && $sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $user)): ?>
<li><?php echo link_to(__('Send Message'), '@compose-message', array('query_string' => 'rcpu='.$user->getId().'&_ref='.$sf_request->getUri())) ?></li>
<?php endif ?>
<?php if (!$sesuser->isNew() && $sesuser->getId()!=$user->getId() && !$sesuser->isFriendsWith($user->getId()) && $sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $user)): ?>
<li><?php echo link_to(__('Add as Friend'), "@user-action?action=add&id={$user->getId()}", array('query_string' => "token=$token&width=560&height=220&_ref=".urlencode($sf_request->getUri()), 'class' => 'thickbox', 'title' => __('Add as Friend'))) ?></li>
<?php endif ?>
<li class="left-box">
<?php $canviewfriends = $sesuser->can(ActionPeer::ACT_VIEW_FRIENDS, $user) ?>
<span class="header"><?php echo __('Friends').'('.count($friends).')' ?>
<?php echo $canviewfriends ? link_to_function(__('see all'), "jQuery('#profile-tabs').tabs('option', 'selected', jQuery('#friends').parent().prevAll().length );", 'class=action') : '' ?>
</span>
<?php $fc = 0; ?>
<?php if (count($friends)> 0): ?>
<table cellspacing="0" cellpadding="0">
<?php foreach ($friends as $friend): ?>
<?php $fc++ ?>
<?php if ($fc % 3 == 1) echo "<tr>" ?>
<td>
<?php if ($sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $friend) || $sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $friend)): ?>
<?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?><br />
<?php echo link_to($friend, $friend->getProfileUrl()) ?>
<?php else: ?>
<?php echo image_tag($friend->getProfilePictureUri()) ?><br />
<?php echo $friend ?>
<?php endif ?>
</td>
<?php if ($fc % 3 == 0 || $fc==count($friends) || $fc > 5) echo "</tr>" ?>
<?php if ($fc > 5) break; ?>
<?php endforeach ?>
</table>
<?php endif ?>
</li>
<li class="left-box">
<?php $canviewgroups = $sesuser->can(ActionPeer::ACT_VIEW_GROUPS, $user) ?>
<span class="header"><?php echo __('Groups').'('.count($groups).')' ?>
<?php echo $canviewgroups ? link_to_function(__('see all'), "jQuery('#profile-tabs').tabs('option', 'selected', jQuery('#groups').parent().prevAll().length );", 'class=action') : '' ?>
</span>
<ol>
<?php $gr = 0; ?>
<?php foreach ($groups as $group): ?>
<?php $gr++; if ($gr>4) continue;  ?>
<li style="text-align:left;"><?php echo link_to($group, $group->getProfileUrl()) ?></li>
<?php endforeach ?>
</ol>
</li>
</ol>
</div>
<?php end_slot() ?>
<?php endif ?>
<div class="pad-2">
<div class="hangright right island-form">
<b><?php echo __('Current Location') ?></b>
<div class="island-form-body">
<div class="island-form-sect ghost">
<?php echo link_to_function(image_tag('layout/icon/delete-n.png'), "jQuery('#complete-city').val('');jQuery('.island-form .island-form-sect').slideToggle();", 'class=cancel') ?>
<?php echo input_tag('complete-city') ?>
<?php echo javascript_tag("
    jQuery(function() {
        var cache = {};
jQuery ('#complete-city').autocomplete({
    source: function(request, response) {
                if ( request.term in cache ) {
                    response( cache[ request.term ] );
                    return;
                }        
                jQuery.ajax({
                    url: '".url_for('@location-query')."',
                    dataType: 'json',
                    data: request,
                    success: function( data ) {
                        cache[ request.term ] = data;
                        response( data );
                    }
                })
            },
    minLength: 3,
    dataType: 'json',
    cache: false,
    focus: function(event, ui) {
            return false;
           },
    select: function(event, ui) {
                this.value = ui.item.label;
                self.item_id = ui.item.id;
                jQuery.ajax({
                    url: '".url_for('@location-update')."',
                    success: function(data) {
                                jQuery('.island-form-body .ajax-progress').hide();
                                jQuery('.island-form-body .display').html(data);
                                jQuery('.island-form .island-form-sect').slideToggle();
                                },
                    data: 'city_id='+self.item_id,
                    beforeSend: function (){jQuery('.island-form-body .ajax-progress').show();},
                });
                return false;
            }
}); });
") ?>
<style>
.island-form-body .island-form-sect .flag
{
    height: 12px;
    margin-left: 6px;
    margin-bottom: -1px;
}
.island-form-body .island-form-sect .cancel
{
    display: block;
    margin-left: 5px;
    margin-top: 2px;
    float: right;
}
 
</style>
<div class="ajax-progress" style="display: none;"></div>
</div>
<div class="island-form-sect display">
<?php if ($loc = $user->getLocationUpdate()): ?>
<?php echo implode(',', array_filter(array($loc->getGeonameCityRelatedByCity(), $loc->getGeonameCityRelatedByState()?$loc->getGeonameCityRelatedByState()->getAdmin1Code():null))) . '<img class="flag" src="/images/layout/flag/'.$loc->getCountry().'.png" title="'.format_country($loc->getCountry()).'" />'; ?>
<?php elseif (!$sf_user->getUser() || $sf_user->getUser()->getId()!=$user->getId()): ?>
<em class="tip"><?php echo __('Location not set') ?></em>
<?php endif ?>
</div>
<?php if ($sesuser->getId()==$user->getId()): ?>
<div class="island-form-sect">
<em class="trigger tip"><?php echo link_to_function(__('set your location'), "jQuery('.island-form .island-form-sect').slideToggle()") ?></em>
</div>
<?php endif ?>
</div>
</div>

<h3 style="margin-top: 0px;padding-top: 0px;"><?php echo $user ?></h3>
<div id="status_upd" class="column"><?php echo $user->getStatusUpdate()?$user->getStatusUpdate()->getMessage():'' ?></div>
<?php if ($sesuser->getId()==$user->getId()): ?>
<?php echo javascript_tag("
new Ajax.InPlaceEditor('status_upd', '/profile/updateStatus', 
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