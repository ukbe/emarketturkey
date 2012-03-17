<?php use_helper('Date', 'Number') ?>
<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>
<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            
            <section>
                <h4 style="border-bottom: none;">
                    <div class="_right">
                        <?php echo link_to(__('Back to CV Database'), "$route&action=vault&channel=$channel&cvdb_keyword=$keyword", "class=bluelink") ?>
                        </div>
                    <?php echo __('Database CV for <span class="t_green">%1</span>', array('%1' => $resume->getUser())) ?>
    <?php $chans = array() ?>
    <?php foreach ($channels as $type => $chnls): ?>
    <?php foreach ($chnls as $chnl): ?>
    <?php switch ($type){
            case DatabaseCVPeer::CHANNEL_APPLICATION:
                $chans[] = '<span class="tag trail-right-11px">' . __('Applied to %1 at %2', array('%1' => link_to($chnl->getJob(), $chnl->getJob()->getManageUrl(), 'class=bluelink'), '%2' => format_datetime($chnl->getCreatedAt('U'), 'D'))) . '</span>';
                break;
            case DatabaseCVPeer::CHANNEL_SERVICE:
                $chans[] = '<span class="tag unlock-11px">' . __('Unlocked at %1', array('%1' => format_datetime($chnl->getCreatedAt('U'), 'D'))) . '</span>';
                break;
          } ?>
    <?php endforeach ?>
    <?php endforeach ?>
                    <div><span class="tag update-11px"><?php echo __('Updated at %1', array('%1' => format_datetime($resume->getCreatedAt('U'), 'f'))) ?></span>
                         <?php echo implode('', $chans) ?>
                     </div>
                </h4>
                <div class="clear">
