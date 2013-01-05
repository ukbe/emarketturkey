    <ul class="flagBox">
        <?php if ($user->getTradeExpertsAccount(TradeExpertPeer::TX_STAT_APPROVED)): ?>
        <li><?php echo link_to(image_tag('layout/tradeexperts/tradeexpert-18pt.png', array('title' => __('View Trade Expert Profile'))), $user->getProfileActionUrl('tradeExpert')) ?></li>
        <?php endif ?>
    </ul>
    <hgroup class="_comPro">
        <dl>
            <dt><em><?php echo $user ?></em></dt>
            <?php if (count($career = array_filter($user->getCareerLabel()))): ?>
            <dd><?php echo implode(' | ', $career) ?></dd>
            <?php endif ?>
        </dl>
        <div style="float:right; margin-top: 15px; clear: both;">
        <ul class="trailButtons">
            <?php if (($relation = $sesuser->hasRelation($user)) && $relation->getStatus() == RelationPeer::RL_STAT_ACTIVE): ?>        
            <li><?php echo link_to('<span></span>'.__('Connected'), "@connect-edit-user?user={$user->getPlug()}", "class=action-button connected-user ajax-enabled id=cnus-{$user->getPlug()}") ?></li>
            <?php elseif ($relation && $relation->getStatus() == RelationPeer::RL_STAT_PENDING_CONFIRMATION): ?>
            <?php if ($relation->getUserId() == $sesuser->getId()): ?>
            <li><?php echo link_to('<span></span>'.__('Request Sent'), "@connect-edit-user?user={$user->getPlug()}", "class=action-button connect-user ajax-enabled id=cnus-{$user->getPlug()}") ?></li>
            <?php else: ?>
            <li><?php echo link_to('<span></span>'.__('Respond to Request'), "@connect-edit-user?user={$user->getPlug()}", "class=action-button connect-user ajax-enabled id=cnus-{$user->getPlug()}") ?></li>
            <?php endif ?>
            <?php elseif ($sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $user)): ?>
            <li><?php echo link_to('<span></span>'.__('Connect'), "@connect-user?user={$user->getPlug()}", "class=action-button connect-user ajax-enabled id=cnus-{$user->getPlug()}") ?></li>
            <?php endif ?>
            
            <?php if ($sesuser->can(ActionPeer::ACT_SEND_MESSAGE, $user)): ?>
            <li><?php echo link_to('<span></span>'.__('Send Message'), "@myemt.compose-message?_s={$sesuser->getPlug()}&_r={$user->getPlug()}&_ref=$_here", "class=action-button message ajax-enabled id=msgus-{$user->getPlug()}") ?></li>
            <?php endif ?>
        </ul>
        </div>
        <ul class="_horizontal">
            <li><?php echo link_to(__('Career'). "<span>{$nums['crworks']} / {$nums['crschools']}</span>", $user->getProfileActionUrl('career')) ?></li>
            <li><?php echo link_to(__('Connections'). "<span>{$nums['connections']}</span>", $user->getProfileActionUrl('connections')) ?></li>
            <li><?php echo link_to(__('Photos'). "<span>{$nums['photos']}</span>", $user->getProfileActionUrl('photos')) ?></li>
            <li><?php echo link_to(__('Events'). "<span>{$nums['events']}</span>", $user->getProfileActionUrl('events')) ?></li>
        </ul>
    </hgroup>