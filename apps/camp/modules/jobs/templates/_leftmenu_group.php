<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li class="_profile<?php echo $action == 'profile' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Group Profile'), $group->getProfileUrl()) ?></li>
                <li class="_save<?php echo $saved = $sesuser->getUserGroup($group->getId(), UserBookmarkPeer::BMTYP_FAVOURITE) ? ' click' : '' ?>"><?php echo link_to('<span></span>'.($saved ? __('Remove Bookmark') : __('Bookmark Group')), $group->getProfileActionUrl('jobs')."&act=".($saved ? 'rem' : 'save')) ?></li>
                <li class="_block<?php echo $blocked = $sesuser->getUserGroup($group->getId(), UserBookmarkPeer::BMTYP_BANNED) ? ' click' : '' ?>"><?php echo link_to('<span></span>'.($blocked ? _('Unblock Group') : __('Block Group')), $group->getProfileActionUrl('jobs')."&act=".($blocked ? 'unb' : 'ban')) ?></li>
            </ul>
        </div>
