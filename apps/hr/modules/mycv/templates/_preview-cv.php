<?php use_helper('Date', 'Number') ?>
<div id="cv-preview">
<div class="hrsplit-2"></div>
<div id="cv-intro">
<?php if (isset($include_photo) && $include_photo): ?>
<?php $photo = $resume->getPhoto() ?>
<div id="photoblock"><?php echo link_to(image_tag($photo ? $photo->getMediumUri() : 'layout/background/cv-form/photo-frame.png', 'height=89'), 'hr_cv/materials') ?></div>
<?php endif ?>
<div id="leftblock">
<span id="name"><?php echo $resume->getUser() ?></span>
<span id="birth"><?php echo __('Birthdate: %1', array('%1' => format_date($resume->getUser()->getBirthDate('U'), 'p'))) ?></span>
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
</div>
<?php $works = $resume->getResumeWorks() ?>
<?php usort($works, 'myTools::sortResumeItems') ?>
    <h5 class="clear"><?php echo __('Work Experience') ?></h5>
<?php if (count($works)): ?>
<?php foreach($works as $object): ?>
<?php include_partial('mycv/work-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
<?php else: ?>
<div class="resume-block"><span class="t_grey"><?php echo __('Work history not found.') ?></span></div>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php $schools = $resume->getResumeSchools() ?>
<?php usort($schools, 'myTools::sortResumeItems') ?>
<section>
    <h5><?php echo __('Education Details') ?></h5>
<?php if (count($schools)): ?>
<?php foreach($schools as $object): ?>
<?php include_partial('mycv/school-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
<?php else: ?>
<div class="resume-block"><span class="t_grey"><?php echo __('Education history not found.') ?></span></div>
<?php endif ?>
</section>
<?php $courses = $resume->getResumeCourses() ?>
<?php usort($courses, 'myTools::sortResumeItems') ?>
<?php if (count($courses)): ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('Courses & Certificates') ?></h5>
<?php foreach($courses as $object): ?>
<?php include_partial('mycv/course-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $languages = $resume->getResumeLanguages() ?>
<?php if (count($languages)): ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('Languages') ?></h5>
<?php foreach($languages as $object): ?>
<?php include_partial('mycv/language-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
</section>
<?php endif ?>
<?php /* ?>
<?php $skills = $resume->getSkillList() ?>
<?php if (count($skills)): ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('Expertise & Skills') ?></h5>
<div class="resume-block">
<table class="multipart">
<?php $cat_id=0 ?>
<?php foreach ($skills as $skill): ?>
<?php if ($skill->getSkillInventoryItem()->getCategoryId()!=$cat_id): ?>
<tr class="part"><td colspan="2"><?php echo $skill->getSkillInventoryItem()->getSkillCategory()->getName() ?></td></tr>
<?php $cat_id=$skill->getSkillInventoryItem()->getCategoryId() ?>
<?php endif ?>
<tr><td><?php echo $skill->getSkillInventoryItem()->getName() ?></td>
    <td><?php echo $skill->getProficiency()->getName() ?></td></tr>
<?php endforeach ?>
</table>
</div>
</section>
<?php endif ?>
 */ ?>
<?php $publications = $resume->getResumePublications() ?>
<?php if (count($publications)): ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('Publications') ?></h5>
<?php foreach($publications as $object): ?>
<?php include_partial('mycv/publication-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $awards = $resume->getResumeAwards() ?>
<?php if (count($awards)): ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('Awards & Honors') ?></h5>
<?php foreach($awards as $object): ?>
<?php include_partial('mycv/award-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $references = $resume->getResumeReferences() ?>
<?php if (count($references)): ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('References') ?></h5>
<?php foreach($references as $object): ?>
<?php include_partial('mycv/reference-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $organisations = $resume->getResumeOrganisations() ?>
<?php if (count($organisations)): ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('Organisations') ?></h5>
<?php foreach($organisations as $object): ?>
<?php include_partial('mycv/organisation-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
</section>
<?php endif ?>
<div class="hrsplit-1"></div>
<section>
    <h5><?php echo __('Preferences') ?></h5>
    <div class="cvRecordBlock">
        <div>
            <div class="actions">
                <?php echo link_to(__('Edit'), "@mycv-action?action=basic") ?>
            </div>
            <div class="leftblock">
            <dl class="_table _noInput">
                <dt><?php echo __('Desired Position') ?></dt>
                <dd><?php echo $resume->getJobPosition() ?></dd>
                <dt><?php echo __('Position Level') ?></dt>
                <dd><?php echo $resume->getJobGrade() ?></dd>
                <dt><?php echo __('Objective') ?></dt>
                <dd><div class="bubble ui-corner-all"><?php echo $resume->getObjective() ?></div></dd>
            </dl>
            <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="cvRecordBlock">
        <div>
            <div class="actions">
                <?php echo link_to(__('Edit'), "@mycv-action?action=custom") ?>
            </div>
            <div class="leftblock">
            <dl class="_table _noInput">
                <dt><?php echo __('Military Service Status') ?></dt>
                <dd>
                <?php if ($resume->getMilitaryServiceStatus() > 0): ?>
                <?php echo __('Postponed for %1 years', array('%1' => $resume->getMilitaryServiceStatus())); ?>
                <?php else: ?>
                <?php switch ($resume->getMilitaryServiceStatus()) {
                    case ResumePeer::RSM_MILS_PERFORMED:  echo __('Performed'); break; 
                    case ResumePeer::RSM_MILS_NOTPERFORMED:  echo __('Not Performed'); break;
                  } ?>
                <?php endif ?>
                </dd>
                <?php $yesno = array(1 => __('Yes'), 0 => __('No')) ?>
                <dt><?php echo __('Smokes?') ?></dt>
                <dd><?php echo $resume->getSmokes() !== null ? $yesno[$resume->getSmokes()] : __('Not Specified') ?></dd>
                <dt><?php echo __('Willing to relocate?') ?></dt>
                <dd><?php echo $resume->getWillingToRelocate() !== null ? $yesno[$resume->getWillingToRelocate()] : __('Not Specified') ?></dd>
                <dt><?php echo __('Willing to telecommute?') ?></dt>
                <dd><?php echo $resume->getWillingToTelecommute() !== null ? $yesno[$resume->getWillingToTelecommute()] : __('Not Specified') ?></dd>
                <dt><?php echo __('Travel Max Limit') ?></dt>
                <dd><?php echo $resume->getWillingToTravel() * 10 . '%' ?></dd>
                <dt><?php echo __('Driver Licenses') ?></dt>
                <dd>
                <?php $vehicles = array() ?>
                <?php foreach (ResumePeer::$licenseLabels as $key => $label): ?>
                <?php $vehicles[] = ($resume->getLicense($key) == 1 ? $label : null) ?>
                <?php endforeach ?>
                <?php $vehicles = array_filter($vehicles) ?>
                <?php if (count($vehicles)): ?>
                <?php echo implode(', ', $vehicles) ?>
                <?php else: ?>
                <?php echo __('None') ?>
                <?php endif ?>
                </dd>
                <dt><?php echo __('Desired Salary') ?></dt>
                <dd><?php echo $resume->getDesiredSalary() ? format_currency($resume->getDesiredSalary(), $resume->getSalaryCurrency()) : '' ?></dd>
            </dl>
            <div class="clear"></div>
            </div>
        </div>
    </div>
</section>

