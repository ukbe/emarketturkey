<?php use_helper('Number') ?>
<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
            <ul class="_side margin-b2">
            <?php foreach ($applications as $app): ?>
                <li<?php echo $appid == $app->getId() ? ' class="_on"' : '' ?>><?php echo link_to($app->getName(), "@services?appid={$app->getId()}".($customer ? "&cid=$cid&ctyp=$ctyp}":'')) ?></li>
            <?php endforeach ?>
            </ul>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo $application ? __('%1 Services', array('%1' => $application->getName()))
                                            : __('Featured Services') ?></h4>
                <?php foreach ($services as $service): ?>
                <?php echo $service->getName() ?><br />
                <?php endforeach ?>
            </section>
        </div>
    </div>

    <div class="col_180">
    </div>
    
</div>