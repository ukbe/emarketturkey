<?php $action = sfContext::getInstance()->getActionName() ?>
            <ul class="_side">
                <li<?php echo $action=='featured' ? ' class="_on"' :'' ?>><?php echo link_to(__('Featured Companies'), "@companies-action?action=featured") ?>
                <li<?php echo $action=='index' ? ' class="_on"' :'' ?>><?php echo link_to(__('Find a Company'), "@companies") ?></li>
                <li<?php echo $action=='connected' ? ' class="_on"' :'' ?>><?php echo link_to(__('Companies in Your Network'), "@companies-action?action=connected") ?>
                <li<?php echo ($action=='byIndustry' || (isset($mod) && $mod==1)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Industry'), "@companies-action?action=byIndustry") ?></li>
                <li<?php echo ($action=='byCountry' || (isset($mod) && $mod==2)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Country'), "@companies-action?action=byCountry") ?></li>
                <li<?php echo ($action=='byName' || (isset($mod) && $mod==3)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Name'), "@companies-action?action=byName") ?></li>
            </ul>