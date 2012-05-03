        <div class="box_180">
            <ul class="_comMenu">
                <li<?php echo $folder == 'inbox' ? ' class="selected"' : '' ?>><?php echo link_to(__('Inbox'), "@messages?$accparam&folder=inbox") ?></li>
                <li<?php echo $folder == 'sent' ? ' class="selected"' : '' ?>><?php echo link_to(__('Sent'), "@messages?$accparam&folder=sent") ?></li>
                <li<?php echo $folder == 'archive' ? ' class="selected"' : '' ?>><?php echo link_to(__('Archive'), "@messages?$accparam&folder=archive", 'onclick=return false;') ?></li>
            </ul>
        </div>
