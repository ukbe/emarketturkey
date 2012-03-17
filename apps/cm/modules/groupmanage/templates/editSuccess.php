<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Edit Information') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuEdit', array('group' => $group)) ?>
<?php end_slot() ?>
<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/group/basic-info.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<ol class="column span-130">
    <li class="column span-36 first right"><b><?php echo __('Group Name') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $group->getName() ?></li>
    <li class="column span-36 first right"><b><?php echo __('Group Type') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $group->getGroupType() ?></li>
<?php if ($group->getTypeId()!=GroupTypePeer::GRTYP_ONLINE): ?>
    <li class="column span-36 first right"><b><?php echo __('Group Abbreviation') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $group->getAbbreviation() ?></li>
    <li class="column span-36 first right"><b><?php echo __('Founded In') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $group->getFoundedIn('Y') ?></li>
<?php endif ?>
    <li class="column span-36 first right"><b><?php echo __('Introduction') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo str_replace(chr(13), '<br />', $group->getIntroduction()) ?></li>
    <li class="column span-36 first right"><b><?php echo __('Member Profile') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo str_replace(chr(13), '<br />', $group->getMemberProfile()) ?></li>
    <li class="column span-36 first right"><b><?php echo __('Events Description') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo str_replace(chr(13), '<br />', $group->getEventsIntroduction()) ?></li>
    <li class="column span-36 first right"><b><?php echo __('Group Web Site') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $group->getUrl() ?></li>
</ol>
<?php echo image_tag('layout/background/group/contact-info.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<ol class="column span-130">
    <li class="column span-36 first right"><b><?php echo __('Country') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $work_address->getCountry()?sfContext::getInstance()->getI18N()->getCountry($work_address->getCountry()):"" ?></li>
    <li class="column span-36 first right"><b><?php echo __('Street Address') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $work_address->getStreet() ?></li>
    <li class="column span-36 first right"><b><?php echo __('State') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $work_address->getGeonameCity() ?></li>
    <li class="column span-36 first right"><b><?php echo __('Postal Code') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $work_address->getPostalCode() ?></li>
    <li class="column span-36 first right"><b><?php echo __('City') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $work_address->getCity() ?></li>
    <li class="column span-36 first right"><b><?php echo __('Phone Number') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $work_phone->getPhone() ?></li>
    <li class="column span-36 first right"><b><?php echo __('Fax Number') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $fax_number->getPhone() ?></li>
    <li class="column span-36 first right"><b><?php echo __('E-mail') ?></b></li>
    <li class="column span-92 prepend-2"><?php echo $contact->getEmail() ?></li>
</ol>
</fieldset>