<div id="cv-preview">
<div class="flagger _right">
<div>
<div class="items">
<?php echo link_to(__('Favourite'), "$route&action=vaultCV&act=fav&rid={$resume->getId()}", 'class=act a16px star' . ($chnl->getFlagType() == UserJobPeer::UJ_EMPLYR_FLAG_FAVOURITE ? ' flagged' : '')) ?>
<?php echo link_to(__('None'), "$route&action=vaultCV&act=unflag&rid={$resume->getId()}", 'class=act a16px' . (!$chnl->getFlagType() ? ' flagged' : '')) ?>
</div>
<div><?php echo __('Flag:') ?></div>
</div>
</div>
<div>
<?php echo link_to(__('Print'), 'mycareer/print', 'class=act a16px print') ?>
<?php echo link_to(__('Export'), 'mycareer/print', 'class=act a16px pdf') ?>
</div>
<div class="hrsplit-2"></div>
<?php $photo = $resume->getPhoto() ?>
<table class="cvcard">
<tr>
    <td class="col1"><?php echo image_tag($resume->getPhotoUri(MediaItemPeer::LOGO_TYP_SMALL)) ?></td>
    <td class="col2"><?php echo $resume->getUser() ?>
        <table class="notepad">
        <tr><td><label><?php echo __('Birth Date') ?></label><?php echo format_date($resume->getUser()->getBirthDate('U'), 'D') ?></td></tr>
        <tr><td><label><?php echo __('Gender / Marital Status') ?></label><?php echo __(UserProfilePeer::$Gender[$resume->getUser()->getGender()]) . ($resume->getUser()->getUserProfile() ? ' / ' . __(UserProfilePeer::$MaritalStatus[$resume->getUser()->getUserProfile()->getMaritalStatus()]) : '') ?></td></tr>
        <tr><td><label><?php echo __('E-mail') ?></label><?php echo $resume->getContact() ? $resume->getContact()->getEmail() : __('Not Specified') ?></td></tr>
        <tr><td><label><?php echo __('Phone Number') ?></label><?php echo ($resume->getContact() && $resume->getContact()->getHomePhone()) ? $resume->getContact()->getHomePhone()->getPhone() :__('Not Specified') ?></td></tr>
        <tr><td><label><?php echo __('Address') ?></label>
            <?php $cityStateCnt = implode(', ', array_filter(array(($resume->getContact() && $resume->getContact()->getHomeAddress()) ? $resume->getContact()->getHomeAddress()->getCity() : null,
                              ($resume->getContact() && $resume->getContact()->getHomeAddress() ) ? $resume->getContact()->getHomeAddress()->getGeonameCity() : null,
                              ($resume->getContact() && $resume->getContact()->getHomeAddress() ) ? format_country($resume->getContact()->getHomeAddress()->getCountry()) : null))) ?>
            <?php echo implode('<br />', array_filter(array(($resume->getContact() && $resume->getContact()->getHomeAddress()) ? $resume->getContact()->getHomeAddress()->getStreet() : '', $cityStateCnt))) ?></td></tr>
        <tr><td><label><?php echo __('Employment Status') ?></label>
            <?php if ($resume->getUser()->isEmployed()): ?>
            <span class="t_green"><?php echo __('Currently Employed')."" ?>
            <?php else: ?>
            <span class="t_red"><?php echo __('Currently Unemployed') ?></span>
            <?php endif ?></td></tr>
        </table></td>
    <td class="col3">
        <div class="_dotted">
            <div class="_right t_orange"><?php echo $folder ? $folder : __('Not Classified') ?></div>
            <?php echo __('Store in folder:') ?>
            <div class="clear"></div>
            <div class="folder-chg-switch _right"><?php echo link_to_function(__('change'), "$('.folder-chg-switch, .stat-chg-box').hide();$('.folder-chg-box, .stat-chg-switch').show();", 'class=bluelink') ?></div>
            <div class="folder-chg-box ghost">
                <div class="hrsplit-1"></div>
                <?php echo __("Please select a folder to store %1's resume:", array('%1' => $resume->getUser())) ?>
                <div class="hrsplit-1"></div>
                <?php $folders = $profile->getOrderedFolders(); ?>
                <?php if ($profile->countResumeFolders() < (($conf = sfConfig::get('app_jobs_profileconf')) && isset($conf['max_folder_count']) ? $conf['max_folder_count'] : 10)): ?>
                <?php $folders['new'] = __('New ..'); ?>
                <?php endif ?>
                <?php echo form_tag("$route&action=vaultCV&act=classify&rid={$resume->getId()}") ?>
                <?php echo select_tag('folder_id', options_for_select($folders, $folder ? $folder->getId() : null, array('include_custom' => __('Please Select')))) ?>
                <?php echo input_tag('folder_name', '', 'style=width:90px; class=ghost maxlength=50') ?>
                <div class="hrsplit-1"></div>
                <div class="_right"><?php echo link_to_function(__('cancel'), "$('.folder-chg-switch').show();$('.folder-chg-box').hide();$(this).closest('form')[0].reset();", 'class=bluelink') ?></div>
                <?php echo submit_tag(__('Set Folder'), 'class=green-button smaller') ?>
                </form>
            </div>
            <div class="clear"></div>
        </div>
        </td>
    </tr>
</table>
<?php $works = $resume->getResumeWorks() ?>
<?php usort($works, 'myTools::sortResumeItems') ?>
<section>
    <h4><?php echo __('Work Experience') ?></h4>
<?php if (count($works)): ?>
<?php foreach($works as $work): ?>
<div class="resume-block">
<div class="_right t_grey">
<?php $sdate = $work->getDateFrom() ? format_date($work->getDateFrom('U'), 'D') : null; $edate = $work->getDateTo() ? format_date($work->getDateTo('U'), 'D') : null; ?>
<?php echo implode('&nbsp;-&nbsp;', array_filter(array($sdate, $work->getPresent() ? __('Current') : $edate))) ?>
</div>
<h5><strong><?php echo $work->getJobTitle() ?></strong></h5>
<?php if ($work->getListedOnEmt()==1 && $work->getCompany()): ?>
<div class="hrsplit-1"></div>
<?php include_partial('company/company', array('company' => $work->getCompany())) ?>
<?php else: ?>
<?php echo $work->getCompanyName() ?>
<?php endif ?>
<?php if ($work->getProjects()): ?>
<div class="bubble ui-corner-all margin-t2"><?php echo $work->getProjects() ?></div>
<?php endif ?>
</div>
<?php endforeach ?>
<?php else: ?>
<div class="resume-block"><span class="t_grey"><?php echo __('Work history not found.') ?></span></div>
<?php endif ?>
</section>
<div class="hrsplit-1"></div>
<?php $schools = $resume->getResumeSchools() ?>
<?php usort($schools, 'myTools::sortResumeItems') ?>
<section>
    <h4><?php echo __('Education Details') ?></h4>
