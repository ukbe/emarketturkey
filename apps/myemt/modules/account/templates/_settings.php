            <ul class="_side">
                <li<?php echo checkActivePage('@account', null) ?>><?php echo link_to(__('Account Settings'), "@account") ?></li>
                <li<?php echo checkActivePage('@setup-privacy', null) ?>><?php echo link_to(__('Privacy Preferences'), "@setup-privacy") ?></li>
                <li<?php echo checkActivePage('@setup-notify', null) ?>><?php echo link_to(__('Setup Notifications'), "@setup-notify") ?></li>
            </ul>
