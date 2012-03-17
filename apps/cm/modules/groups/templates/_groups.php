<?php $action = sfContext::getInstance()->getActionName() ?>
            <ul class="_side">
                <li<?php echo $action=='featured' ? ' class="_on"' :'' ?>><?php echo link_to(__('Featured Groups'), "@groups-action?action=featured") ?>
                <li<?php echo $action=='index' ? ' class="_on"' :'' ?>><?php echo link_to(__('Find a Group'), "@groups") ?></li>
                <li<?php echo $action=='connected' ? ' class="_on"' :'' ?>><?php echo link_to(__('Groups in Your Network'), "@groups-action?action=connected") ?>
                <li<?php echo ($action=='byCountry' || (isset($mod) && $mod==2)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Country'), "@groups-action?action=byCountry") ?></li>
                <li<?php echo ($action=='byName' || (isset($mod) && $mod==3)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Name'), "@groups-action?action=byName") ?></li>
            </ul>