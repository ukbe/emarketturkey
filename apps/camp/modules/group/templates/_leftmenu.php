<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li class="_profile<?php echo $action == 'info' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Info'), $group->getProfileActionUrl('info')) ?></li>
                <li class="_posts<?php echo $action == 'posts' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Posts'), $group->getProfileUrl()) ?></li>
                <li class="_discussions<?php echo $action == 'discussions' || $action == 'discussion' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Discussions'), $group->getProfileActionUrl('discussions')) ?></li>
                <li class="_jobs<?php echo $action == 'jobs' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Jobs'), "@group-jobs?hash={$group->getHash()}") ?></li>
                <li class="_connections<?php echo $action == 'connections' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Connections'), $group->getProfileActionUrl('connections')) ?></li>
                <li class="_photos<?php echo $action == 'photos' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Photos'), $group->getProfileActionUrl('photos')) ?></li>
                <li class="_events<?php echo $action == 'events' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Events'), $group->getProfileActionUrl('events')) ?></li>
                <?php if ($group->getTypeId() != GroupTypePeer::GRTYP_ONLINE): ?>
                <li class="_contact<?php echo $action == 'contact' ? ' selected' : '' ?>"><?php echo link_to('<span></span>'.__('Contact'), $group->getProfileActionUrl('contact')) ?></li>
                <?php endif ?>
            </ul>
        </div>
        <div class="box_180 txtCenter">
            <div class="_noBorder">
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style" style="display: inline-block;">
                    <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=emarketturkey" class="addthis_button_compact"><?php echo __('Bookmark/Share')?></a>
                </div>
                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=emarketturkey"></script>
                <!-- AddThis Button END -->
                <div class="hrsplit-2"></div>
                <?php echo like_button($group) ?>
            </div>
        </div>
        