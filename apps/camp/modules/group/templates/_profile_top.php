    <ul class="flagBox">
    </ul>
    <hgroup class="_comPro">
        <dl>
            <dt><em><?php echo $group ?></em></dt>
            <dd><?php echo $group->getGroupType() ?></dd>
        </dl>
        <div style="float:right; margin-top: 15px; clear: both;">
        <ul class="trailButtons">
            <?php if (count($userprops) == 1): ?>
            <?php if (($membership = $sesuser->getGroupMembership($group->getId())) && $membership->getStatus() == GroupMembershipPeer::STYP_ACTIVE): ?>        
            <li><?php echo link_to('<span></span>'.__('Joined'), "@edit-group-mem?group={$group->getPlug()}", "class=action-button connected-user ajax-enabled id=cnus-{$group->getPlug()}") ?></li>
            <?php elseif ($membership && $membership->getStatus() == GroupMembershipPeer::STYP_PENDING): ?>
            <li><?php echo link_to('<span></span>'.__('Pending'), "@edit-group-mem?user={$group->getPlug()}", "class=action-button connect-user ajax-enabled id=cnus-{$group->getPlug()}") ?></li>
            <?php elseif ($membership && $membership->getStatus() == GroupMembershipPeer::STYP_INVITED): ?>
            <li><?php echo link_to('<span></span>'.__('Respond to Invitation'), "@group-invitation?group={$user->getPlug()}", "class=action-button connect-user ajax-enabled id=cnus-{$group->getPlug()}") ?></li>
            <?php elseif ($sesuser->can(ActionPeer::ACT_JOIN_GROUP, $group)): ?>
            <li><?php echo link_to('<span></span>'.__('Join'), "@join-group?group={$group->getPlug()}", "class=action-button connect-user ajax-enabled id=cnus-{$group->getPlug()}") ?></li>
            <?php endif ?>
            <?php else: ?>
            <li><?php echo link_to('<span></span>'.__('Join'), "@join-group?user={$group->getPlug()}", "class=action-button connect-user ajax-enabled id=cnus-{$group->getPlug()}") ?></li>
            <?php endif ?>
            
            <?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $group)): ?>
            <li><?php echo link_to('<span></span>'.__('Send Message'), "@myemt.compose-message?_s={$sesuser->getPlug()}&_r={$group->getPlug()}&_ref=$_here", "class=action-button message ajax-enabled id=msgus-{$group->getPlug()}") ?></li>
            <?php endif ?>
        </ul>
        </div>
        <ul class="_horizontal">
            <li><?php echo link_to(__('Discussions'). "<span>{$nums['discussions']}</span>", $group->getProfileActionUrl('discussions')) ?></li>
            <li><?php echo link_to(__('Connections'). "<span>{$nums['connections']}</span>", $group->getProfileActionUrl('connections')) ?></li>
            <li><?php echo link_to(__('Events'). "<span>{$nums['events']}</span>", $group->getProfileActionUrl('events')) ?></li>
            <li><?php echo link_to(__('Jobs'). "<span>{$nums['jobs']}</span>", $group->getProfileActionUrl('jobs')) ?></li>
            <li><?php echo link_to(__('Photos'). "<span>{$nums['photos']}</span>", $group->getProfileActionUrl('photos')) ?></li>
        </ul>
    </hgroup>