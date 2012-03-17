<?php slot('subNav') ?>
<?php include_partial('group/subNav', array('group' => $group)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('groupProfile/editProfile', array('group' => $group)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section>
                <h4><?php echo __('Basic Information') ?></h4>
                <span class="btn_container">
                    <?php echo link_to('&nbsp;', "@group-basic?hash={$group->getHash()}", 'class="ui-icon ui-icon-pencil btn_function"') ?>
                </span>
                <dl class="_table">
                    <dt><?php echo __('Group Name') ?></dt>
                    <dd><?php echo $group->getName() ?></dd>
                    <dt><?php echo __('Group Type') ?></dt>
                    <dd><?php echo $group->getGroupType() ?></dd>
                <?php if ($group->getTypeId()!=GroupTypePeer::GRTYP_ONLINE): ?>
                    <dt><?php echo __('Founded In') ?></dt>
                    <dd><?php echo $group->getFoundedIn('Y') ?></dd>
                <?php endif ?>
                    <dt><?php echo __('Group Web Site') ?></dt>
                    <dd><?php echo $group->getUrl() ?></dd>
                </dl>
                <?php foreach ($i18ns as $key => $lang): ?>
                <h3><?php echo format_language($lang) ?></h3>
                <dl class="_table ln-part">
                    <dt><?php echo __('Display Name') ?></dt>
                    <dd><?php echo $group->getName($lang) ?></dd>
                <?php if ($group->getTypeId()!=GroupTypePeer::GRTYP_ONLINE): ?>
                    <dt><?php echo __('Abbreviation') ?></dt>
                    <dd><?php echo $group->getAbbreviation() ?></dd>
                <?php endif ?>
                    <dt><?php echo __('Introduction') ?></dt>
                    <dd><?php echo str_replace(chr(13), '<br />', $group->getIntroduction($lang)) ?></dd>
                    <dt><?php echo __('Member Profile') ?></dt>
                    <dd><?php echo str_replace(chr(13), '<br />', $group->getMemberProfile($lang)) ?></dd>
                    <dt><?php echo __('Events Description') ?></dt>
                    <dd><?php echo str_replace(chr(13), '<br />', $group->getEventsIntroduction($lang)) ?></dd>
                </dl>
                <div class="clear"></div>
                <?php endforeach ?>
                <?php if (count($i18ns) < count(sfConfig::get('app_i18n_cultures'))): ?>
                <div class="pad-2">
                <?php echo link_to(__('Add Translation'), "@group-basic?hash={$group->getHash()}#addtrans", 'class=led add-11px') ?>
                </div>
                <?php endif ?>
            </section>

            <section>
                <h4><?php echo __('Contact Information') ?></h4>
                <span class="btn_container">
                    <?php echo link_to('&nbsp;', "@group-contact?hash={$group->getHash()}", 'class="ui-icon ui-icon-pencil btn_function"') ?>
                </span>
                <dl class="_table">
                    <dt><?php echo __('Country') ?></dt>
                    <dd><?php echo $work_address->getCountry()?sfContext::getInstance()->getI18N()->getCountry($work_address->getCountry()):"" ?></dd>
                    <dt><?php echo __('Street Address') ?></dt>
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
                    <dt><?php echo __('E-mail') ?></dt>
                    <dd><?php echo $contact->getEmail() ?></dd>
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
