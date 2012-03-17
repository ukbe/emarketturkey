<?php $module = sfContext::getInstance()->getModuleName() ?>
<?php $action = sfContext::getInstance()->getActionName() ?>
    <header>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('JOBS'), '@homepage') ?></dt>
                <dd class="ui-corner-tl<?php echo checkActivePage('@jobsearch', null, false, '_selected') ?>"><?php echo link_to(__('Job Search'), '@jobsearch', 'class=hr-job-search') ?></dd>
                <dd<?php echo $module == 'mycareer' || $module == 'mycv' ? ' class="_selected"' : '' ?>><?php echo link_to(__('My Career'), '@mycareer') ?></dd>
                <dd class="ui-corner-tr"><?php echo link_to(__('Bookmarks') . image_tag('layout/icon/shortcut-8px.png', 'style=margin: 2px 0px -2px 5px;'), '@mycareer-action?action=bookmarks') ?></dd>
                <dd class="_sp<?php echo checkActivePage('--UPGRADE', null, false, '_selected') ?>"><?php echo link_to(__('UPGRADE'), '@homepage') ?></dd>
            </dl>
        </nav>
    </header>