<?php use_helper('DateForm', 'Object') ?>
<?php slot('pagetop') ?>
<?php include_partial('company/company_pagetop', array('company' => $company)) ?> 
<?php end_slot() ?>
<?php slot('pageheader', __('Company Profile')) ?>
<?php slot('leftcolumn') ?>
<?php include_partial('company/leftmenu', array('company' => $company)) ?>
<?php end_slot() ?>
<div class="hrsplit-2"></div>
<div class="blockfield">
    <div class="header"><?php echo __('Corporate Information :') ?>
        <span class="action"><?php echo link_to(__('Edit'), "@company-corporate?hash={$company->getHash()}", 'class=edit-13px') ?></span>
    </div>
    <div class="section">
        <dl>
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
        <div class="center-block"></div>
    </div>
</div>
<div class="blockfield">
    <div class="header"><?php echo __('Contact Information :') ?>
        <span class="action"><?php echo link_to(__('Edit'), "@company-contact?hash={$company->getHash()}", 'class=edit-13px') ?></span>
    </div>
    <div class="section">
        <dl>
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
        <div class="center-block"></div>
    </div>
</div>