<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li class="_profile<?php echo $action == 'profile' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Company Profile'), $company->getProfileUrl()) ?></li>
                <li class="_products<?php echo $action == 'products' || $action == 'product' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Products'), $company->getProfileActionUrl('products')) ?>
                <?php if (($action=='products' || $action=='product') && (count($groups) || count($categories))): ?>
                    <dl>
                        <dt><?php echo __('Products') ?></dt>
                        <?php if (count($groups)): ?>
                        <dd><?php echo link_to(__('Ungrouped'), $company->getProfileActionUrl('products')) ?></dd>
                        <?php foreach ($groups as $group): ?>
                        <dd><?php echo link_to($group, $group->getUrl()) ?></dd>
                        <?php endforeach ?>
                        <?php else: ?>
                        <?php foreach ($categories as $category): ?>
                        <dd><?php echo link_to($category, "@company-product-substitute?hash={$company->getHash()}&substitute={$category->getStrippedCategory()}") ?></dd>
                        <?php endforeach ?>
                        <?php endif ?>
                    </dl>
                <?php endif ?>
                </li>
                <li class="_leads<?php echo $action == 'leads' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Trade Leads'), $company->getProfileActionUrl('leads')) ?></li>
                <li class="_jobs<?php echo $action == 'jobs' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Jobs'), "@company-jobs?hash={$company->getHash()}") ?></li>
                <li class="_connections<?php echo $action == 'connections' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Connections'), $company->getProfileActionUrl('connections')) ?></li>
                <li class="_photos<?php echo $action == 'photos' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Photos'), $company->getProfileActionUrl('photos')) ?></li>
                <li class="_events<?php echo $action == 'events' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Events'), $company->getProfileActionUrl('events')) ?></li>
                <li class="_contact<?php echo $action == 'contact' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Contact'), $company->getProfileActionUrl('contact')) ?></li>
            </ul>
        </div>
        <div class="box_180 txtCenter">
            <div class="_noBorder txtCenter">
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style" style="display: inline-block;">
                    <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=emarketturkey" class="addthis_button_compact"><?php echo __('Bookmark/Share')?></a>
                </div>
                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=emarketturkey"></script>
                <!-- AddThis Button END -->
                <div class="hrsplit-2"></div>
                <?php echo like_button($company) ?>
            </div>
        </div>
        