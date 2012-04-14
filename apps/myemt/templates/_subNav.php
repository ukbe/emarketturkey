<?php if ($sf_user->isLoggedIn()): ?>

<?php else: ?>
<?php $module = sfContext::getInstance()->getModuleName() ?>
<?php $action = sfContext::getInstance()->getActionName() ?>
    <header>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('myEMT'), '@homepage') ?></dt>
                <dd class="ui-corner-tl<?php echo checkActivePage('@login', null, false, '_selected') ?>"><?php echo link_to(__('Login'), '@login') ?></dd>
                <dd class="ui-corner-tr<?php echo checkActivePage('@signup', null, false, '_selected') ?>"><?php echo link_to(__('Become a Member'), '@signup') ?></dd>
            </dl>
        </nav>
    </header>
<?php endif ?>