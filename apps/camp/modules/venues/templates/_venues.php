<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180">
            <ul class="_side">
                <li><?php echo link_to(__('Featured Trade Shows'), "@events-action?action=featured") ?>
                <li><?php echo link_to(__('Find a Trade Show'), "@tradeshows") ?></li>
                <li><?php echo link_to(__("Who is Attending?"), "@events-action?action=attenders") ?><?php 
                /*
                <li<?php echo ($action=='byIndustry' || (isset($mod) && $mod==1)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Industry'), "@events-action?action=byIndustry") ?></li>
                */ ?>
                <li><?php echo link_to(__('Browse by Country'), "@events-action?action=byCountry") ?></li>
                <li><?php echo link_to(__('Browse by Name'), "@events-action?action=byName") ?></li>
            </ul>
        </div>
        <div class="box_180">
            <ul class="_side">
                <li<?php echo $action=='featured' ? ' class="_on"' :'' ?>><?php echo link_to(__('Featured Venues'), "@venues-action?action=featured") ?>
                <li<?php echo $action=='index' ? ' class="_on"' :'' ?>><?php echo link_to(__('Find a Venue'), "@venues") ?></li>
                <li<?php echo ($action=='byCountry' || (isset($mod) && $mod==2)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Venues by Country'), "@venues-action?action=byCountry") ?></li>
                <li<?php echo ($action=='byName' || (isset($mod) && $mod==3)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Venues by Name'), "@venues-action?action=byName") ?></li>
            </ul>
        </div>