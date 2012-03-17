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
        <div class="box_576 _titleBG_Transparent">
            
            <section>
                <h4 style="border-bottom: none;">
                    <?php echo __('Human Resources Profile') ?>
                </h4>
                <?php echo form_errors() ?>
                <?php echo form_tag("$route&action=profile", 'multipart=true') ?>
                <?php echo input_hidden_tag('act', 'edit') ?>
                <dl class="_table large-form">
                    <dt><?php echo emt_label_for('display_name', $otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? __('Company Name') : __('Group Name')) ?></dt>
                    <dd><?php echo input_tag('display_name', $sf_params->get('display_name', $profile->getName()), 'maxlength=255 style=width:200px;') ?></dd>
                    <dt><?php echo emt_label_for('hrlogo_file', __('HR Logo')) ?></dt>
                    <dd>
                    <?php if ($profile->getHRLogo()): ?>
                    <?php echo image_tag($profile->getHRLogo()->getThumbnailUri()) ?>
                    <?php endif ?>
                    <?php echo input_file_tag('hrlogo_file') ?>
                    <em class="ln-example"><?php echo __('This logo will be used in your Job Posts rather than your default logo.') ?></em></dd>
                </dl>
                <div class="clear"></div>
                <h5><?php echo __('HR Homepage Listing')?></h5>
                <div class="pad-1"><?php echo __('Image files below are used if you purchase advanced listing services. If you have not provided an image for a specific Job Post, below images will be used.') ?></div>
                <p><strong><?php echo __('SpotBox Background Image') ?></strong></p>
                <?php if ($img = $profile->getSpotBoxBackground()): ?>
                <div class="spotbox_back _center margin-b2">
                <?php echo image_tag($img->getMediumUri()) ?>
                </div>
                <?php endif ?>
                <div class="txtCenter">
                    <?php echo input_file_tag('hrlogo_spotbox_back') ?>
                    <em class="ln-example"><?php echo __('SpotBox is a nice dialog box which pops up when you click any job post listed on HR Homepage.<br />This image should be 800x400 pixels.') ?></em>
                </div>
                <p><strong><?php echo __('Platinum Box Default Image') ?></strong></p>
                <?php if ($img = $profile->getPlatinumImage()): ?>
                <div class="spot_mrec _center margin-b2">
                <?php echo image_tag($img->getUri()) ?>
                </div>
                <?php endif ?>
                <div class="txtCenter">
                    <?php echo input_file_tag('hrlogo_platinum') ?>
                    <em class="ln-example"><?php echo __('Platinum listings are placed in a full-sized box on the righthand side of HR Homepage.<br />This image should be 264x220 pixels.') ?></em>
                </div>
                <p><strong><?php echo __('Advanced Listing Default Image') ?></strong></p>
                <?php if ($img = $profile->getRectBoxImage()): ?>
                <div class="spot_nrec _center margin-b2">
                <?php echo image_tag($img->getUri()) ?>
                </div>
                <?php endif ?>
                <div class="txtCenter">
                    <?php echo input_file_tag('hrlogo_rectbox') ?>
                    <em class="ln-example"><?php echo __('Advanced listings are placed in a half-sized box on the righthand side of HR Homepage.<br />This image should be 264x110 pixels.') ?></em>
                </div>
                <p><strong><?php echo __('Branded Listing Default Image') ?></strong></p>
                <?php if ($img = $profile->getCubeBoxImage()): ?>
                <div class="spot_srec _center margin-b2">
                <?php echo image_tag($img->getUri()) ?>
                </div>
                <?php endif ?>
                <div class="txtCenter">
                    <?php echo input_file_tag('hrlogo_cubebox') ?>
                    <em class="ln-example"><?php echo __('Branded listings are placed in a quarter-sized box on the righthand side of HR Homepage.<br />This image should be 128x108 pixels.') ?></em>
                </div>
                <div class="hrsplit-3"></div>
                <hr />
                <div class="hrsplit-2"></div>
                <div class="txtCenter">
                    <?php echo submit_tag(__('Save Changes'), 'class=green-button') ?>
                </div>
                </form>
                <div class="clear"></div>
            </section>
        </div>
    </div>

    <div class="col_180">
    </div>
    
</div>                    