<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li class="_profile<?php echo $action == 'profile' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Company Profile'), $company->getProfileUrl()) ?></li>
                <li class="_save<?php echo $saved = $sesuser->getUserCompany($company->getId(), UserBookmarkPeer::BMTYP_FAVOURITE) ? ' click' : '' ?>"><?php echo link_to('<span></span>'.($saved ? __('Remove Bookmark') : __('Bookmark Company')), "@company-jobs?hash={$company->getHash()}&act=".($saved ? 'rem' : 'save')) ?></li>
                <li class="_block<?php echo $blocked = $sesuser->getUserCompany($company->getId(), UserBookmarkPeer::BMTYP_BANNED) ? ' click' : '' ?>"><?php echo link_to('<span></span>'.($blocked ? _('Unblock Company') : __('Block Company')), "@company-jobs?hash={$company->getHash()}&act=".($blocked ? 'unb' : 'ban')) ?></li>
            </ul>
        </div>
