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
                        <span class="btn_container ui-smaller" style="position: relative;top: auto; right: auto; float: right; margin-left: 10px;">
                        <?php echo $prevnext['PREV_ID'] ? link_to('&nbsp;', "$jobroute&action=previewCV&appid=".$prevnext['PREV_ID'], array('class' => 'left-arrow', 'title' => __('Previous Applicant'))) : '' ?>
                        <?php echo $prevnext['NEXT_ID'] ? link_to('&nbsp;', "$jobroute&action=previewCV&appid=".$prevnext['NEXT_ID'], array('class' => 'right-arrow', 'title' => __('Next Applicant'))) : '' ?>
                        </span>
                        <?php echo link_to(__('Back to Applicants'), "$jobroute&action=applicants", "class=bluelink") ?>
                        </div>
                    <?php echo __('Applicant for <span class="t_green">%1</span>', array('%1' => $job->getTitle())) ?>
                    <div><span class="tag update-11px"><?php echo __('Updated at %1', array('%1' => format_datetime($resume->getCreatedAt('U'), 'f'))) ?></span>
                         <span class="tag trail-right-11px"><?php echo __('Applied at %1', array('%1' => format_datetime($app->getCreatedAt('U'), 'f'))) ?></span>
                     </div>
                </h4>
                <div class="clear">
<div id="cv-preview">
<div class="flagger _right">
<div>
<div class="items">
<?php echo link_to(__('Ignore'), "$jobroute&action=previewCV&appid={$app->getId()}&act=ignore", 'class=act a16px hand' . ($app->getFlagType() == UserJobPeer::UJ_EMPLYR_FLAG_IGNORE ? ' flagged' : '')) ?>
<?php echo link_to(__('Favourite'), "$jobroute&action=previewCV&appid={$app->getId()}&act=fav", 'class=act a16px star' . ($app->getFlagType() == UserJobPeer::UJ_EMPLYR_FLAG_FAVOURITE ? ' flagged' : '')) ?>
<?php echo link_to(__('None'), "$jobroute&action=previewCV&appid={$app->getId()}&act=unflag", 'class=act a16px' . (!$app->getFlagType() ? ' flagged' : '')) ?>
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
            <div class="_right t_orange"><?php echo $app->getStatusId() !== 0 ? __(UserJobPeer::$statusLabels[$app->getStatusId()]) : __('Pending') ?></div>
            <?php echo __('Current Status:') ?>
            <div class="clear"></div>
            <div class="stat-chg-switch _right"><?php echo link_to_function(__('change'), "$('.stat-chg-switch, .folder-chg-box').hide();$('.stat-chg-box, .folder-chg-switch').show();", 'class=bluelink') ?></div>
            <div class="stat-chg-box ghost">
                <?php echo __("Please select a new status for %1's application:", array('%1' => $app->getUser())) ?>
                <div class="hrsplit-1"></div>
                <?php echo form_tag("$jobroute&action=previewCV", 'method=GET') ?>
                <?php echo input_hidden_tag('appid', $app->getId()) ?> 
                <?php echo input_hidden_tag('act', 'chgstatus') ?> 
                <?php echo input_hidden_tag('do', 'commit') ?> 
                <?php echo select_tag('status_id', options_for_select(UserJobPeer::$statusLabels, $app->getStatusId(), array('include_custom' => __('Please Select')))) ?>
                <div class="hrsplit-1"></div>
                <div class="_right"><?php echo link_to_function(__('cancel'), "$('.stat-chg-switch').show();$('.stat-chg-box').hide();", 'class=bluelink') ?></div>
                <?php echo submit_tag(__('Save Status'), 'class=green-button smaller') ?>
                </form>
            </div>
            <div class="clear"></div>
        </div>
        <div class="hrsplit-1"></div>
        <div class="_dotted">
            <div class="_right t_orange"><?php echo $folder ? $folder : __('Not Classified') ?></div>
            <?php echo __('Store in folder:') ?>
            <div class="clear"></div>
            <div class="folder-chg-switch _right"><?php echo link_to_function(__('change'), "$('.folder-chg-switch, .stat-chg-box').hide();$('.folder-chg-box, .stat-chg-switch').show();", 'class=bluelink') ?></div>
            <div class="folder-chg-box ghost">
                <div class="hrsplit-1"></div>
                <?php echo __("Please select a folder to store %1's resume:", array('%1' => $app->getUser())) ?>
                <div class="hrsplit-1"></div>
                <?php $folders = $profile->getOrderedFolders(); ?>
                <?php if ($profile->countResumeFolders() < (($conf = sfConfig::get('app_jobs_profileconf')) && isset($conf['max_folder_count']) ? $conf['max_folder_count'] : 10)): ?>
                <?php $folders['new'] = __('New ..'); ?>
                <?php endif ?>
                <?php echo form_tag("$jobroute&action=previewCV&appid={$app->getId()}&act=classify") ?>
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
    <h5><?php echo __('Work Experience') ?></h5>
<?php if (count($works)): ?>
<?php foreach($works as $object): ?>
<?php include_partial('mycv/work-view', array('object' => $object, 'act' => 'view')) ?>
<?php endforeach ?>
<?php else: ?>
<div class="resume-block"><span class="t_grey"><?php echo __('Work history not found.') ?></span></div>
<?php endif ?>
</section>
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

<section>
    <h5><?php echo __('Preferences') ?></h5>
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