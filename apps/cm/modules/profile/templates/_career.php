<?php use_helper('Date') ?>
<div class="hrsplit-2"></div>
<ol class="column span-100 traditional" style="margin: 0px; padding: 0px;">
<?php if (!count($occupations) && !count($educations)): ?>
<li><h3><?php echo __('No Career information available.') ?></h3></li>
<?php endif ?>
<?php if (count($occupations)): ?>
<li class="first column span-13 right append-2">
<?php echo image_tag('layout/icon/cv/bars.png', 'width=40') ?>
</li>
<li class="column span-85">
<ol class="column span-85">
<li class="column span-85"><h2><?php echo __('Employments') ?></h2></li>
<?php foreach ($occupations as $occ): ?>
<li class="column span-85">
<span class="hangright">
<?php if ($occ->getPresent()==TRUE): ?>
<?php echo __('since %1', array('%1' => $occ->getDateFrom('d M Y'))) ?>
<?php else: ?>
<?php echo $occ->getDateFrom('d M Y') . ' - ' . $occ->getDateTo('d M Y') ?>
<?php endif; ?>
</span>
<b><?php echo $occ->getJobTitle() ?></b><br />
<?php echo $occ->getCompany()?link_to($occ->getCompany(), $occ->getCompany()->getProfileUrl()):$occ->getCompanyName() ?>
</li>
<?php endforeach; ?>
</ol>
</li>
<?php endif ?>
<?php if (count($educations)): ?>
<li class="first column span-13 right append-2">
<?php echo image_tag('layout/icon/cv/education.gif') ?>
</li>
<li class="column span-85">
<ol class="column span-85">
<li class="column span-85"><h2><?php echo __('Education Status') ?></h2></li>
<?php foreach ($educations as $edu): ?>
<li class="column span-85">
<span class="hangright">
<?php if ($edu->getPresent()==TRUE): ?>
<?php echo __('since %1', array('%1' => $edu->getDateFrom('d M Y'))) ?>
<?php else: ?>
<?php echo $edu->getDateFrom('d M Y') . ' - ' . $edu->getDateTo('d M Y') ?>
<?php endif; ?>
</span>
<b><?php echo $edu->getMajor() ?></b><br />
<?php echo $edu->getSchool() ?> - <?php echo $edu->getResumeSchoolDegree() ?>
</li>
<?php endforeach; ?>
</ol>
</li>
<div class="hrsplit-1"></div>
<?php endif ?>
</ol>
<?php if ($sesuser->getId() == $user->getId()): ?>
<div class="hrsplit-1"></div>
<p><?php echo __('You may edit your career information by %1.', array('%1' => link_to(__('clicking here'), '@hr.hr-cv'))) ?></p>
<?php endif ?>