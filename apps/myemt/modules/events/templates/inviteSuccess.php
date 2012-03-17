<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('events/events', array('owner' => $owner, 'route' => $route)) ?>
        </div>
    </div>
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section id="boxContent">
                <h4>
                <div class="_right"><?php echo link_to(__('Edit Event'), "$route&action=add&id={$event->getId()}") ?></div>
                <?php echo __('Invite to Event: <span class="sparkle">%1</span>', array('%1' => $event->getName())) ?>
                <div><span class="tag calendar-11px"><?php echo format_datetime($time_scheme->getStartDate('U'), 'f') ?></span>
                     <span class="tag pin-11px"><?php echo $event->getLocationName() ?></span>
                     <?php if ($event->getOrganiserName()): ?><span class="tag tag-11px"><?php echo $event->getOrganiserName() ?></span><?php endif ?>
                     </div></h4>
                <?php echo form_tag("$route&action=invite&id={$event->getId()}") ?>
                <p><?php echo __('Select guests from the list below in order to send invitations to this event.') ?></p>
                <h5><?php echo __('People in Your Network') ?></h5>
                <?php if (count($network[RolePeer::RL_NETWORK_MEMBER])): ?>
                <table class="objlist">
                <?php foreach ($network[RolePeer::RL_NETWORK_MEMBER] as $user): ?>
                <?php $att = $event->getInviteFor($user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER) ?>
                <tr><td><?php echo image_tag($user->getProfilePictureUri()) ?></td>
                    <td><?php echo $user ?></td>
                    <td><?php echo $att ? "<em>".__(EventPeer::$attypNames[$att->getRsvpStatus()])."</em>" : checkbox_tag("network[".PrivacyNodeTypePeer::PR_NTYP_USER."][{$user->getId()}]", 1, false) ?></td></tr>
                <?php endforeach ?>
                <tr><th colspan="3">
                        <ul class="sepdot _right">
                            <li><?php echo link_to_function(__('Check all'), "$(this).closest('table').find('tr').addClass('_selected').find('input[type=\"checkbox\"]').attr('checked', true);") ?></li>
                            <li><?php echo link_to_function(__('Un-Check all'), "$(this).closest('table').find('tr').removeClass('_selected').find('input[type=\"checkbox\"]').attr('checked', false);") ?></li>
                        </ul>
                    </th></tr>
                </table>
                <?php else: ?>
                <em class="ln-example"><?php echo __('No people in your network.') ?></em>
                <?php endif ?>
                <?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
                <h5><?php echo __('Partner Companies') ?></h5>
                <?php if (count($network[RolePeer::RL_CM_PARTNER])): ?>
                <table class="objlist">
                <?php foreach ($network[RolePeer::RL_CM_PARTNER] as $company): ?>
                <?php $att = $event->getInviteFor($company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?>
                <tr><td><?php echo image_tag($company->getProfilePictureUri()) ?></td>
                    <td><?php echo $company ?></td>
                    <td><?php echo $att ? "<em>".__(EventPeer::$attypNames[$att->getRsvpStatus()])."</em>" : checkbox_tag("network[".PrivacyNodeTypePeer::PR_NTYP_COMPANY."][{$company->getId()}]", 1, false) ?></td></tr>
                <?php endforeach ?>
                <tr><th colspan="3">
                        <ul class="sepdot _right">
                            <li><?php echo link_to_function(__('Check all'), "$(this).closest('table').find('tr').addClass('_selected').find('input[type=\"checkbox\"]').attr('checked', true);") ?></li>
                            <li><?php echo link_to_function(__('Un-Check all'), "$(this).closest('table').find('tr').removeClass('_selected').find('input[type=\"checkbox\"]').attr('checked', false);") ?></li>
                        </ul>
                    </th></tr>
                </table>
                <?php else: ?>
                <em class="ln-example"><?php echo __('No partner companies.') ?></em>
                <?php endif ?>
                <h5><?php echo __('Followers') ?></h5>
                <?php if (count($network[RolePeer::RL_CM_FOLLOWER])): ?>
                <table class="objlist">
                <?php foreach ($network[RolePeer::RL_CM_FOLLOWER] as $user): ?>
                <?php $att = $event->getInviteFor($user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER) ?>
                <tr><td><?php echo image_tag($user->getProfilePictureUri()) ?></td>
                    <td><?php echo $user ?></td>
                    <td><?php echo $att ? "<em>".__(EventPeer::$attypNames[$att->getRsvpStatus()])."</em>" : checkbox_tag("network[".PrivacyNodeTypePeer::PR_NTYP_USER."][{$user->getId()}]", 1, false) ?></td></tr>
                <?php endforeach ?>
                <tr><th colspan="3">
                        <ul class="sepdot _right">
                            <li><?php echo link_to_function(__('Check all'), "$(this).closest('table').find('tr').addClass('_selected').find('input[type=\"checkbox\"]').attr('checked', true);") ?></li>
                            <li><?php echo link_to_function(__('Un-Check all'), "$(this).closest('table').find('tr').removeClass('_selected').find('input[type=\"checkbox\"]').attr('checked', false);") ?></li>
                        </ul>
                    </th></tr>
                </table>
                <?php else: ?>
                <em class="ln-example"><?php echo __('No followers.') ?></em>
                <?php endif ?>
                <?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
                <h5><?php echo __('Member Companies and Users') ?></h5>
                <?php if (count($network[RolePeer::RL_GP_MEMBER])): ?>
                <table class="objlist">
                <?php foreach ($network[RolePeer::RL_GP_MEMBER][PrivacyNodeTypePeer::PR_NTYP_COMPANY] as $company): ?>
                <?php $att = $event->getInviteFor($company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?>
                <tr><td colspan="3"><b><?php echo __('Companies') ?></b></td></tr>
                <tr><td><?php echo image_tag($company->getProfilePictureUri()) ?></td>
                    <td><?php echo $company ?></td>
                    <td><?php echo $att ? "<em>".__(EventPeer::$attypNames[$att->getRsvpStatus()])."</em>" : checkbox_tag("network[".PrivacyNodeTypePeer::PR_NTYP_COMPANY."][{$company->getId()}]", 1, false) ?></td></tr>
                <?php endforeach ?>
                <tr><td colspan="3"><b><?php echo __('Users') ?></b></td></tr>
                <?php foreach ($network[RolePeer::RL_GP_MEMBER][PrivacyNodeTypePeer::PR_NTYP_USER] as $user): ?>
                <?php $att = $event->getInviteFor($user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER) ?>
                <tr><td><?php echo image_tag($user->getProfilePictureUri()) ?></td>
                    <td><?php echo $user ?></td>
                    <td><?php echo $att ? "<em>".__(EventPeer::$attypNames[$att->getRsvpStatus()])."</em>" : checkbox_tag("network[".PrivacyNodeTypePeer::PR_NTYP_USER."][{$user->getId()}]", 1, false) ?></td></tr>
                <?php endforeach ?>
                <tr><th colspan="3">
                        <ul class="sepdot _right">
                            <li><?php echo link_to_function(__('Check all'), "$(this).closest('table').find('tr').addClass('_selected').find('input[type=\"checkbox\"]').attr('checked', true);") ?></li>
                            <li><?php echo link_to_function(__('Un-Check all'), "$(this).closest('table').find('tr').removeClass('_selected').find('input[type=\"checkbox\"]').attr('checked', false);") ?></li>
                        </ul>
                    </th></tr>
                </table>
                <?php else: ?>
                <em class="ln-example"><?php echo __('No member companies or users.') ?></em>
                <?php endif ?>
                <h5><?php echo __('Followers') ?></h5>
                <?php if (count($network[RolePeer::RL_GP_FOLLOWER])): ?>
                <table class="objlist">
                <?php foreach ($network[RolePeer::RL_GP_FOLLOWER] as $user): ?>
                <?php $att = $event->getInviteFor($user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER) ?>
                <tr><td><?php echo image_tag($user->getProfilePictureUri()) ?></td>
                    <td><?php echo $user ?></td>
                    <td><?php echo $att ? "<em>".__(EventPeer::$attypNames[$att->getRsvpStatus()])."</em>" : checkbox_tag("network[".PrivacyNodeTypePeer::PR_NTYP_USER."][{$user->getId()}]", 1, $sf_params->get("network[".PrivacyNodeTypePeer::PR_NTYP_USER."][{$user->getId()}]")) ?></td></tr>
                <?php endforeach ?>
                <tr><th colspan="3">
                        <ul class="sepdot _right">
                            <li><?php echo link_to_function(__('Check all'), "$(this).closest('table').find('tr').addClass('_selected').find('input[type=\"checkbox\"]').attr('checked', true);") ?></li>
                            <li><?php echo link_to_function(__('Un-Check all'), "$(this).closest('table').find('tr').removeClass('_selected').find('input[type=\"checkbox\"]').attr('checked', false);") ?></li>
                        </ul>
                    </th></tr>
                </table>
                <?php else: ?>
                <em class="ln-example"><?php echo __('No followers.') ?></em>
                <?php endif ?>
                <h5><?php echo __('Linked Groups') ?></h5>
                <?php if (count($network[RolePeer::RL_GP_LINKED_GROUP])): ?>
                <table class="objlist">
                <?php foreach ($network[RolePeer::RL_GP_LINKED_GROUP] as $group): ?>
                <?php $att = $event->getInviteFor($group->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY) ?>
                <tr><td><?php echo image_tag($group->getProfilePictureUri()) ?></td>
                    <td><?php echo $group->getName() ?></td>
                    <td><?php echo $att ? "<em>".__(EventPeer::$attypNames[$att->getRsvpStatus()])."</em>" : checkbox_tag("network[".PrivacyNodeTypePeer::PR_NTYP_GROUP."][{$group->getId()}]", 1, false) ?></td></tr>
                <?php endforeach ?>
                <tr><th colspan="3">
                        <ul class="sepdot _right">
                            <li><?php echo link_to_function(__('Check all'), "$(this).closest('table').find('tr').addClass('_selected').find('input[type=\"checkbox\"]').attr('checked', true);") ?></li>
                            <li><?php echo link_to_function(__('Un-Check all'), "$(this).closest('table').find('tr').removeClass('_selected').find('input[type=\"checkbox\"]').attr('checked', false);") ?></li>
                        </ul>
                    </th></tr>
                </table>
                <?php else: ?>
                <em class="ln-example"><?php echo __('No linked groups.') ?></em>
                <?php endif ?>
                
                
                <?php endif ?>
                <div class="hrsplit-2"></div>
                <div class="_center"><?php echo submit_tag(__('Invite Selected'), 'class=green-button') ?></div>
                <div class="hrsplit-3"></div>
                </form>
<style>
.objlist { width: 95%; margin: 0px auto; padding: 0px; }
.objlist td { padding: 4px 6px; border-bottom: solid 1px #f5f5f5; vertical-align: middle; font: 12px tahoma; color: #666; line-height: 20px; }
.objlist td img { height: 20px; border: solid 1px transparent; display: block; margin: 0px; }
.objlist tr._overimg, .objlist tr._selected._overimg { background-color: #eb2b2b; }
.objlist tr._overimg img { position: absolute; margin-top: -30px; margin-left: -20px; height: 50px; border: solid 5px #527092; -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; }
.objlist tr._overimg td, .objlist tr._overimg td a, .objlist tr._overimg td em { font-weight: bold; color: #fff; }
.objlist td a, .objlist th a { font: 11px tahoma; color: #0088cc; text-decoration: none; }
.objlist th { padding: 10px 5px 5px 5px; }
.objlist td em { font: 11px arial; color: #888; }
.objlist tr._selected th { background-color: #fff; }
.objlist tr._selected { background-color: #f5fef4; }
.objlist tr._selected img { border-color: #ccc; }
.objlist tr._selected td { font-weight: bold; }
.objlist tr td:first-child { width: 50px; }
.objlist tr td:last-child { width: 80px; text-align: right; }

</style>
            </section>
        </div>
    </div>
    <div class="col_180">
    </div>
</div>
<?php echo javascript_tag("
$(function() {
    $('.objlist tr').click(function(){if ($(this).find('input[type=\"checkbox\"]').is(':checked')) { $(this).removeClass('_selected').find('input[type=\"checkbox\"]').attr('checked', false); } else { $(this).addClass('_selected').find('input[type=\"checkbox\"]').attr('checked', true); }});
    $('.objlist input[type=\"checkbox\"]').click(function(e){e.stopPropagation(); if (this.checked) $(this).closest('tr').addClass('_selected'); else $(this).closest('tr').removeClass('_selected')});
    $('.objlist td').mouseover(function(){ $(this).parent().addClass('_overimg'); }).mouseout(function(){ $(this).parent().removeClass('_overimg'); });
});
") ?>