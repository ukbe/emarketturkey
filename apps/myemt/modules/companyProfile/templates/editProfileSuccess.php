<?php slot('subNav') ?>
<?php include_partial('company/subNav', array('company' => $company)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('companyProfile/editProfile', array('company' => $company)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Corporate Information') ?></h4>
                <div class="btn_container">
                    <?php echo link_to('<span class="ui-icon ui-icon-pencil"></span><span class="ui-button-text">'.__('edit').'</span>', "@company-corporate?hash={$company->getHash()}", 'class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"') ?>
                </div>
                <dl class="_table _noInput">
                    <dt><?php echo __('Company Name') ?></dt>
                    <dd><?php echo $company->getName() ?></dd>
                    <dt><?php echo __('Sector') ?></dt>
                    <dd><?php echo $company->getBusinessSector() ?></dd>
                    <dt><?php echo __('Business Type') ?></dt>
                    <dd><?php echo $company->getBusinessType() ?></dd>
                    <dt><?php echo __('Introduction') ?></dt>
                    <dd><?php echo str_replace("\r\n", '<br />', $profile->getIntroduction()) ?></dd>
                    <dt><?php echo __('Products and Services') ?></dt>
                    <dd><?php echo str_replace("\r\n", '<br />', $profile->getProductService()) ?></dd>
                </dl>
            </section>

            <section>
                <h4><?php echo __('Contact Information') ?></h4>
                <div class="btn_container">
                    <?php echo link_to('<span class="ui-icon ui-icon-pencil"></span><span class="ui-button-text">'.__('edit').'</span>', "@company-contact?hash={$company->getHash()}", 'class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"') ?>
                </div>
                <dl class="_table _noInput">
                    <dt><?php echo __('Country') ?></dt>
                    <dd><?php echo $work_address->getCountry()?sfContext::getInstance()->getI18N()->getCountry($work_address->getCountry()):"" ?></dd>
                    <dt><?php echo __('Street Adress') ?></dt>
                    <dd><?php echo $work_address->getStreet() ?></dd>
                    <dt><?php echo __('State') ?></dt>
                    <dd><?php echo $work_address->getGeonameCity() ?></dd>
                    <dt><?php echo __('Postal Code') ?></dt>
                    <dd><?php echo $work_address->getPostalCode() ?></dd>
                    <dt><?php echo __('City') ?></dt>
                    <dd><?php echo $work_address->getCity() ?></dd>
                    <dt><?php echo __('Phone Number') ?></dt>
                    <dd><?php echo $work_phone->getPhone() ?></dd>
                    <dt><?php echo __('Fax Number') ?></dt>
                    <dd><?php echo $fax_number->getPhone() ?></dd>
                </dl>
            </section>
        </div>
        
    </div>

    <div class="col_180">
        <?php if ($work_address): ?>
        <?php $address[] = $work_address->getStreet() ?>
        <?php $address[] = $work_address->getGeonameCity() ?>
        <?php $address[] = $work_address->getCity() ?>
        <?php $address[] = $work_address->getCountry() ?>
        <?php $address = urlencode(implode(',',$address)) ?>
        <?php echo image_tag("http://maps.google.com/maps/api/staticmap?zoom=13&size=180x180&maptype=roadmap&markers=color:red|$address&sensor=true") ?>
        <?php endif ?>
    </div>
    
</div>
