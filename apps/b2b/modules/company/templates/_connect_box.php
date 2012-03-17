            <div class="box_180 _titleBG_Blue">
                <h3><?php echo __('Connect') ?></h3>
                <div class="txtCenter pad-3">
                    <div><?php echo link_to(__('Follow Company'), '@homepage', 'class=green-button') ?>
                    <p class="t_smaller margin-t1"><?php echo __('%1 followers', array('%1' => $nums['followers'])) ?></p></div>
                    <div><?php echo link_to(__('Contact Company'), '@homepage', 'class=green-button') ?>
                    <p class="t_smaller margin-t1 pad-b1"><?php echo link_to(__('View Contact Information'), $company->getProfileActionUrl('contact')) ?></p></div>
                </div>
            </div>