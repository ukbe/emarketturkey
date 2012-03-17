<?php use_helper('Date') ?>
<div class="column" style="width: 655px; border: solid 1px #B2B2B2; background-color: #F9F9F9;">
<div class="hrsplit-3"></div>
<div class="column prepend-6" style="border:solid 1px #F3F3F3; background-color: #FFFFFF;">
<?php if (($hrlogo=$owner->getHRProfile()->getHRLogo())): ?>
<?php echo link_to(image_tag($hrlogo->getMediumUri()), $owner->getProfileUrl()) ?>
<?php endif ?>
</div>
<div class="hrsplit-3"></div>
<div class="column" style="width: 100%; height: 17px; background-color: #CED9F7;">
<span style="margin-left: 30px; height: 17px; font: bold italic 14px 'times new roman';background-color: #F9F9F9; padding: 0px 10px;"><?php echo $job->getDisplayTitle() ? $job->getDisplayTitle() : $job->getTitle() ?> <span style="font: 12px arial;">(<?php echo __('Ref: %1', array('%1' => $job->getRefCode())) ?>)</span></span></div>
<div class="hrsplit-3"></div>
<style>.job ol { list-style-type: circle; }</style>
<div class="pad-2 job">
<h3 style="color: purple"><?php echo __('Job Description') ?></h3>
<div class="hrsplit-1"></div>
<?php echo str_replace(chr(13), '<br />', $job->getClob(JobI18nPeer::DESCRIPTION)) ?>
<div class="hrsplit-3"></div>
<?php if ($job->getRequirements()): ?>
<h3 style="color: purple"><?php echo __('Requirements') ?></h3>
<div class="hrsplit-1"></div>
<?php echo str_replace(chr(13), '<br />', $job->getClob(JobI18nPeer::REQUIREMENTS)) ?>
<div class="hrsplit-3"></div>
<?php endif ?>
<?php if ($job->getResponsibility()): ?>
<h3 style="color: purple"><?php echo __('Responsibility') ?></h3>
<div class="hrsplit-1"></div>
<?php echo str_replace(chr(13), '<br />', $job->getClob(JobI18nPeer::RESPONSIBILITY)) ?>
<div class="hrsplit-3"></div>
<?php endif ?>
<?php if (($locs  = $job->getLocations())): ?>
<p><b><?php echo __('Number Of Staff') ?></b> :&nbsp;
<?php foreach ($locs as $loc): ?>
<?php echo $loc->getCountryCode() ? format_country($loc->getCountryCode()) . ($loc->getGeonameCity() ? '/' . $loc->getGeonameCity() : '') : ($loc->getGeonameCity() ? $loc->getGeonameCity() : '') ?> (<?php echo $loc->getNoOfStaff() ?>)&nbsp;
<?php endforeach ?>
</p>
<?php else: ?>
<?php endif ?>
<p><b><?php echo __('Job posted at') ?></b> :&nbsp;<?php echo format_date($job->getUpdatedAt('U'), 'D') ?></p>
<div class="hrsplit-3"></div>
<b><?php echo $owner ?></b>
<div class="hrsplit-1"></div>
<div class="right pad-5"><?php echo (!$user || ($user && !$user->getUserJob($job->getId(), UserJobPeer::UJTYP_APPLIED)))?link_to(image_tag('layout/button/jobs/apply-job.'.$sf_user->getCulture().'.png'), '@apply-job', array('query_string' => 'id='.$job->getGuid().'&token='.base64_encode($job->getTitle().$job->getGuid().$job->getId().session_id()))):__('You have already applied for this job.') ?></div>
</div>
</div>