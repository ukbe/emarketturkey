    <ul class="flagBox">
        <li><?php echo link_to(image_tag('layout/badges/icon-GoldMember.png'), '@homepage') ?></li>
        <li><?php echo link_to(image_tag('layout/badges/icon-verifiedCompany.png'), '@homepage') ?></li>
    </ul>
    <hgroup class="_comPro">
        <?php echo link_to(image_tag($company->getProfilePictureUri()), $company->getProfileUrl()) ?>
        <ul class="_horizontal">
            <li><?php echo link_to(__('Products'). "<span>{$nums['products']}</span>", $company->getProfileActionUrl('products')) ?></li>
            <li><?php echo link_to(__('Trade Leads'). "<span>{$nums['bleads']} / {$nums['sleads']}</span>", $company->getProfileActionUrl('leads')) ?></li>
            <li><?php echo link_to(__('Jobs'). "<span>{$nums['jobs']}</span>", $company->getProfileActionUrl('jobs')) ?></li>
            <li><?php echo link_to(__('Events'). "<span>{$nums['events']}</span>", $company->getProfileActionUrl('events')) ?></li>
            <li><?php echo link_to(__('Connections'). "<span>{$nums['connections']}</span>", $company->getProfileActionUrl('connections')) ?></li>
            <li><?php echo link_to(__('Followers'). "<span>{$nums['followers']}</span>", $company->getProfileActionUrl('followers'), array('query_string' => 'relation=follower')) ?></li>
        </ul>
        <dl>
            <dt><em><?php echo $company ?></em></dt>
            <dd></dd>
        </dl>
    </hgroup>