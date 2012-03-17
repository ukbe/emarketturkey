<?php if ($sf_user->isLoggedIn()): ?>
<?php else: ?>
        <dl id="subNav">
            <dt><a href=""><?php echo __('Control Panel') ?></a></dt>
            <dd class="_selected"><?php echo link_to(__('Login'), '@login') ?></dd>
            <dd><?php echo link_to(__('Become a Member'), '@lobby.signup') ?></dd>
        </dl>
<?php endif ?>