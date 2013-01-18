<div id="notfound">
    <div class="logo"><?php echo image_tag('error404-emt-logo.png') ?></div>
    <div class="right-half">
        <div>
            <?php echo image_tag('error404.'.$sf_user->getCulture().'.png') ?>
            <div>
            <?php echo link_to_function(__('BACK'), 'history.back();', 'class=back') ?>
            <?php echo link_to(__('HOMEPAGE'), '@homepage', 'class=home') ?>
            </div>
        </div>
    </div>
</div>
<style>
.right-half > div { display: block; position: absolute; top: 50%; left: 55px; height: 192px; width: 480px; margin: -96px 0px 0px 0px; background: url(/images/error404.<?php echo $sf_user->getCulture() ?>.png) no-repeat 0px 0px; }
</style>