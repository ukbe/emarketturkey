<?php $action = sfContext::getInstance()->getActionName(); $module = sfContext::getInstance()->getModuleName(); ?>
        <div class="box_180">
            <ul class="_side">
                <li<?php echo $action == 'overview' ? ' class="_on"' : '' ?>><?php echo link_to(__('Dashboard'), "@author-action?action=overview") ?></li>
                <li<?php echo ($action == 'news' || $action == 'newss') && $sf_params->get('filter') != 'none' ? ' class="_on"' : '' ?>><?php echo link_to(__('News'), "@author-action?action=newss") ?></li>
                <li<?php echo ($action == 'article' || $action == 'articles') && $sf_params->get('filter') != 'none' ? ' class="_on"' : '' ?>><?php echo link_to(__('Articles'), "@author-action?action=articles") ?></li>
            </ul>
        </div>
<?php if ($sf_user->hasCredential('editor')): ?>
        <div class="box_180">
            <strong class="pad-1"><?php echo __('Editor') ?></strong>
            <ul class="_side">
                <li<?php echo ($action == 'articles' || $action == 'article') && $sf_params->get('filter') == 'none' ? ' class="_on"' : '' ?>><?php echo link_to(__('All Articles'), "@author-action?action=articles&filter=none") ?></li>
                <li<?php echo ($action == 'newss' || $action == 'news') && $sf_params->get('filter') == 'none' ? ' class="_on"' : '' ?>><?php echo link_to(__('All News'), "@author-action?action=newss&filter=none") ?></li>
                <li<?php echo $action == 'categories' || $action == 'category' ? ' class="_on"' : '' ?>><?php echo link_to(__('Publication Categories'), "@author-action?action=categories") ?></li>
                <li<?php echo $action == 'source' || $action == 'sources' ? ' class="_on"' : '' ?>><?php echo link_to(__('Publication Sources'), "@author-action?action=sources") ?></li>
                <li<?php echo $action == 'author' || $action == 'authors' ? ' class="_on"' : '' ?>><?php echo link_to(__('Authors'), "@author-action?action=authors") ?></li>
            </ul>
        </div>
<?php endif ?>