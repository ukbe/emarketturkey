            <div class="box_180 _titleBG_Black">
                <h3><?php echo __('Actions') ?></h3>
                <div>
                    <ul class="side-links">
                        <li><?php echo link_to(__('Manage Group'), $group->getManageUrl(), 'class=inherit-font') ?></li>
                        <li><?php echo link_to(__('Post Jobs'), "@myemt.group-jobs-action?hash={$group->getHash()}&action=overview", 'class=inherit-font') ?></li>
                        <li><?php echo link_to(__('Upload Photo'), $group->getProfileActionUrl('upload'), 'class=inherit-font') ?></li>
                    </ul>
                </div>
            </div>