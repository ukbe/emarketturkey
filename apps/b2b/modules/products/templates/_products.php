<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180">
            <ul class="_side">
                <li<?php echo $action=='spotlight' ? ' class="_on"' :'' ?>><?php echo link_to(__('Products Spotlight'), "@products-action?action=spotlight") ?>
                <li<?php echo $action=='index' ? ' class="_on"' :'' ?>><?php echo link_to(__('Find a Product'), "@products") ?>
                    <?php if (($action=='directory' && (isset($mod) && $mod==1))): ?>
                    <ul><li class="_on"><?php echo link_to(__('Search Results'), '@products') ?></li></ul>
                    <?php endif ?>
                    </li>
                <li<?php echo $action=='network' ? ' class="_on"' :'' ?>><?php echo link_to(__('Products in Your Network'), "@products-action?action=network") ?>
                <li<?php echo ($action=='byCategory' || (isset($mod) && $mod==1)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Category'), "@products-action?action=byCategory") ?></li>
                <li<?php echo ($action=='byCountry' || (isset($mod) && $mod==2)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Country'), "@products-action?action=byCountry") ?></li>
            </ul>
        </div>

        <div class="box_180 _titleBG_Transparent">
            <div class="_noBorder  margin-r2 pad-0 ">
                <?php echo image_tag('content/banner/maze.jpg', 'width=168 class=ui-corner-all') ?>
                <div class="pad-1 smaller">
                    <strong><?php echo __("Can't find it?") ?></strong>
                    <p class="margin-t1 pad-0 margin-b1 t_smaller"><?php echo __('Buyer Tools can help you find products even faster.') ?></p>
                    <?php echo link_to(__('Try Buyer Tools'), '@buyer-tools', 'class=t_blue hover trail-right-11px') ?>
                </div>
            </div>
        </div>
