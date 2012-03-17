<div class="hrsplit-2"></div>
<?php if ($viewinfo): ?>
<ol class="column span-100 traditional" style="margin-left: 30px; padding: 0px;">
<li class="first column span-28 right append-2 traditional"><h3><?php echo __('General Information') ?></h3></li>
<li class="column span-70"></li>
<li class="first column span-28 right append-2"><?php echo __('Gender') ?></li>
<li class="column span-70"><?php echo UserProfilePeer::$Gender[$user->getGender()] ?></li>
<li class="first column span-28 right append-2"><?php echo __('Marital Status') ?></li>
<li class="column span-70">
    <?php if ($sps = $user->getSpouse()): ?>
    <?php echo __('Married to %1u', array('%1u' => link_to($sps, $sps->getProfileUrl()))) ?>
    <?php else: ?>
    <?php echo UserProfilePeer::$MaritalStatus[$profile->getMaritalStatus()] ?>    
    <?php endif ?>
</li>
<li class="first column span-28 right append-2"><?php echo __('Hometown') ?></li>
<?php $ht = array($profile->getGeonameCity()?$profile->getGeonameCity()->getName():'',
                  $profile->getHomeCountry()?format_country($profile->getHomeCountry()):'');
      $ht = implode (', ', array_filter($ht)) ?>
<li class="column span-70"><?php echo $ht?$ht:__('Not Set') ?></li>
<li class="first column span-28 right append-2"><?php echo __('Preferred Language') ?></li>
<li class="column span-70"><?php echo $profile->getPreferredLanguage()?sfContext::getInstance()->getI18N()->getNativeName($profile->getPreferredLanguage()): __('Not Preferred') ?></li>
</ol>
<?php endif ?>
<?php if($sesuser->can(ActionPeer::ACT_VIEW_CONTACT_INFO, $user)): ?>
<div class="hrsplit-2"></div>
<ol class="column span-100 traditional" style="margin-left: 30px; padding: 0px;">
<li class="first column span-28 right append-2 traditional"><h3><?php echo __('Contact Information') ?></h3></li>
<li class="column span-70"></li>
<?php $home_street = array_filter(
                     array($home_address->getStreet(), 
                           $home_address->getCity(),
                           $home_address->getPostalcode(),
                           $home_address->getGeonameCity(),
                           $home_address->getCountry()?format_country($home_address->getCountry()):'')) ?>
<?php if (count($home_street)): ?>
<li class="first column span-28 right append-2"><?php echo __('Home Address') ?></li>
<li class="column span-70"><?php echo implode(' ', $home_street) ?></li>
<?php endif ?>
<?php if ($home_phone->getPhone()): ?>
<li class="first column span-28 right append-2"><?php echo __('Home Phone') ?></li>
<li class="column span-70"><?php echo $home_phone->getPhone() ?></li>
<?php endif ?>
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
<li class="column span-70"><?php echo $user->getLogin()->getEmail().($contact->getEmail()?', '.$contact->getEmail():'') ?></li>
<?php if($contact->getMsn() || $contact->getGtalk() || $contact->getYahoo()): ?>
<li class="first column span-28 right append-2"><?php echo __('IM') ?></li>
<li class="column span-70"><table cellspacing="0" cellpadding="2" style="background: #EEEEEE; margin-top: -2px; font: 10px verdana;">
<?php if ($contact->getMsn()): ?><tr><td style="padding-right: 10px;">MSN</td><td><?php echo $contact->getMsn() ?></td></tr><?php endif ?>
<?php if ($contact->getGtalk()): ?><tr><td style="padding-right: 10px;">GTalk</td><td><?php echo $contact->getGtalk() ?></td></tr><?php endif ?>
<?php if ($contact->getYahoo()): ?><tr><td style="padding-right: 10px;">Yahoo</td><td><?php echo $contact->getYahoo() ?></td></tr><?php endif ?>
</table></li>
<?php endif ?>
</ol>
<?php endif ?>