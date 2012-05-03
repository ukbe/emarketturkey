<ul class="inpage-toolbar">
    <li style="width: 180px;"><div style="margin: 5px 0px 0px 10px;"><?php echo link_to(__('Compose Message'), "@compose-message?$accparam", 'class=action-button') ?></div></li>
    <?php if (isset($message)): ?>
    <li><ul class="_horizontal" style="margin: 5px 15px;">
            <li><?php echo link_to(_('Delete'), $message->getUrl($account, $folder, 'delete'), 'class=action-button') ?></li>
            <li><?php echo link_to(_('Reply'), "@compose-message?" . ($accparam ? "$accparam&" : '') . "_m={$message->getPlug()}", 'class=action-button') ?></li>
            <li><?php echo link_to(_('Unread'), $message->getUrl($account, $folder, 'unread'), 'class=action-button') ?></li>
        </ul></li>
    <?php endif ?>
    <li class="_right"><div class="select">
            <span><?php echo __('Account:') ?><span class="selected<?php echo $account ? ' bold' : '' ?>"><?php echo $account ? $account : __('All') ?></span></span>
            <ul>
                <?php if (count($props) > 1): ?>
                <li class="blank"><?php echo link_to(__('All Messages'), "@messages") ?></li>
                <?php endif ?>
                <?php foreach ($props as $prop): ?>
                <li><?php echo link_to($prop, "@messages?acc={$prop->getPlug()}") ?></li>
                <?php endforeach ?>
            </ul></div>
        </li>
</ul>