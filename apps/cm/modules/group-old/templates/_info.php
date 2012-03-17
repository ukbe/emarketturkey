<div class="hrsplit-2"></div>
<ol class="column span-100 traditional" style="margin-left: 30px; padding: 0px;">
<li class="first column span-28 right append-2 traditional"><h3><?php echo __('General Information') ?></h3></li>
<li class="column span-70"></li>
<li class="first column span-28 right append-2"><?php echo __('Group Type') ?></li>
<li class="column span-70"><?php echo $group->getGroupType() ?></li>
<li class="first column span-28 right append-2"><?php echo __('Subject') ?></li>
<li class="column span-70"><?php echo $group->getGroupInterestArea() ?></li>
<li class="first column span-28 right append-2"><?php echo __('Introduction') ?></li>
<li class="column span-70"><?php echo $group->getIntroduction() ?></li>
<li class="first column span-28 right append-2"><?php echo __('Member Profile') ?></li>
<li class="column span-70"><?php echo $group->getMemberProfile() ?></li>
<li class="first column span-28 right append-2"><?php echo __('Events Description') ?></li>
<li class="column span-70"><?php echo $group->getEventsIntroduction() ?></li>
</ol>
<?php if($sesuser->can(ActionPeer::ACT_VIEW_CONTACT_INFO, $group)): ?>
<div class="hrsplit-2"></div>
<ol class="column span-100 traditional" style="margin-left: 30px; padding: 0px;">
<li class="first column span-28 right append-2"><h3><?php echo __('Contact Information') ?></h3></li>
<li class="column span-70"></li>
<?php $work_street = array_filter(
                     array($work_address->getStreet(), 
                           $work_address->getCity(),
                           $work_address->getPostalcode(),
                           $work_address->getGeonameCity(),
                           $work_address->getCountry()?format_country($work_address->getCountry()):'')) ?>
<?php if (count($work_street)): ?>
<li class="first column span-28 right append-2"><?php echo __('Work Address') ?></li>
<li class="column span-70"><?php echo implode(' ', $work_street) ?></li>
<?php endif ?>
<?php if ($work_phone->getPhone()): ?>
<li class="first column span-28 right append-2"><?php echo __('Work Phone') ?></li>
<li class="column span-70"><?php echo $work_phone->getPhone() ?></li>
<?php endif ?>
<li class="first column span-28 right append-2"><?php echo __('E-mail') ?></li>
<li class="column span-70"><?php echo $contact->getEmail() ?></li>
</ol>
<?php endif ?>