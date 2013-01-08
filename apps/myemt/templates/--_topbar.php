<?php use_helper('Form') ?>
<div id="topbar">
    <div class="column span-44 prepend-1">
        <?php echo link_to(image_tag('emtlogo.gif', array('alt' => 'Homepage', 'width' => 210)), $sf_user->getUser() ? '@homepage' : '@lobby.homepage') ?></div>
    <div class="column span-155">
        <div class="column span-155">
            <div style="float: right; width: 596px; padding: 0px; height: 26px; vertical-align: middle; text-align: right;">
    <?php include_partial('login/loginStatus') ?>
                </div>
    <?php if ($sf_user->getUser() && !$sf_user->getUser()->getLogin()->isVerified()): ?>
        <div style="margin-top: 40px;"><?php echo link_to(__('Verification Required'), '@verify-email', 'class=lock-16px') ?></div>
    <?php endif ?>
                </div>
    </div>
</div>