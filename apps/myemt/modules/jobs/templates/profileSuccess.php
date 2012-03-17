<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>
<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            
            <section>
                <h4 style="border-bottom: none;">
                    <?php echo __('Human Resources Profile') ?>
                </h4>
            <?php if (!$profile->isNew()): ?>
                <dl class="_table large-form _noInput">
                    <dt><?php echo emt_label_for('display_name', __('Company Name')) ?></dt>
                    <dd><?php echo $profile->getName() ?></dd>
                    <dt><?php echo emt_label_for('hrlogo_file', __('HR Logo')) ?></dt>
                    <dd>
                    <?php if ($profile->getHRLogo()): ?>
                    <?php echo image_tag($profile->getHRLogo()->getThumbnailUri()) ?>
                    <em class="ln-example"><?php echo __('This logo will be used in your Job Posts rather than your default logo.') ?></em>
                    <?php else: ?>
                    <span class="t_red"><?php echo __('No logo uploaded yet!') ?></span>
                    <?php endif ?></dd>
                    <dt></dt>
                    <dd><?php echo link_to(__('Edit Profile'), "$route&action=profile&act=edit", 'class=green-button') ?></dd>
                </dl>
                <div class="clear"></div>
                <h5><?php echo __('HR Homepage Listing')?></h5>
                <div class="pad-1"><?php echo __('Image files below are used if you purchase advanced listing services. If you have not provided an image for a specific Job Post, below images will be used.') ?></div>
                <p><strong><?php echo __('SpotBox Background Image') ?></strong></p>
                <?php echo link_to(($img = $profile->getSpotBoxBackground()) ? image_tag($img->getMediumUri()) : '&nbsp;', "$route&action=profile&act=edit", array('class' => 'spotbox_back _center'.($img ? '' : ' empty'), 'title' => __('Click to upload a new image'))) ?>
                <div class="txtCenter"><em class="ln-example"><?php echo __('SpotBox is a nice dialog box which pops up when you click any job post listed on HR Homepage.<br />This image should be 800x400 pixels.') ?></em></div>
                <p><strong><?php echo __('Platinum Box Default Image') ?></strong></p>
                <?php echo link_to(($img = $profile->getPlatinumImage()) ? image_tag($img->getUri()) : '&nbsp;', "$route&action=profile&act=edit", array('class' => 'spot_mrec _center'.($img ? '' : ' empty'), 'title' => __('Click to upload a new image'))) ?>
                <div class="txtCenter"><em class="ln-example"><?php echo __('Platinum listings are placed in a full-sized box on the righthand side of HR Homepage.<br />This image should be 264x220 pixels.') ?></em></div>
                <p><strong><?php echo __('Advanced Listing Default Image') ?></strong></p>
                <?php echo link_to(($img = $profile->getRectBoxImage()) ? image_tag($img->getUri()) : '&nbsp;', "$route&action=profile&act=edit", array('class' => 'spot_nrec _center'.($img ? '' : ' empty'), 'title' => __('Click to upload a new image'))) ?>
                <div class="txtCenter"><em class="ln-example"><?php echo __('Advanced listings are placed in a half-sized box on the righthand side of HR Homepage.<br />This image should be 264x110 pixels.') ?></em></div>
                <p><strong><?php echo __('Branded Listing Default Image') ?></strong></p>
                <?php echo link_to(($img = $profile->getCubeBoxImage()) ? image_tag($img->getUri()) : '&nbsp;', "$route&action=profile&act=edit", array('class' => 'spot_srec _center'.($img ? '' : ' empty'), 'title' => __('Click to upload a new image'))) ?>
                <div class="txtCenter"><em class="ln-example"><?php echo __('Branded listings are placed in a quarter-sized box on the righthand side of HR Homepage.<br />This image should be 128x108 pixels.') ?></em></div>
            <?php else: ?>
                <?php echo __('You should create your Human Resources Profile in order to start using eMarketTurkey Jobs.') ?>
                <div class="hrsplit-2"></div>
                <?php echo __('Creating your HR Profile is easy!') ?>
                <div class="hrsplit-3"></div>
                <?php echo link_to(__('Create HR Profile'), "$route&action=profile&act=edit", 'class=green-button') ?>
            <?php endif ?>
                <div class="clear"></div>
            </section>
        </div>
    </div>

    <div class="col_180">
    </div>
    
</div>                    