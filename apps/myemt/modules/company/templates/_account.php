            <ul class="_side">
                <li<?php echo in_array($sf_context->getActionName(), array('settings', 'transfer', 'relations')) ? ' class="_on"' : ''  ?>><?php echo link_to(__('Account Settings'), "@company-account?action=settings&hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=privacy', null) ?>><?php echo link_to(__('Privacy Settings'), "@company-account?action=privacy&hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=orders', null) ?>><?php echo link_to(__('Order History'), "@company-account?action=orders&hash={$company->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=payments', null) ?>><?php echo link_to(__('Payment History'), "@company-account?action=payments&hash={$company->getHash()}") ?></li>
            </ul>