<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li class="_profile<?php echo $action == 'profile' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Posts'), $sesuser->getProfileUrl()) ?></li>
                <li class="_career<?php echo $action == 'career' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Career'), $sesuser->getProfileActionUrl('career')) ?></li>
                <?php if ($sesuser->getTradeExpertsAccount(TradeExpertPeer::TX_STAT_APPROVED)): ?>
                <li class="_tradeexpert<?php echo $action == 'tradeExpert' ? ' selected' : '' ?>"><?php echo link_to(__('%1trex Profile', array('%1trex' => image_tag('layout/tradeexperts/tradeexpert-12pt.png'))), $sesuser->getProfileActionUrl('tradeExpert')) ?></li>
                <?php endif ?>
                <li class="_connections<?php echo $action == 'connections' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Connections'), $sesuser->getProfileActionUrl('connections')) ?></li>
                <li class="_photos<?php echo $action == 'photos' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Photos'), $sesuser->getProfileActionUrl('photos')) ?></li>
                <li class="_events<?php echo $action == 'events' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Events'), $sesuser->getProfileActionUrl('events')) ?></li>
            </ul>
        </div>