<?php $action = sfContext::getInstance()->getActionName(); $module = sfContext::getInstance()->getModuleName(); ?>
        <div class="box_180">
            <ul class="_side">
                <li<?php echo $module == 'tasks' && $action == 'overview' ? ' class="_on"' : '' ?>><?php echo link_to(__('Tasks Overview'), "@tasks-action?action=overview") ?></li>
                <li<?php echo $module == 'tasks' && $action == 'notifications' ? ' class="_on"' : '' ?>><?php echo link_to(__('Notifications'), "@tasks-action?action=notifications") ?></li>
                <li<?php echo $module == 'tasks' && $action == 'preferences' ? ' class="_on"' : '' ?>><?php echo link_to(__('Edit Preferences'), "@tasks-action?action=preferences") ?></li>
            </ul>
        </div>
