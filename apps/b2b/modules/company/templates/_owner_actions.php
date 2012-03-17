            <div class="box_180 _titleBG_Black">
                <h3><?php echo __('Actions') ?></h3>
                <div>
                    <ul class="side-links">
                        <li><?php echo link_to(__('Manage Company'), $company->getManageUrl(), 'class=inherit-font') ?></li>
                        <li><?php echo link_to(__('Post Products'), "@myemt.products-overview?hash={$company->getHash()}", 'class=inherit-font') ?></li>
                        <li><?php echo link_to(__('Post Jobs'), "@myemt.company-jobs-action?hash={$company->getHash()}&action=overview", 'class=inherit-font') ?></li>
                        <li><?php echo link_to(__('Upload Photo'), $company->getProfileActionUrl('upload'), 'class=inherit-font') ?></li>
                    </ul>
                </div>
            </div>