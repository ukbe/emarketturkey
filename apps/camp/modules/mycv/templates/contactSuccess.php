<?php use_helper('Date') ?>

<?php slot('subNav') ?>
<?php include_partial('global/subNav_hr') ?>
<?php end_slot() ?>

<div class="col_948">

    <div class="col_180">
    <?php if ($photo = $resume->getPhoto()): ?>
        <div class="box_180 txtCenter">
            <a class="editable-image" href="<?php echo url_for('@mycv-action?action=materials') ?>">
                <?php echo image_tag($photo->getMediumUri()) ?>
                <span class="edittag"><?php echo __('Change Photo') ?></span>
            </a>
        </div>
    <?php endif ?>
        <div class="col_180">
<?php include_partial('mycareer/leftmenu', array('sesuser' => $sesuser))?>
        </div>

    </div>

    <div class="col_576">

        <div class="box_576">
            <h4><?php echo __('Contact Information') ?></h3>
            <div class="_noBorder pad-0">
                <div class="pad-2">
                <p><?php echo __('Please enter your contact information.') ?></p>
                <?php if ($profile_contact): ?>
                <p><?php echo __('Alternatively you may copy contact information from your profile. To do so, click "Copy From Profile" link below.') ?></p>
                <?php echo link_to(__('Copy From Profile'), '@mycv-action?action=contact', array('query_string' => 'mod=rfp', 'class' => 'inherit-font bluelink hover')) ?>
                <?php endif ?>
                </div>
                <?php echo form_errors() ?>
                <?php echo form_tag('@mycv-action?action=contact') ?>
                <?php echo input_hidden_tag('done', __('Done')) ?>
                <?php echo input_hidden_tag('next', __('Next')) ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for('rsmc_email', __('Email Address')) ?></dt>
                    <dd><?php echo select_tag('rsmc_email', options_for_select($user_emails, $contact->getEmail() ? $contact->getEmail() : $sesuser->getLogin()->getEmail()), array('style' => 'width: 180px; margin-right: 10px;'))?>
                        &nbsp;<?php echo input_tag('rsmc_otheremail', $other_email ? $sf_params->get('rsmc_otheremail', $contact->getEmail()) : '', ($other_email ? '' : 'class=ghost ') . 'style=width: 180px;') ?></dd>
                    <dt><b><u><?php echo __('Home Contact Information') ?></u></b></dt>
                    <dt><?php echo emt_label_for('rsmc_home_country', __('Country')) ?></dt>
                    <dd><?php echo select_country_tag('rsmc_home_country', $sf_params->get('rsmc_home_country', $home_address->getCountry()), array('include_custom' => __('select your country'))) ?></dd>
                    <dt><?php echo emt_label_for('rsmc_home_phone', __('Phone')) ?></dt>
                    <dd><?php echo input_tag('rsmc_home_phone', $home_phone->getPhone(), 'size=20') ?></dd>
                    <dt><?php echo emt_label_for('rsmc_home_street', __('Street Address')) ?></dt>
                    <dd><?php echo input_tag('rsmc_home_street', $home_address->getStreet(), 'size=50') ?></dd>
                    <dt><?php echo emt_label_for('rsmc_home_state', __('State/Province')) ?></dt>
                    <dd><?php echo select_tag('rsmc_home_state', options_for_select($contact_cities, $home_address->getState(), array('include_custom' => __('select state/province')))) ?></dd>
                    <dt><?php echo emt_label_for('rsmc_home_city', __('City/Town')) ?></dt>
                    <dd><?php echo input_tag('rsmc_home_city', $home_address->getCity(), 'size=17') ?></dd>
                    <dt><?php echo emt_label_for('rsmc_home_postalcode', __('Postal Code')) ?></dt>
                    <dd><?php echo input_tag('rsmc_home_postalcode', $home_address->getPostalcode(), 'size=10') ?></dd>
                    <dt><b><u><?php echo __('Work Contact Information') ?></u></b></dt>
                    <dt><?php echo emt_label_for('rsmc_work_country', __('Country')) ?></dt>
                    <dd><?php echo select_country_tag('rsmc_work_country', $sf_params->get('rsmc_work_country', $work_address->getCountry()), array('include_custom' => __('select your country'))) ?></dd>
                    <dt><?php echo emt_label_for('rsmc_work_phone', __('Phone')) ?></dt>
                    <dd><?php echo input_tag('rsmc_work_phone', $work_phone->getPhone(), 'size=20') ?></dd>
                    <dt><?php echo emt_label_for('rsmc_work_street', __('Street Address')) ?></dt>
                    <dd><?php echo input_tag('rsmc_work_street', $work_address->getStreet(), 'size=50') ?></dd>
                    <dt><?php echo emt_label_for('rsmc_work_state', __('State/Province')) ?></dt>
                    <dd><?php echo select_tag('rsmc_work_state', options_for_select($contact_cities, $work_address->getState(), array('include_custom' => __('select state/province')))) ?></dd>
                    <dt><?php echo emt_label_for('rsmc_work_city', __('City/Town')) ?></dt>
                    <dd><?php echo input_tag('rsmc_work_city', $work_address->getCity(), 'size=20') ?></dd>
                    <dt><?php echo emt_label_for('rsmc_work_postalcode', __('Postal Code')) ?></dt>
                    <dd><?php echo input_tag('rsmc_work_postalcode', $work_address->getPostalcode(), 'size=10') ?></dd>
                </dl>
                <div class="txtCenter">
                    <?php echo link_to(__('Back'), '@mycv-action?action=basic', 'class=action-button _left')?>
                    <?php echo submit_tag(__('Next'), 'class=action-button _right')?>
                    <?php echo submit_tag(__('Done'), 'class=action-button')?>&nbsp;&nbsp;<?php echo link_to(__('Cancel'), '@mycv-action?action=review', 'class=bluelink hover') ?>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col_180">
        <?php include_partial('cv-steps-right', array('sesuser' => $sesuser, 'resume' => $resume)) ?>
        
    </div>
</div>
<?php use_javascript('emt-branch-1.0.js')?>
<?php use_javascript('emt-location-1.0.js') ?>
<?php echo javascript_tag("
    $('#rsmc_email').branch({map: {'new': '#rsmc_otheremail'}})

    $('#rsmc_home_country, #rsmc_work_country').location({url: '".url_for('@myemt.location-query')."'});

") ?>