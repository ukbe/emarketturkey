<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li <?php echo $action == 'overview' ? 'class="selected"' : '' ?>><?php echo link_to(__('Overview'), "support/overview") ?></li>
                <li <?php echo $action == 'help' ? 'class="selected"' : '' ?>><?php echo link_to(__('Help Center'), "support/help") ?></li>
                <li <?php echo $action == 'faq' ? 'class="selected"' : '' ?>><?php echo link_to(__('Frequently Asked Questions (FAQ)'), "support/faq") ?></li>
            </ul>
        </div>