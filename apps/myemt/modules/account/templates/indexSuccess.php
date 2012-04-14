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
                <h4><div class="_right"><?php echo link_to(__('Edit'), 'account/edit') ?></div>
                    <?php echo __('Account Settings') ?></h4>

                    <dl class="_table _noInput">
                        <dt><?php echo __('Account E-mail') ?></dt>
                        <dd><b class="t_green"><?php echo $sesuser->getLogin()->getEmail() ?></b>
                            <em class="ln-example"><?php echo __('This e-mail is used while logging into eMarketTurkey.') ?></em></dd>
                        <dt><?php echo __('Your Name') ?></dt>
                        <dd><?php echo $sesuser->getDisplayName() ?></dd>
                        <dt><?php echo __('Your Lastname') ?></dt>
                        <dd><?php echo $sesuser->getDisplayLastname() ?></dd>
                        <dt><?php echo __('Alternative E-mail') ?></dt>
                        <dd><?php echo $sesuser->getAlternativeEmail() ?></dd>
                        <dt><?php echo __('Username') ?></dt>
                        <dd><?php echo $sesuser->getLogin()->getUsername() ? 'www.emarketturkey.com/@' . $sesuser->getLogin()->getUsername() : '<em class="t_grey">'.__('Not Set').'</em>' ?>
                            <?php if (!$sesuser->getLogin()->getUsername()): ?>
                                <em class="ln-example"><?php echo __('Once you set your username, you cannot change it.') ?></em>
                            <?php endif ?>
                            </dd>
                    </dl>
            </section>

        </div>

    </div>

    <div class="col_180">
    </div>
</div>
