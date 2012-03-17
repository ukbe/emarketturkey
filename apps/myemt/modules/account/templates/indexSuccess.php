<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('account/settings', array('sesuser' => $sesuser)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Account Settings') ?></h4>

                <dl class="_table">
                    <dt><?php echo __('Name') ?></dt>
                    <dd><?php echo $user->getName() ?></dd>
                    <dt><?php echo __('Lastname') ?></dt>
                    <dd><?php echo $user->getLastname() ?></dd>
                    <dt><?php echo __('Alternative Email') ?></dt>
                    <dd><?php echo $user->getAlternativeEmail() ?></dd>
                </dl>
            </section>

        </div>

    </div>

    <div class="col_180">
    </div>
</div>
