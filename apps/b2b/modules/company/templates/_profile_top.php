<?php echo auto_discovery_link_tag('', $company->getProfilePictureUri(MediaItemPeer::LOGO_TYPE_ORIGINAL), array('rel' => 'image_src', 'type' => '')) ?>
    <?php if ($account = $company->getPremiumAccount()): ?>
    <ul class="flagBox">
        <li><?php echo link_to(image_tag($account->getBadgeUri('medium')), '@homepage') ?></li>
        <li><?php echo link_to(image_tag('layout/badges/icon-verifiedCompany.png'), '@homepage') ?></li>
    </ul>
    <?php endif ?>
    <hgroup class="_comPro">
        <?php echo link_to(image_tag($company->getProfilePictureUri()), $company->getProfileUrl()) ?>
        <dl>
            <dt><em><?php echo $company ?></em></dt>
            <dd></dd>
        </dl>
        <ul class="_horizontal">
            <li><?php echo link_to(__('Products'). "<span>{$nums['products']}</span>", $company->getProfileActionUrl('products')) ?></li>
            <li><?php echo link_to(__('Trade Leads'). "<span>{$nums['bleads']} / {$nums['sleads']}</span>", $company->getProfileActionUrl('leads')) ?></li>
            <li><?php echo link_to(__('Jobs'). "<span>{$nums['jobs']}</span>", $company->getProfileActionUrl('jobs')) ?></li>
            <li><?php echo link_to(__('Events'). "<span>{$nums['events']}</span>", $company->getProfileActionUrl('events')) ?></li>
            <li><?php echo link_to(__('Connections'). "<span>{$nums['connections']}</span>", $company->getProfileActionUrl('connections')) ?></li>
            <li><?php echo link_to(__('Followers'). "<span>{$nums['followers']}</span>", $company->getProfileActionUrl('connections'), array('query_string' => 'relation=follower')) ?></li>
        </ul>
    </hgroup>