<?php $action = sfContext::getInstance()->getActionName() ?>
        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li <?php echo $action == 'overview' ? 'class="selected"' : '' ?>><?php echo link_to(__('Overview'), "@services") ?></li>
                <li <?php echo $action == 'forIndividuals' ? 'class="selected"' : '' ?>><?php echo link_to(__('For Individuals'), "@for-individuals") ?></li>
                <li <?php echo $action == 'forSuppliers' ? 'class="selected"' : '' ?>><?php echo link_to(__('For Suppliers'), "@for-suppliers") ?></li>
                <li <?php echo $action == 'forAssociations' ? 'class="selected"' : '' ?>><?php echo link_to(__('For Associations'), "@for-associations") ?></li>
                <li <?php echo $action == 'premium' ? 'class="selected"' : '' ?>><?php echo link_to(__('Premium Services'), "@premium") ?></li>
            </ul>
        </div>