<?php if (count($schools)): ?>
<?php foreach($schools as $school): ?>
<div class="resume-block">
<div class="_right t_grey">
<?php $sdate = $school->getDateFrom() ? format_date($school->getDateFrom('U'), 'D') : null; $edate = $school->getDateTo() ? format_date($school->getDateTo('U'), 'D') : null; ?>
<?php echo implode('&nbsp;-&nbsp;', array_filter(array($sdate, $school->getPresent() ? __('Current') : $edate))) ?>
</div>
<h5><strong><?php echo $school->getMajor() ?></strong></h5>
<?php echo $school->getSchool() ?><span class="bluetag margin-l1"><?php echo $school->getResumeSchoolDegree() ?></span>
<?php if ($school->getSubjects()): ?>
<div class="bubble ui-corner-all margin-t2"><?php echo $school->getSubjects() ?></div>
<?php endif ?>
</div>
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
    <h4><?php echo __('Courses & Certificates') ?></h4>
<?php foreach($courses as $course): ?>
<div class="resume-block">
<div class="_right t_grey">
<?php $sdate = $course->getDateFrom() ? format_date($course->getDateFrom('U'), 'D') : null; $edate = $course->getDateTo() && !$course->getDaily() ? format_date($course->getDateTo('U'), 'D') : null; ?>
<?php echo implode('&nbsp;-&nbsp;', array_filter(array($sdate, $course->getDaily() ? null : $edate))) ?>
</div>
<h5><strong><?php echo $course->getName() ?></strong></h5>
<?php echo $course->getInstitute() ?>
</div>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $languages = $resume->getResumeLanguages() ?>
<?php if (count($languages)): ?>
<?php $levels = ResumeLanguagePeer::$langLevels;
      $colors = array(ResumeLanguagePeer::RLANG_LEVEL_LOW       => '#FF0000',
                      ResumeLanguagePeer::RLANG_LEVEL_FAIR      => '#0000FF',
                      ResumeLanguagePeer::RLANG_LEVEL_FLUENT    => '#037F0F',
                      );
      $levels[null] = __('Not Set'); ?>
<div class="hrsplit-1"></div>
<section>
    <h4><?php echo __('Languages') ?></h4>
<?php foreach($languages as $language): ?>
<div class="resume-block">
<div class="_right t_grey">
</div>
<h5><strong><?php echo format_language($language->getLanguage()) ?></strong></h5>
<?php if ($language->getNative()): ?>
<?php echo __('Native Speaker') ?>
<?php else: ?>
<?php echo __('Reading: ') ?>
<span style="color:<?php echo $colors[$language->getLevelRead()] ?>"><?php echo __($levels[$language->getLevelRead()]) ?></span>&nbsp;&nbsp;
<?php echo __('Writing: ') ?>
<span style="color:<?php echo $colors[$language->getLevelWrite()] ?>"><?php echo __($levels[$language->getLevelWrite()]) ?></span>&nbsp;&nbsp;
<?php echo __('Speaking: ') ?>
<span style="color:<?php echo $colors[$language->getLevelSpeak()] ?>"><?php echo __($levels[$language->getLevelSpeak()]) ?></span>
<?php endif ?>
</div>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $skills = $resume->getSkillList() ?>
<?php if (count($skills)): ?>
<div class="hrsplit-1"></div>
<section>
    <h4><?php echo __('Expertise & Skills') ?></h4>
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
<?php $publications = $resume->getResumePublications() ?>
<?php if (count($publications)): ?>
<div class="hrsplit-1"></div>
<section>
    <h4><?php echo __('Publications') ?></h4>
<?php foreach($publications as $publication): ?>
<div class="resume-block">
<div class="_right t_grey">
<?php echo $publication->getBinding() ?>
</div>
<h5><strong><?php echo $publication->getSubject() ?></strong>
<?php echo ($publication->getEdition() != '') ? '<span class="bluetag">' . $publication->getEdition() . '</span>' : '' ?></h5>
<div class="hrsplit-1"></div>
<?php echo $publication->getPublisher() ?>
<?php if ($publication->getCoauthors()): ?>
<div><?php echo __('Co-Authors: ') . $publication->getCoauthors() ?></div>
<?php endif ?>
</div>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $awards = $resume->getResumeAwards() ?>
<?php if (count($awards)): ?>
<div class="hrsplit-1"></div>
<section>
    <h4><?php echo __('Awards & Honors') ?></h4>
