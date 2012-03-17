<?php $roles = $sesuser->getManagableRoles() ?>
<?php $module = sfContext::getInstance()->getModuleName() ?>
<?php $action = sfContext::getInstance()->getActionName() ?>
<?php $sel = array_values(array_filter($roles, function($role){ return sfContext::getInstance()->getModuleName() == $role->getModule(); })) ?>
<ul class="inpage-toolbar">
    <li<?php echo $module == 'tasks' && $action == 'overview' ? ' class="_selected"' : '' ?>><?php echo link_to(__('Tasks'), "@tasks-action?action=overview") ?></li>
    <li<?php echo $module == 'tasks' && $action == 'notifications' ? ' class="_selected"' : '' ?>><?php echo link_to(__('Notifications'), "@tasks-action?action=notifications") ?></li>
    <li<?php echo $module == 'tasks' && $action == 'settings' ? ' class="_selected"' : '' ?>><?php echo link_to(__('Settings'), "@tasks-action?action=settings") ?></li>
    <li class="_right"><div class="select">
            <span><?php echo __('Role:') ?><span class="selected<?php echo count($sel) ? ' bold' : '' ?>"><?php echo count($sel) ? $sel[0]->getName() : __('Select Role') ?></span></span>
            <ul>
                <?php foreach ($roles as $role): ?>
                <?php if ($module != $role->getModule()): ?>
                <li><?php echo link_to($role, "@{$role->getModule()}-action?=action=overview") ?></li>
                <?php endif ?>
                <?php endforeach ?>
            </ul>
        </li>
</ul>