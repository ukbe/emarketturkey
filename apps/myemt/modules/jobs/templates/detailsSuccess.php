<?php use_helper('Date', 'DateForm') ?>
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

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section id="boxContent">
                <h4 style="border-bottom: none;"><?php echo __('Job Post: <span class="t_green">%1</span>', array('%1' => $job->getTitle())) ?></h4>
                <ul class="tabmenu clear">
                    <li><?php echo link_to(__('Job Preview'), "$jobroute&action=details", "class=selected") ?></li>
                    <li><?php echo link_to(__('Applicants'), "$jobroute&action=applicants") ?></li>
                    <li><?php echo link_to_function(__('Statistics'), "", 'class=t_grey') ?></li>
                </ul>
                <div class="hrsplit-1"></div>

                <?php foreach ($i18ns as $key => $lang): ?>
                <h3<?php echo $cks = ($sf_user->getCulture() == $lang || (!in_array($sf_user->getCulture(), $i18ns) && $lang == $job->getDefaultLang()) ? ' class="current"' : '') ?>><?php echo format_language($lang) ?></h3>
                <dl class="_table ln-part">
                    <dt></dt>
                    <dd class="right"><div class="ghost"><?php echo link_to(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), "$jobroute&action=details&act=remi18n&ln=$lang") ?></div></dd>
                    <dt><?php echo __('Job Title') ?></dt>
                    <dd><?php echo $job->getDisplayTitle($lang) ?></dd>
                    <dt><?php echo __('Description') ?></dt>
                    <dd><?php echo $job->getClob(JobI18nPeer::DESCRIPTION, $lang) ?></dd>
                    <dt><?php echo __('Responsibilities') ?></dt>
                    <dd><?php echo $job->getClob(JobI18nPeer::RESPONSIBILITY, $lang) ?></dd>
                    <dt><?php echo __('Requirements') ?></dt>
                    <dd><?php echo $job->getClob(JobI18nPeer::REQUIREMENTS, $lang) ?></dd>
                </dl>
                <div class="clear"></div>
                <?php endforeach ?>
                <dl class="_table">
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

            </section>
        </div>
    </div>
    <div class="col_180">
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('Job Status') ?></h3>
            <div>
                <ul class="signlist clear">
                <?php
                    $cls = array(
                        JobPeer::JSTYP_ONLINE   => 't_green',
                        JobPeer::JSTYP_OFFLINE  => 't_red',
                        JobPeer::JSTYP_SUSPENDED=> 't_orange',
                        JobPeer::JSTYP_OBSOLETE => 't_grey',
                        )
                 ?>
                <li><span class="t_bold <?php echo $cls[$job->getStatus()] ?>"><?php echo JobPeer::$typeNames[$job->getStatus()] ?></span></li>
                <li><?php if ($job->getStatus() == JobPeer::JSTYP_ONLINE): ?>
                    <?php echo link_to(__('Suspend'), "$jobroute&action=details&act=suspend", array('class' => 'command pause frmhelp', 'title' => __('Suspend Job Listing'))) ?>
                    <?php echo link_to(__('Finalize'), "$jobroute&action=details&act=stop", array('class' => 'command stop frmhelp', 'title' => __('Finalize Job Listing'))) ?>
                    <?php elseif ($job->getStatus() == JobPeer::JSTYP_OFFLINE): ?>
                    <?php echo link_to(__('Publish'), "$jobroute&action=details&act=publish", array('class' => 'command play frmhelp', 'title' => __('Publish Job Listing'))) ?>
                    <?php elseif ($job->getStatus() == JobPeer::JSTYP_SUSPENDED): ?>
                    <?php echo link_to(__('Resume'), "$jobroute&action=details&act=publish", array('class' => 'command play frmhelp', 'title' => __('Resume Job Listing'))) ?>
                    <?php echo link_to(__('Finalize'), "$jobroute&action=details&act=stop", array('class' => 'command stop frmhelp', 'title' => __('Finalize Job Listing'))) ?>
                    <?php elseif ($job->getStatus() == JobPeer::JSTYP_OBSOLETE): ?>
                    <?php endif ?>
                    </li>
                <li class="t_smaller"><?php echo format_number_choice(__('[0]End of Online Period.|[1]One day left.|(1,+Inf]%1 days left to deadline.'), array('%1' => $job->getDaysLeftToDeadline()), $job->getDaysLeftToDeadline()) ?></li>
                <li class="clear">
                    <div class="two_columns">
                    <div class="_center">
                        <span class="t_smaller t_grey"><?php echo __('Published') ?></span>
                        <div class="clndr-leaf" style="margin: 4px 5px;">
                            <div><?php echo strtoupper(format_date($job->getPublishedOn('U'), 'MMM')) ?></div>
                            <?php echo $job->getPublishedOn('d') ?>
                        </div>
                    </div>
                    <div class="_center">
                        <span class="t_smaller t_grey"><?php echo __('Deadline') ?></span>
                        <div class="clndr-leaf" style="margin: 4px 5px;">
                            <div><?php echo strtoupper(format_date($job->getDeadline('U'), 'MMM')) ?></div>
                            <?php echo $job->getDeadline('d') ?>
                        </div>
                    </div>
                    </div>
                    <div class="clear"></div>
                </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php echo javascript_tag("

$(function() {
    
    $('#flowpanes').scrollable({ circular: true, mousewheel: false }).navigator({
        navi: '#flowtabs',
        naviItem: 'a',
        activeClass: 'current',
        history: true
    });
    
    $('.accordion > h3').click(function(){ if ($(this).hasClass('current')) collapseall(); else { collapseall(); $(this).addClass('current'); $(this).next().addClass('current'); } });
    var collapseall = function(){ $('.accordion > h3, .accordion > div').removeClass('current') }

});

") ?>