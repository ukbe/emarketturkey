        <div class="box_180"><?php $action = sfContext::getInstance()->getActionName() ?>
            <ul class="_side"><?php $isbuying = $type_id == B2bLeadPeer::B2B_LEAD_BUYING ?>
                <li<?php echo $action=='latest' ? ' class="_on"' :'' ?>><?php echo link_to($isbuying ? __('Latest Buying Leads') : __('Latest Selling Leads'), "@leads-action?action=latest&type_code=$type_code") ?>
                <li<?php echo $action=='index' ? ' class="_on"' :'' ?>><?php echo link_to($isbuying ? __('Search Buying Leads') : __('Search Selling Leads'), $isbuying ? "@buying-leads" : "@selling-leads") ?>
                <li<?php echo $action=='network' ? ' class="_on"' :'' ?>><?php echo link_to(__('Leads from Your Network'), "@leads-action?action=network&type_code=$type_code") ?>
                <li<?php echo ($action=='byCategory' || (isset($mod) && $mod==1)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Category'), "@leads-action?action=byCategory&type_code=$type_code") ?></li>
                <li<?php echo ($action=='byCountry' || (isset($mod) && $mod==2)) ? ' class="_on"' :'' ?>><?php echo link_to(__('Browse by Country'), "@leads-action?action=byCountry&type_code=$type_code") ?></li>
            </ul>
        </div>