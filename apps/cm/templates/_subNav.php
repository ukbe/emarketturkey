    <header><?php $module = sfContext::getInstance()->getModuleName() ?>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('COMMUNITY'), '@homepage') ?></dt>
                <dd class="ui-corner-tl<?php echo $module == 'people' ? ' _selected' : '' ?>"><?php echo link_to(__('People'), '@people') ?></dd>
                <dd<?php echo $module == 'groups' || $module == 'group' ? ' class="_selected"' : '' ?>><?php echo link_to(__('Groups'), '@groups') ?></dd>
                <dd class="ui-corner-tr<?php echo $module == 'events' ? ' _selected' : '' ?>"><?php echo link_to(__('Events'), '@events') ?></dd>
                <dd class="_sp<?php echo checkActivePage('--UPGRADE', null, false, '_selected') ?>"><?php echo link_to(__('UPGRADE'), '@homepage') ?></dd>
            </dl>
        </nav>
    </header>