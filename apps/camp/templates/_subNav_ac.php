    <header><?php $module = sfContext::getInstance()->getModuleName() ?>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('ACADEMY'), '@academy') ?></dt>
                <dd class="ui-corner-tl<?php echo $module == 'articles' ? ' _selected' : '' ?>"><?php echo link_to(__('Articles'), '@articles') ?></dd>
                <dd<?php echo $module == 'news' ? ' class="_selected"' : '' ?>><?php echo link_to(__('News'), '@news-home') ?></dd>
                <dd<?php echo $module == 'authors' ? ' class="_selected"' : '' ?>><?php echo link_to(__('Authors'), '@academy') ?></dd>
                <dd class="ui-corner-tr<?php echo $module == 'kb' ? ' _selected' : '' ?>"><?php echo link_to(__('Knowledgebase'), '@kb') ?></dd>
                <dd class="_sp<?php echo checkActivePage('--UPGRADE', null, false, '_selected') ?>"><?php echo link_to(__('UPGRADE'), '@premium') ?></dd>
            </dl>
        </nav>
    </header>