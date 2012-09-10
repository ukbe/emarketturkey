<div class="col_948 b2bCompany">

<?php include_partial('profile_top', array('company' => $company, 'nums' => $nums))?>

        <?php if (count($status_posts)): ?>
        <div class="box_762 noBorder" style="margin-left: 136px;">
            <ul id="js-news" class="js-hidden">
            <?php foreach ($status_posts as $spost): ?>
                <li><?php echo link_to($spost->getMessage(), $spost->getUrl()) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
        <?php endif ?>

    <div class="col_180">
<?php include_partial('leftmenu', array('company' => $company))?>

        <?php if (count($events)): ?>
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('Upcoming Events') ?></h3>
            <div>
            <?php foreach ($events as $event): ?>
            <?php endforeach ?>
            </div>
        </div>
        <?php endif ?>
        <?php if (count($partners)): ?>
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('Partners') ?></h3>
            <div>
            <ul class="pad-0 margin-0">
            <?php foreach ($partners as $partner): ?>
            <?php if (!$partner->getLogo()) continue ?>
            <li class="txtCenter pad-2">
                <span class="t_smaller t_grey"><?php echo isset($partner->relation_role_id) ? RolePeer::retrieveByPK($partner->relation_role_id) : '' ?></span>
                <?php echo $partner->getLogo() ? link_to(image_tag($partner->getProfilePictureUri(), array('title' => $partner)), $partner->getProfileUrl()) : '' ?>
            </li>
            <?php endforeach ?>
            </ul>
            </div>
        </div>
        <?php endif ?>
    </div>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576 _title_BoldColor">
                <h3><?php echo __('Company <strong>Profile</strong>') ?></h3>
                <div>
                    <?php if ($profile_image): ?>
                    <div class="t_center profile-teaser"><?php echo image_tag($profile_image->getOriginalUri()) ?></div>
                    <?php endif ?>
                    <?php echo str_replace("\n", "<br />", $profile->getIntroduction()) ?>
                </div>
            </div>
            <div class="box_576 _titleBG_Transparent">
                <h4><?php echo __('Facts') ?></h4>
                <?php
                $facts = array(
                    __('Business Type')     => $company->getBusinessType(),
                    __('Industry')          => $company->getBusinessSector(),
                    __('Products and Services') => str_replace("\n", "<br />", $profile->getProductService()),
                    __('Founded in')        => $profile->getFoundedIn('Y'),
                ) 
                ?>
                <dl class="_table _noInput">
                <?php foreach (array_filter($facts) as $label => $fact): ?>
                    <dt><?php echo $label ?></dt>
                    <dd><?php echo $fact ?></dd>
                <?php endforeach ?>
                </dl>
            </div>
            <?php if (count($top_products) > 3): ?>
            <div class="box_576 _titleBG_Transparent">
                <h4>
                <?php echo link_to(__('See All Products'), $company->getProfileActionUrl('products'), 'class=bluelink hover _right')?>
                <?php echo __('Top Products') ?></h4>
                <div class="scrollable _noBorder">
                    <?php foreach ($top_products as $key => $product): ?>
                    <?php if ($key+1 > floor(count($top_products)/4)*4) break; ?>
                    <?php echo $key % 4 == 0 ? '<ul>' : '' ?>
                        <li>
                            <strong><?php echo link_to($company, $company->getProfileUrl(), array('title' => _('Go to Company Profile'))) ?></strong>
                            <address></address>
                            <p>
                                <?php echo link_to(image_tag($product->getPhotoUri()), $product->getUrl()) ?>
                                <em><?php echo link_to($product, $product->getUrl()) ?></em>
                            </p>
                        </li>
                    <?php echo $key % 4 == 3 ? '</ul>' : '' ?>
                    <?php endforeach ?>
                    <div class="clear"></div>
                </div>
            </div>
            <?php endif ?>
            <?php if (count($profile_photos) > 3): ?>
            <div class="box_576 _titleBG_Transparent">
                <h4>
                <?php echo link_to(__('See All Photos'), $company->getProfileActionUrl('photos'), 'class=bluelink hover _right')?>
                <?php echo __('Photos') ?></h4>
                <div class="scrollable _noBorder">
                    <?php foreach ($profile_photos as $key => $photo): ?>
                    <?php if ($key+1 > floor(count($profile_photos)/4)*4) break; ?>
                    <?php echo $key % 4 == 0 ? '<ul>' : '' ?>
                        <li>
                            <strong><?php echo link_to($photo->getTitle(), $company->getProfileActionUrl('photos')) ?></strong>
                            <address></address>
                            <p>
                                <?php echo link_to(image_tag($photo->getUri()), $photo->getUrl()) ?>
                                <em><?php echo link_to($photo->getTitle(), $photo->getUrl()) ?></em>
                            </p>
                        </li>
                    <?php echo $key % 4 == 3 ? '</ul>' : '' ?>
                    <?php endforeach ?>
                    <div class="clear"></div>
                </div>
            </div>
            <?php endif ?>
            <?php if (count($group_mems)): ?>
            <div class="box_576 _titleBG_Transparent">
                <h4>
                <?php echo link_to(__('See All Groups'), $company->getProfileActionUrl('connections'), array('query_string' => 'relation=group', 'class' => 'bluelink hover _right'))?>
                <?php echo __('Groups') ?></h4>
                <dl class="_table">
                <?php foreach ($group_mems as $key => $group_mem): ?>
                <?php if ($key > 4) break ?>
                <dt><?php echo $group_mem->getGroup()->getLogo() ? link_to(image_tag($group_mem->getGroup()->getProfilePictureUri(), array('alt' => $group_mem->getGroup())), $group_mem->getGroup()->getProfileUrl(), 'class=margin-t2') : '' ?></dt>
                <dd><?php echo link_to($group_mem->getGroup(), $group_mem->getGroup()->getProfileUrl(), 'class=inherit-font bluelink hover') ?>
                    <ul class="sepdot">
                        <li><em class="clear"><?php echo $group_mem->getGroup()->getGroupType() ?></em></li>
                        <?php if ($group_mem->getRoleId() != RolePeer::RL_GP_MEMBER): ?>
                        <li><?php echo $group_mem->getRole() ?></li>
                        <?php endif ?>
                    </ul></dd>
                <?php endforeach ?>
                </dl>
                <?php echo count($group_mem) > 5 ? link_to(__('See all groups'), $company->getProfileActionUrl('connections')) : '' ?>
            </div>
            <?php endif ?>
        </div>

        <div class="col_180">
            <?php if ($own_company): ?>
            <?php include_partial('owner_actions', array('company' => $company)) ?>
            <?php else: ?>
            <?php include_partial('connect_box', array('company' => $company, 'nums' => $nums)) ?>
            <?php endif ?>
            
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $company)) ?>
                </div>
            </div>

        </div>

    </div>


</div>
<?php use_javascript('jquery.ticker.js') ?>
<?php use_stylesheet('ticker-style.css') ?>
<?php echo javascript_tag("
    $(function () {
        $('#js-news').ticker({displayType: 'fade', pauseOnItems: 5000, titleText: '".__('UPDATES:')."', controls: false});
    });
") ?>