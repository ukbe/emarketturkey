        <div class="box_180 _WhiteBox">
        <h3><?php echo __('Upgrade Account') ?></h3>
        <div class="">
            <?php echo __('Upgrade your account and benefit from premium service advantages.') ?>
            <?php echo link_to(__('See Premium Services'), "@group-manage?action=premium&hash={$group->getHash()}", 'class=inherit-font hover bluelink margin-t2') ?>
            <?php echo link_to(__('Upgrade Account'), "@group-manage?action=upgrade&hash={$group->getHash()}", 'class=green-button margin-t2') ?>
        </div>
        </div>