    <header><?php $module = sfContext::getInstance()->getModuleName() ?>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('Welcome'), '@homepage') ?></dt>
                <dd class="ui-corner-tl<?php echo checkActivePage('@myemt.signup', null, false, '_selected') ?>"><?php echo link_to(__('Become a Member'), '@myemt.signup') ?></dd>
                <dd class="ui-corner-tr<?php echo checkActivePage('@myemt.login', null, false, '_selected') ?>"><?php echo link_to(__('Login'), '@myemt.login') ?></dd>
                <dd class="_sp<?php echo checkActivePage('--UPGRADE', null, false, '_selected') ?>"><?php echo link_to(__('PREMIUM SERVICES'), '@premium') ?></dd>
                <dd class="_pr<?php echo checkActivePage('module=tradeexperts', null, false, '_selected') ?>"><?php echo link_to('<span>TR</span>ADE Experts <sup>®</sup>', '@tradeexperts') ?></dd>
                <dd class="_pr<?php echo checkActivePage('--EMTTRUST', null, false, '_selected') ?>"><?php echo link_to('emt<span>TR</span>UST <sup>®</sup>', '@homepage', 'style=color:#eee') ?></dd>
            </dl>
        </nav>
    </header>