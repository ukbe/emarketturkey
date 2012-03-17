            <ul class="_side">
                <li<?php echo checkActivePage('@edit-group-profile', null) ?>><?php echo link_to(__('Profile Contents'), "@edit-group-profile?hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('@upload-group-logo', null) ?>><?php echo link_to(__('Group Logo'), "@upload-group-logo?hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('groupProfile/basic', null) ?>><?php echo link_to(__('Basic Information'), "@group-basic?hash={$group->getHash()}") ?></li>
                <li<?php echo checkActivePage('groupProfile/contact', null) ?>><?php echo link_to(__('Contact Details'), "@group-contact?hash={$group->getHash()}") ?></li>
            </ul>