<?php use_helper('Date') ?>
<div class="col_948">

    <div class="breadcrumb">
        <ul>
            <li><?php echo link_to(__('Jobs'), '@homepage') ?></li>
            <li><span><?php echo $job ?></span></li>
        </ul>
    </div>

    <div class="col_180">
    <?php if ($owner->getLogo()): ?>
        <div class="box_180 txtCenter">
            <?php echo link_to(image_tag($owner->getLogo()->getMediumUri()), $ownerroute) ?>
        </div>
    <?php endif ?>
        <div class="box_180 txtCenter">
            <div class="_noBorder two_columns">
                <div class="_center">
                    <span class="t_smaller t_grey"><?php echo __('Published') ?></span>
                    <div class="clndr-leaf" style="margin: 4px 5px;">
                        <div><?php echo strtoupper(format_date($job->getPublishedOn('U'), 'MMM')) ?></div>
                        <?php echo $job->getPublishedOn('d') ?>
                    </div>
                    <?php echo $job->getPublishedOn('Y') != $job->getDeadline('Y') ? '<span class="t_grey">'.$job->getPublishedOn('Y').'</span>' : '' ?>
                </div>
                <div class="_center">
                    <span class="t_smaller t_grey"><?php echo __('Deadline') ?></span>
                    <div class="clndr-leaf" style="margin: 4px 5px;">
                        <div><?php echo strtoupper(format_date($job->getDeadline('U'), 'MMM')) ?></div>
                        <?php echo $job->getDeadline('d') ?>
                    </div>
                    <?php echo $job->getPublishedOn('Y') != $job->getDeadline('Y') ? '<span class="t_grey">'.$job->getDeadline('Y').'</span>' : '' ?>
                </div>
            </div>
        </div>
        <div class="hrsplit-2"></div>
        <div class="box_180 txtCenter">
            <div class="_noBorder">
                <?php echo like_button($job) ?>
            </div>
        </div>

        <div class="box_180 noBorder">
            <ul class="_comMenu">
                <li class="_save<?php echo $saved = $sesuser->getUserJob($job->getId(), UserJobPeer::UJTYP_FAVOURITE) ? ' click' : '' ?>"><?php echo link_to('<span></span>'.($saved ? __('Remove Bookmark') : __('Bookmark')), $job->getUrl()."&act=".($saved ? 'rem' : 'save')) ?></li>
            </ul>
        </div>
    </div>
            
    <div class="col_576 b2bProduct">

        <h3 class="pname"><?php if ($job->getRefCode()): ?>
                                <div class="_right t_grey t_smaller"><?php echo __('REF: %1', array('%1' => $job->getRefCode()))?></div>
                          <?php endif ?>
                          <?php echo $job ?></h3>
        <div class="box_576">
            <div class="_noBorder pad-0">
            <?php if ($desc = ($desc = $job->getClob(JobI18nPeer::DESCRIPTION)) ? $desc : $job->getClob(JobI18nPeer::DESCRIPTION, $job->getDefaultLang())): ?>
                <div class="pad-2">
                    <?php echo $desc ?>
                </div>
            <?php endif ?>

            <?php if ($req = ($req = $job->getClob(JobI18nPeer::REQUIREMENTS)) ? $req : $job->getClob(JobI18nPeer::REQUIREMENTS, $job->getDefaultLang())): ?>
                <h4><?php echo __('Requirements') ?></h4>
                <div class="pad-2">
                    <ul class="arrow-list">
                    <?php foreach (array_filter(explode("\n", $req)) as $line): ?>
                        <li><?php echo $line ?></li>
                    <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <?php if ($res = ($res = $job->getClob(JobI18nPeer::RESPONSIBILITY)) ? $res : $job->getClob(JobI18nPeer::RESPONSIBILITY, $job->getDefaultLang())): ?>
                <h4><?php echo __('Responsibilities') ?></h4>
                <div class="pad-2">
                    <ul class="arrow-list">
                    <?php foreach (array_filter(explode("\n", $res)) as $line): ?>
                        <li><?php echo $line ?></li>
                    <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

                <h4><?php echo __('Job Specificatons') ?></h4>
                <div>
                    <dl class="_table _noInput">
                    <?php if ($spec = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_JOB_FUNCTION)): ?>
                        <dt><?php echo __('Job Function') ?></dt>
                        <dd><?php echo $spec ?></dd>
                    <?php endif ?>
                    <?php if ($spec = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_JOB_GRADE)): ?>
                        <dt><?php echo __('Job Position Level') ?></dt>
                        <dd><?php echo $spec ?></dd>
                    <?php endif ?>
                    <?php if ($spec = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_WORKING_SCHEME)): ?>
                        <dt><?php echo __('Attandence') ?></dt>
                        <dd><?php echo $spec ?></dd>
                    <?php endif ?>
                    <?php if ($spec = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_EXPERIENCE_YEAR)): ?>
                        <dt><?php echo __('Experience') ?></dt>
                        <dd><?php echo __(JobSpecPeer::$experienceLabels[$spec], array('%1' => $spec)) ?></dd>
                    <?php endif ?>
                    <?php if ($specs = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_SCHOOL_DEGREE)): ?>
                        <dt><?php echo __('Education Level') ?></dt>
                        <dd><?php foreach ($specs as $spec): ?>
                            <?php echo $spec ?>
                            <?php endforeach ?></dd>
                    <?php endif ?>
                    <?php if ($spec = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_GENDER)): ?>
                        <dt><?php echo __('Gender') ?></dt>
                        <dd><?php $gen = array(0 => __("Doesn't matter"), 1 => __('Male'), 2 => __('Female')); echo $gen[$spec] ?></dd>
                    <?php endif ?>
                    <?php if ($specs = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_SPECIAL_CASE)): ?>
                        <dt><?php echo __('Special Cases') ?></dt>
                        <dd><?php echo implode(', ', $specs) ?></dd>
                    <?php endif ?>
                    <?php if ($spec = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_SMOKING_STATUS)): ?>
                        <dt><?php echo __('Smoker/Non-Smoker') ?></dt>
                        <dd><?php $gen = array(1 => __("Doesn't matter"), 2 => __('Smoker'), 3 => __('Non-Smoker')); echo $gen[$spec] ?></dd>
                    <?php endif ?>
                    <?php if ($specs = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_DRIVERS_LICENSE)): ?>
                        <dt><?php echo __("Driver's License Requirement") ?></dt>
                        <dd><?php foreach ($specs as $spec): ?>
                            <?php echo ResumePeer::$licenseLabels[$spec] ?>
                            <?php endforeach ?></dd>
                    <?php endif ?>
                    <?php if ($spec = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_TRAVEL_PERCENT)): ?>
                        <dt><?php echo __('Travel Percent') ?></dt>
                        <dd><?php echo "$spec%" ?></dd>
                    <?php endif ?>
                    <?php $s_currency = $job->getSallaryCurrency();
                          $s_start = $job->getSallaryStart();
                          $s_end = $job->getSallaryEnd();
                          $s_type = $job->getSallaryType(); ?>
                    <?php if ($s_currency && (($s_type == 1 && $s_start) || ($s_type == 2 && $s_start && $s_end))): ?>
                        <dt><?php echo __('Net Sallary') ?></dt>
                        <dd><?php echo $s_type = 1 ? "$s_start $s_currency" : "$s_start $s_currency .. $s_end $s_currency" ?></dd>
                    <?php endif ?>
                    <?php $m_status = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_MILSERV_STATUS);
                          $m_postyear = $job->getObjectOrValueOfSpecType(JobSpecPeer::JSPTYP_MILSERV_POSTYEAR); ?>
                    <?php if ($m_status == JobSpecPeer::JSP_MILSERV_PERFORMED || $m_status == JobSpecPeer::JSP_MILSERV_DOESNTMATTER || ($m_status == JobSpecPeer::JSP_MILSERV_POSTPONED && $m_postyear)): ?>
                        <dt><?php echo __('Military Service') ?></dt>
                        <dd><?php echo ($m_status == JobSpecPeer::JSP_MILSERV_POSTPONED) ? __("Postponed for %1 years", array('%1' => $m_postyear)) : __(JobSpecPeer::$milServLabels[$m_status]) ?></dd>
                    <?php endif ?>
                        <dt><?php echo __('Locations and Number of Personel') ?></dt>
                        <dd><?php echo $job->getLocationString() ?></dd>
                    </dl>
                </div>
                <div class="hrsplit-3"></div>
                <div class="txtCenter">
                    <?php if ($sesuser->canApplyToJob($job)): ?>
                    <?php echo link_to(__('Apply for Job'), "$jobroute&act=apply", 'class=green-button') ?>
                    <?php else: ?>
                    <div class="bubble ui-corner-all pad-2">
                    <span class="t_red"><?php echo __('You have already applied for this job.')?></span>
                    <div class="hrsplit-1"></div>
                    <?php echo link_to(__('Click here to view or edit your application status.'), "@myjobs-applied-view?guid={$job->getGuid()}", 'class=bluelink inherit-font hover') ?>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="hrsplit-3"></div>
        <div class="box_576">
            <?php echo link_to(__('More job posts from %1emplyr', array('%1emplyr' => $owner)), $ownerroute, 'class=inherit-font bluelink hover') ?>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('Employer Details') ?></h3>
            <div class="t_smaller">
                <div class="txtCenter"><?php echo $owner->getLogo() ? link_to(image_tag($owner->getLogo()->getThumbnailUri()), $owner->getProfileUrl()) : '' ?></div>
                <h4 class="txtCenter"><?php echo $owner ?></h4>
            <?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
                <strong><?php echo __('Industry') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getBusinessSector() ?></div>
                <strong><?php echo __('Business Type') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getBusinessType() ?></div>
            <?php else: ?>
                <strong><?php echo __('Group Type') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getGroupType() ?></div>
            <?php endif ?>
                <strong><?php echo __('Location') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getLocationLabel() ?></div>
                <p><?php echo link_to(__('Go to Employer Profile'), $owner->getProfileUrl(), 'class=bluelink hover')?></p>
                <p><?php echo link_to(__('Contact Employer'), $owner->getProfileActionUrl('contact'), array('query_string' => "rel={$job->getPlug()}", 'class' => 'contactlink'))?></p>
            </div>
        </div>
        
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('How are you connected?') ?></h3>
            <div>
                <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $owner)) ?>
            </div>
        </div>
    </div>
</div>
<?php if ($act): ?>
<div id="action-success" class="ghost">
<div class="dynaboxMsg check"><?php echo __($messages[$act]) ?></div>
</div>
<a id="hidden-trigger" class="ghost"></a>
<?php echo javascript_tag("
$(function(){
    $('#hidden-trigger').dynabox({clickerMethod: 'click', loadMethod: 'static', loadType: 'html', sourceElement: '#action-success', fillType: 'copy', position: 'window', autoUpdate: false, showHeader: false, showFooter: false}).bind('dynaboxopened', function(){ setTimeout(function(){ $.ui.dynabox.openBox.close(); }, 1800)});
    $('#hidden-trigger').data('dynabox').open();
});
") ?>
<?php endif ?>
