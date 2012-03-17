    <header><?php $module = sfContext::getInstance()->getModuleName() ?>
        <nav>
            <dl id="subNav">
                <dt><?php echo link_to(__('B2B'), '@homepage') ?></dt>
                <dd class="ui-corner-tl<?php echo checkActivePage('@companies', null, false, '_selected') ?>"><?php echo link_to(__('Companies'), '@companies') ?></dd>
                <dd<?php echo checkActivePage('@products', null, true, '_selected') ?>><?php echo link_to(__('Products and Services'), '@products') ?></dd>
                <dd<?php echo $module=='leads' && $sf_params->get('type_code')=='buying' ? ' class="_selected"' : '' ?>><?php echo link_to(__('Buying Leads'), '@buying-leads') ?></dd>
                <dd<?php echo $module=='leads' && $sf_params->get('type_code')=='selling' ? ' class="_selected"' : '' ?>><?php echo link_to(__('Selling Leads'), '@selling-leads') ?></dd>
                <dd class="ui-corner-tr<?php echo $module == 'events' || $module == 'venues' ? ' _selected' : '' ?>"><?php echo link_to(__('Trade Shows'), '@tradeshows') ?></dd>
                <dd class="_sp<?php echo checkActivePage('--UPGRADE', null, false, '_selected') ?>"><?php echo link_to(__('UPGRADE'), '@homepage') ?></dd>
                <dd class="_pr<?php echo checkActivePage('module=tradeexperts', null, false, '_selected') ?>"><?php echo link_to('<span>TR</span>ADE Experts <sup>®</sup>', '@tradeexperts') ?></dd>
                <dd class="_pr<?php echo checkActivePage('--EMTTRUST', null, false, '_selected') ?>"><?php echo link_to('emt<span>TR</span>UST <sup>®</sup>', '@homepage', 'style=color:#eee') ?></dd>
            </dl>
        </nav>
    </header>