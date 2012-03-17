<?php use_helper('Date') ?>
<div id="cv-preview">
<div id="actionbar">
<span id="print">
<?php echo link_to(image_tag('layout/button/cv/print.'.$sf_user->getCulture().'.png'), 'mycareer/print') ?>
</span>
<span id="exportpdf">
<?php echo link_to(image_tag('layout/button/cv/export-as-pdf.'.$sf_user->getCulture().'.png'), 'mycareer/export') ?>
</span>
<span id="updatedat">
<?php echo __('Updated at %1', array('%1' => format_datetime($resume->getUpdatedAt('U')))) ?>
</span>
</div>
<div class="hrsplit-2"></div>
<div id="cv-intro">
<?php $photo = $resume->getPhoto() ?>
<div id="photoblock"><?php echo link_to(image_tag($photo ? $photo->getMediumUri() : 'layout/background/cv-form/photo-frame.png', 'height=89'), 'hr_cv/materials') ?></div>
<div id="leftblock">
<span id="name"><?php echo $resume->getUser() ?></span>
<span id="birth"><?php echo __('Birth: %1', array('%1' => $resume->getUser()->getBirthDate('d F Y'))) ?></span>
<span id="gender"><?php echo __(UserProfilePeer::$Gender[$resume->getUser()->getGender()]) . ($resume->getUser()->getUserProfile() ? ' / ' . __(UserProfilePeer::$MaritalStatus[$resume->getUser()->getUserProfile()->getMaritalStatus()]) : '') ?></span>
<span id="employment"><?php echo $resume->getUser()->isEmployed()?__('Currently Employed') : __('Currently Unemployed') ?></span>
</div>
<div id="rightblock">
<div id="phone"><?php echo ($resume->getContact() && $resume->getContact()->getHomePhone()) ? $resume->getContact()->getHomePhone()->getPhone() :__('Not Specified') ?></div>
<div id="email"><?php echo $resume->getContact() ? $resume->getContact()->getEmail() : __('Not Specified') ?></div>
<div id="street"><?php echo ($resume->getContact() && $resume->getContact()->getHomeAddress()) ? $resume->getContact()->getHomeAddress()->getStreet() : __('Not Specified') ?><br />
<?php echo implode(', ', array_filter(array(($resume->getContact() && $resume->getContact()->getHomeAddress() ) ? $resume->getContact()->getHomeAddress()->getCity() : '',
                              ($resume->getContact() && $resume->getContact()->getHomeAddress() ) ? $resume->getContact()->getHomeAddress()->getGeonameCity() : '',
                              ($resume->getContact() && $resume->getContact()->getHomeAddress() ) ? format_country($resume->getContact()->getHomeAddress()->getCountry()) : ''))) ?></div>
</div>
</div>
<?php echo image_tag('layout/background/cv-form/desired-position.'.$sf_user->getCulture().'.png') ?>
<div id="objective">
<span id="position"><?php echo $resume->getJobPosition() ?></span>
<span id="level">[<?php echo $resume->getJobGrade() ?>]</span>
<div id="objectivepack"><span id="objtag"><?php echo __('Objective :') ?></span>
<div id="objectivebox"><span id="openquote">"</span><?php echo $resume->getObjective() ?><span id="closequote">"</span>
</div>
</div>
</div>
<div class="hrsplit-3"></div>
<?php echo image_tag('layout/background/cv-form/education-status.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $schools = $resume->getResumeSchools() ?>
<?php foreach($schools as $school): ?>
<?php include_partial('hr_cv/ajax_school_display', array('school' => $school, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>
<?php echo image_tag('layout/background/cv-form/work-experience.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $works = $resume->getResumeWorks() ?>
<?php foreach($works as $work): ?>
<?php include_partial('hr_cv/ajax_work_display', array('work' => $work, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>
<?php echo image_tag('layout/background/cv-form/courses.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $courses = $resume->getResumeCourses() ?>
<?php foreach($courses as $course): ?>
<?php include_partial('hr_cv/ajax_course_display', array('course' => $course, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>
<?php echo image_tag('layout/background/cv-form/languages.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $languages = $resume->getResumeLanguages() ?>
<?php foreach($languages as $language): ?>
<?php include_partial('hr_cv/ajax_language_display', array('language' => $language, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>
<?php echo image_tag('layout/background/cv-form/skills.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $skills = $resume->getResumeSkills() ?>
<?php if (count($skills)): ?>
<table cellpadding="5" cellspacing="0" width="100%">
<?php $cat_id=0 ?>
<?php foreach ($skills as $skill): ?>
<?php if ($skill->getSkillInventoryItem()->getCategoryId()!=$cat_id): ?>
<tr><td colspan="3" style="border-bottom: solid 1px #888888;padding-top: 15px;">
<b><?php echo $skill->getSkillInventoryItem()->getSkillCategory()->getName() ?></b></td></tr>
<?php $cat_id=$skill->getSkillInventoryItem()->getCategoryId() ?>
<?php endif ?>
<tr><td style="border-bottom: solid 1px #CCCCCC;"><?php echo $skill->getSkillInventoryItem()->getName() ?></td>
<td style="border-bottom: solid 1px #CCCCCC;">
<span id="rlink_<?php echo $skill->getSkillInventoryItem()->getId() ?>">
<?php echo emt_remote_link(image_tag('layout/icon/inactive-n.png', array('width' => '15', 'title' => __('remove'))),'rlink_'.$skill->getSkillInventoryItem()->getId(), 'hr_cv/ajaxSetSkill', array('sid' => $skill->getSkillInventoryItem()->getId(), 'do' => 'rem')) ?>
</span>
<span id="rlink_<?php echo $skill->getSkillInventoryItem()->getId() ?>error"></span>
</td>
<td style="border-bottom: solid 1px #CCCCCC;"><?php echo $skill->getProficiency()->getName() ?></td></tr>
<?php endforeach ?>
</table>
<?php else: ?>
<?php echo __('Currently, you have not selected any skills.') ?>
<?php endif ?>
</div>

<?php echo image_tag('layout/background/cv-form/publications.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $publications = $resume->getResumePublications() ?>
<?php foreach($publications as $publication): ?>
<?php include_partial('hr_cv/ajax_publication_display', array('publication' => $publication, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>
<?php echo image_tag('layout/background/cv-form/awards.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $awards = $resume->getResumeAwards() ?>
<?php foreach($awards as $award): ?>
<?php include_partial('hr_cv/ajax_award_display', array('award' => $award, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>
<?php echo image_tag('layout/background/cv-form/references.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $references = $resume->getResumeReferences() ?>
<?php foreach($references as $reference): ?>
<?php include_partial('hr_cv/ajax_reference_display', array('reference' => $reference, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>
<?php echo image_tag('layout/background/cv-form/organisations.'.$sf_user->getCulture().'.png') ?>
<div class="includerbox">
<?php $organisations = $resume->getResumeOrganisations() ?>
<?php foreach($organisations as $organisation): ?>
<?php include_partial('hr_cv/ajax_organisation_display', array('organisation' => $organisation, 'resume' => $resume, 'state' => EmtAjaxAction::DB_REVIEW)) ?>
<?php endforeach ?>
</div>


</div>