<?php foreach($awards as $award): ?>
<div class="resume-block">
<div class="_right t_grey">
<?php echo $award->getYear() ?>
</div>
<h5><strong><?php echo $award->getTitle() ?></strong></h5>
<div class="hrsplit-1"></div>
<?php echo $award->getIssuer() ?>
<?php if ($award->getNotes()): ?>
<div class="bubble ui-corner-all margin-t2"><?php echo $award->getNotes() ?></div>
<?php endif ?>
</div>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $references = $resume->getResumeReferences() ?>
<?php if (count($references)): ?>
<div class="hrsplit-1"></div>
<section>
    <h4><?php echo __('References') ?></h4>
<?php foreach($references as $reference): ?>
<div class="resume-block">
<div class="_right t_grey">
</div>
<h5><strong><?php echo $reference->getName() ?></strong><?php echo ($reference->getJobTitle() != '') ? '<span class="bluetag margin-l2">' . $reference->getJobTitle() . '</span>' : '' ?></h5>
<div class="hrsplit-1"></div>
<?php echo $reference->getCompanyName() ?>
<div class="hrsplit-2"></div>
<?php if ($reference->getEmail()): ?><span class="email margin-r2"><?php echo $reference->getEmail() ?></span><?php endif ?>
<?php if ($reference->getPhoneNumber()): ?><span class="phone"><?php echo $reference->getPhoneNumber()->getPhone() ?></span><?php endif ?>
</div>
<?php endforeach ?>
</section>
<?php endif ?>
<?php $organisations = $resume->getResumeOrganisations() ?>
<?php if (count($organisations)): ?>
<div class="hrsplit-1"></div>
<section>
    <h4><?php echo __('Organisations') ?></h4>
<?php foreach($organisations as $organisation): ?>
<div class="resume-block">
<div class="_right t_grey">
<?php echo $organisation->getJoinedInYear() ? __('Member since %1', array('%1' => $organisation->getJoinedInYear())) : '' ?>
</div>
<h5><strong><?php echo $organisation->getName() ?></strong><?php echo $organisation->getActivityId() ? '<span class="bluetag margin-l2">' . __(ResumeOrganisationPeer::$typeAttNames[$organisation->getActivityId()]) . '</span>' : '' ?></h5>
<div class="hrsplit-1"></div>
<?php echo implode(', ', array($organisation->getCity(), $organisation->getState(), format_country($organisation->getCountryCode()))) ?>
</div>
<?php endforeach ?>
</section>
<?php endif ?>

<section>
    <h4><?php echo __('Preferences') ?></h4>
<div class="resume-block">
<dl class="_table">
<dt><?php echo __('Desired Position') ?></dt>
<dd><?php echo $resume->getJobPosition() ?></dd>
<dt><?php echo __('Position Level') ?></dt>
<dd><?php echo $resume->getJobGrade() ?></dd>
<dt><?php echo __('Objective') ?></dt>
<dd><div class="bubble ui-corner-all" style="width: 520px;"><?php echo $resume->getObjective() ?></div></dd>
<dt><?php echo __('Military Service Status') ?></dt>
<dd>
<?php if ($resume->getMilitaryServiceStatus() > 0): ?>
<?php echo __('Postponed for %1 years', array('%1' => $resume->getMilitaryServiceStatus())); ?>
<?php else: ?>
<?php switch ($resume->getMilitaryServiceStatus()): ?>
<?php case ResumePeer::RSM_MILS_PERFORMED:  echo __('Performed'); break; ?>
<?php case ResumePeer::RSM_MILS_NOTPERFORMED:  echo __('Not Performed'); break; ?>
<?php endswitch ?>
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
</div>
</section>

</div>
                </div>
            </section>
        </div>
    </div>

</div>
<?php echo javascript_tag("
$(function() {
    $('#folder_id').branch({method: 'class', map: {new: '#folder_name'}});
});
") ?>