<?php $action = sfContext::getInstance()->getActionName() ?>
            <ul class="_side">
                <li<?php echo $action=='pymk' ? ' class="_on"' :'' ?>><?php echo link_to(__('People You May Know'), "@people-action?action=pymk") ?>
                <li<?php echo $action=='index' ? ' class="_on"' :'' ?>><?php echo link_to(__('Find Someone'), "@people") ?></li>
                <li<?php echo $action=='connected' ? ' class="_on"' :'' ?>><?php echo link_to(__('People in Your Network'), "@people-action?action=connected") ?>
                <li<?php echo ($action=='byCountry' || (isset($mod) && $mod==2)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Country'), "@people-action?action=byCountry") ?></li>
                <li<?php echo ($action=='byName' || (isset($mod) && $mod==3)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Name'), "@people-action?action=byName") ?></li>
            </ul>