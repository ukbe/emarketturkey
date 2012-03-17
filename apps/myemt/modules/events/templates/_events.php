            <ul class="_side">
                <li<?php echo checkActivePage('action=overview', null) ?>><?php echo link_to(__('Events Overview'), "$route&action=overview") ?></li>
                <li<?php echo checkActivePage('action=add', null) ?>><?php echo link_to(__('Add Event'), "$route&action=add") ?></li>
                <li<?php echo checkActivePage('action=manage', null) ?>><?php echo link_to(__('Manage Events'), "$route&action=manage") ?></li>
            </ul>
