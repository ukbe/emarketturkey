<?php $action = sfContext::getInstance()->getActionName() ?>
            <ul class="_side">
                <li<?php echo $action=='find' ? ' class="_on"' :'' ?>><?php echo link_to(__('Find Trade Experts'), "@tradeexperts-action?action=find") ?>
                <li<?php echo $action=='connected' ? ' class="_on"' :'' ?>><?php echo link_to(__('Trade Experts in Your Network'), "@tradeexperts-action?action=connected") ?>
                <li<?php echo ($action=='byIndustry' || (isset($mod) && $mod==1)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Industry'), "@tradeexperts-action?action=byIndustry") ?></li>
                <li<?php echo ($action=='byCountry' || (isset($mod) && $mod==2)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Country'), "@tradeexperts-action?action=byCountry") ?></li>
                <li<?php echo ($action=='byName' || (isset($mod) && $mod==3)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Name'), "@tradeexperts-action?action=byName") ?></li>
            </ul>