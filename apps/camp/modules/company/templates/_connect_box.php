            <div class="box_180 _titleBG_White">
                <h3><?php echo __('Connect') ?></h3>
                <div class="txtCenter ">
                    <div class="hrsplit-3"></div>
                    <?php /* ?>
                    <div><?php echo link_to(__('Follow Company'), '@homepage', 'class=green-button') ?>
                    <p class="t_smaller margin-t1"><?php echo __('%1 followers', array('%1' => $nums['followers'])) ?></p></div>
                    <div class="hrsplit-1"></div>
                    */ ?>
                    <div><?php echo link_to(__('Contact Company'), $company->getProfileActionUrl('contact'), 'class=green-button') ?>
                    <p class="t_smaller margin-t1 pad-b1"><?php echo link_to(__('View Contact Information'), $company->getProfileActionUrl('contact'), 'class=bluelink hover') ?></p></div>
                </div>
            </div>