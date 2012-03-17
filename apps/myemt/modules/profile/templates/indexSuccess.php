<?php use_helper('Date') ?>
<div class="column span-198">
<div class="column span-38">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li class="last"><?php echo __('Profile') ?></li>
</ol>
</div>
<ol class="column command-menu">
<li><?php echo link_to(__('Edit Profile'), 'profile/edit') ?></li>
</ol>
</div>
<div class="hrsplit-2"></div>
<div class="column span-156 prepend-1 last">
<?php if ($profile): ?>
<div class="column span-41">
<?php echo link_to(image_tag($user->getProfilePictureUri(true), 'width=200'), 'media/photos') ?>
<ol class="profile-actions">
<li><?php echo link_to('My Photos', 'media/photos') ?></li>
</ol>
<div class="hrsplit-1"></div>
<div class="column left-box" style="width: 197px">
<span class="header"><?php echo __('Friends').'('.count($friends).')' ?>
<?php echo link_to(__('see all'), 'network/index?id='.$user->getId(), 'class=action') ?></span>
<div>
<ol class="column span-39">
<?php $fc = 0; ?>
<?php foreach ($friends as $friend): ?>
<?php $fc++; if ($fc>6) continue;  ?>
<?php if ($user->can(ActionPeer::ACT_VIEW_PROFILE, $friend)): ?>
<li class="<?php echo ($fc % 4 == 0)?"first ":""  ?>column span-12" style="text-align:center;"><?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?><br /><?php echo link_to($friend, $friend->getProfileUrl()) ?></li>
<?php else: ?>
<li class="<?php echo ($fc % 4 == 0)?"first ":""  ?>column span-12" style="text-align:center;"><?php echo image_tag($friend->getProfilePictureUri()) ?><br /><?php echo $friend ?></li>
<?php endif ?>
<?php endforeach ?>
</ol>
</div>
</div>
</div>
<div class="column span-104 pad-2">
<div class="column span-100">
<h2 style="margin-top: 0px;padding-top: 0px;"><?php echo $user ?></h2><em><?php echo $user->getBirthdate('d F Y') ?></em>
<hr />
<ol class="column span-100" style="margin: 0px; padding: 0px;">
<?php if (count($occupations)): ?>
<li class="first column span-28 right append-2"><b><?php echo __('Occupation') ?></b></li>
<li class="column span-70">
<?php foreach ($occupations as $occ): ?>
<?php if ($occ->getPresent()==TRUE): ?>
<b><?php echo $occ->getCompany()?link_to($occ->getCompany(), $occ->getCompany()->getProfileUrl()):$occ->getCompanyName() ?></b><br />
<?php echo $occ->getJobTitle() ?>&nbsp;
<em>(<?php echo __('since %1', array('%1' => $occ->getDateFrom('d M Y'))) ?>)</em><br />
<?php else: ?>
<em>
<b><?php echo $occ->getCompany()?link_to($occ->getCompany(), $occ->getCompany()->getProfileUrl()):$occ->getCompanyName() ?></b><br />
<?php echo $occ->getJobTitle() ?>&nbsp;
<em>(<?php echo distance_of_time_in_words($occ->getDateFrom('U'),$occ->getDateTo('U')) ?>)</em>
</em><br />
<?php endif; ?>
<?php endforeach; ?>
</li>
<?php endif ?>
<li class="first column span-28 right append-2"><b><?php echo __('Gender') ?></b></li>
<li class="column span-70"><?php echo UserProfilePeer::$Gender[$user->getGender()] ?></li>
<li class="first column span-28 right append-2"><b><?php echo __('Marital Status') ?></b></li>
<li class="column span-70"><?php echo UserProfilePeer::$MaritalStatus[$profile->getMaritalStatus()] ?></li>
<li class="first column span-28 right append-2"><b><?php echo __('Hometown') ?></b></li>
<?php $ht = array($profile->getGeonameCity()?$profile->getGeonameCity()->getName():'',
                  $profile->getHomeCountry()?format_country($profile->getHomeCountry()):'');
      $ht = implode (', ', array_filter($ht)) ?>
<li class="column span-70"><?php echo $ht?$ht:__('Not Set') ?></li>
<li class="first column span-28 right append-2"><b><?php echo __('Preferred Language') ?></b></li>
<li class="column span-70"><?php echo $profile->getPreferredLanguage()?sfContext::getInstance()->getI18N()->getNativeName($profile->getPreferredLanguage()): __('Not Preferred') ?></li>
</ol>
</div>
<div class="column span-100">
<h3><?php echo __('Contact Information') ?></h3><hr />
<ol class="column span-100" style="margin: 0px; padding: 0px;">
<?php $home_street = array_filter(
                     array($home_address->getStreet(), 
                           $home_address->getCity(),
                           $home_address->getPostalcode(),
                           $home_address->getGeonameCity(),
                           $home_address->getCountry()?format_country($home_address->getCountry()):'')) ?>
<?php if (count($home_street)): ?>
<li class="first column span-28 right append-2"><b><?php echo __('Home Address') ?></b></li>
<li class="column span-70"><?php echo implode(' ', $home_street) ?></li>
<?php endif ?>
<?php if ($home_phone->getPhone()): ?>
<li class="first column span-28 right append-2"><b><?php echo __('Home Phone') ?></b></li>
<li class="column span-70"><?php echo $home_phone->getPhone() ?></li>
<?php endif ?>
<?php $work_street = array_filter(
                     array($work_address->getStreet(), 
                           $work_address->getCity(),
                           $work_address->getPostalcode(),
                           $work_address->getGeonameCity(),
                           $work_address->getCountry()?format_country($work_address->getCountry()):'')) ?>
<?php if (count($work_street)): ?>
<li class="first column span-28 right append-2"><b><?php echo __('Work Address') ?></b></li>
<li class="column span-70"><?php echo implode(' ', $work_street) ?></li>
<?php endif ?>
<?php if ($work_phone->getPhone()): ?>
<li class="first column span-28 right append-2"><b><?php echo __('Work Phone') ?></b></li>
<li class="column span-70"><?php echo $work_phone->getPhone() ?></li>
<?php endif ?>
<li class="first column span-28 right append-2"><b><?php echo __('E-mail') ?></b></li>
<li class="column span-70"><?php echo $user->getLogin()->getEmail().($contact->getEmail()?', '.$contact->getEmail():'') ?></li>
<?php if($contact->getMsn() || $contact->getGtalk() || $contact->getYahoo()): ?>
<li class="first column span-28 right append-2"><b><?php echo __('IM') ?></b></li>
<li class="column span-70"><table cellspacing="0" cellpadding="2" style="background: #EEEEEE; margin-top: -2px; font: 10px verdana;">
<?php if ($contact->getMsn()): ?><tr><td style="padding-right: 10px;"><b>MSN</b></td><td><?php echo $contact->getMsn() ?></td></tr><?php endif ?>
<?php if ($contact->getGtalk()): ?><tr><td style="padding-right: 10px;"><b>GTalk</b></td><td><?php echo $contact->getGtalk() ?></td></tr><?php endif ?>
<?php if ($contact->getYahoo()): ?><tr><td style="padding-right: 10px;"><b>Yahoo</b></td><td><?php echo $contact->getYahoo() ?></td></tr><?php endif ?>
</table></li>
<?php endif ?>
</ol>
</div>
<div class="column span-100">
<h3><?php echo __('Works') ?></h3><hr />
</div>
</div>
<?php endif ?>
</div>