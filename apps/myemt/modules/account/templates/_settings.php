            <ul class="_side">
<?php if (!$sf_user->getUser()->getLogin()->isVerified()): ?>
                <li<?php echo checkActivePage('@verify', null) ?>><?php echo link_to(__('Verify Email Address'), "@verify") ?></li>
<?php endif ?>
                <li<?php echo checkActivePage('@account', null) ?>><?php echo link_to(__('Account Settings'), "@account") ?></li>
                <li<?php echo checkActivePage('@setup-privacy', null) ?>><?php echo link_to(__('Privacy Preferences'), "@setup-privacy") ?></li>
                <li<?php echo checkActivePage('@setup-notify', null) ?>><?php echo link_to(__('Setup Notifications'), "@setup-notify") ?></li>
                <li<?php echo checkActivePage('action=changePassword', null) ?>><?php echo link_to(__('Change Password'), "account/changePassword") ?></li>
            </ul>
