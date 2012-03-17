            <ul class="_side">
                <li<?php echo in_array($sf_context->getActionName(), array('settings', 'transfer', 'relations')) ? ' class="_on"' : ''  ?>><?php echo link_to(__('Account Settings'), "@group-account?action=settings&hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=privacy', null) ?>><?php echo link_to(__('Privacy Settings'), "@group-account?action=privacy&hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=orders', null) ?>><?php echo link_to(__('Order History'), "@group-account?action=orders&hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('action=payments', null) ?>><?php echo link_to(__('Payment History'), "@group-account?action=payments&hash={$group->getHash()}") ?></li>
            </ul>