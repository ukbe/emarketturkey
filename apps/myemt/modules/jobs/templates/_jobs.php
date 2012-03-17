            <ul class="_side margin-b2">
                <li<?php echo checkActivePage('action=overview', null) ?>><?php echo link_to(__('Jobs Overview'), "$route&action=overview") ?></li>
                <li<?php echo checkActivePage('action=post', null) ?>><?php echo link_to(__('Post Job'), "$route&action=post") ?></li>
                <li<?php echo checkActivePage('action=manage', null) ?>><?php echo link_to(__('Manage Jobs'), "$route&action=manage") ?></li>
                <li<?php echo checkActivePage('action=vault', null) ?>><?php echo link_to(__('CV Vault'), "$route&action=vault") ?></li>
            </ul>
            <ul class="_side">
                <li<?php echo checkActivePage('action=profile', null) ?>><?php echo link_to(__('HR Profile'), "$route&action=profile") ?></li>
                <li<?php echo checkActivePage('action=messageTemplates', null) ?>><?php echo link_to(__('Message Templates'), "$route&action=messageTemplates") ?></li>
            </ul>
