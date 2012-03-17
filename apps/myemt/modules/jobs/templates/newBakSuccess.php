<?php use_helper('EmtAjaxTable', 'Object', 'DateForm') ?>
<?php slot('mappath') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/company_pagetop', array('company' => $owner,
                                                       'map' => array(__('Manage Company') => "@company-manage?hash=$own", 
                                                                      __('Jobs') => "@company-jobs-action?action=list&hash=$own",
                                                                      $job->isNew()?__('New Job'):$job->getTitle() => null
                                                                      )
                                                   )) ?> 
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/group_pagetop', array('group' => $owner,
                                                   'map' => array(__('Manage Group') => "@cm.group-manage?action=manage&stripped_name={$owner->getStrippedName()}",
                                                                  __('Jobs') => "@group-jobs-action?action=list&hash=$own",
                                                                  $job->isNew()?__('New Job'):$job->getTitle() => null
                                                                  )
                                                   )) ?> 
<?php endif ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenu') ?>
<?php end_slot() ?>
<?php slot('pagecommands') ?>
<?php end_slot() ?>

<div class="column span-156 last">
<div class="column span-156">
<?php echo image_tag('layout/background/jobs/job-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_tag(($otyp==PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-jobs-action?action=new&hash=$own" : "@group-jobs-action?action=new&hash=$own") . ($id!==null ? "id=$id" : null)) ?>
<?php echo input_hidden_tag('act', 'edit') ?>
<?php echo !$job->isNew()?input_hidden_tag('id', $job->getId()):'' ?>
<ol class="column span-130">
    <li class="column span-120 first"><?php echo form_errors() ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('refcode', __('Reference Code')) ?></li>
    <li class="column span-92 prepend-2"><?php echo input_tag('refcode',$sf_params->get('refcode', $job->getRefCode()), 'size=20') ?><br />
                                         <span class="hint"><em><?php echo __('Example: SE-2') ?></em></span></li>
    <li class="column span-36 first right"><?php echo emt_label_for('job_title', __('Job Title')) ?></li>
    <li class="column span-92 prepend-2"><?php echo input_tag('job_title',$sf_params->get('job_title', $job->getTitle()), 'size=50') ?><br />
                                         <span class="hint"><em><?php echo __('Example: Software Engineer') ?></em></span></li>
    <li class="column span-36 first right"><?php echo emt_label_for('sector_id', __('Sector')) ?></li>
    <li class="column span-92 prepend-2"><?php echo object_select_tag($sf_params->get('sector_id', $job->getSectorId()), 'sector_id', array(
      'include_custom' => __('select a job sector'),
      'related_class' => 'BusinessSector',
      'peer_method' => 'getOrderedNames'
      )) ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('position_id', __('Job Position')) ?></li>
    <li class="column span-92 prepend-2"><?php echo object_select_tag($sf_params->get('position_id', $job->getJobPositionId()), 'position_id', array(
      'include_custom' => __('select a job position'),
      'related_class' => 'JobPosition',
      'peer_method' => 'getOrderedNames'
      )) ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('no_of_staff', __('Number Of Staff')) ?></li>
    <li class="column span-92 prepend-2"><?php echo input_tag('no_of_staff',$sf_params->get('no_of_staff', $job->getNoOfStaff()), 'size=10') ?><br />
                                         <span class="hint"><em><?php echo __('Example: 3') ?></em></span></li>
</ol>
<?php echo image_tag('layout/background/jobs/location-info.'.$sf_user->getCulture().'.png') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('job_country', __('Country')) ?></li>
    <li class="column span-92 prepend-2 csel<?php if (!$cc && !$job->getGeonameCity()) echo " ghost" ?>"><?php echo "<b>".format_country($job->getGeonameCity()?$job->getGeonameCity()->getCountryCode():$cc).'</b>&nbsp;'.link_to_function(__('Change'), "jQuery('.csel').toggle()") ?></li>
    <li class="column span-92 prepend-2 csel<?php if ($cc || $job->getGeonameCity()) echo " ghost" ?>"><?php echo select_country_tag('job_country', $sf_params->get('job_country', $job->getCountry()?$job->getCountry()->getGeonameId():null), array('include_custom' => __('please select country for job position'))) ?></li>
    <?php echo observe_field('job_country', array('update' => 'job_country_state_div',
                    'url' => 'profile/findlocation', 'with' => "'country_code=' + value + '&ID=KE35LF402K'")) ?>
    <li class="column span-36 first right"><?php echo emt_label_for('location_id', __('State/Province')) ?></li>
    <li class="column span-90 prepend-2"><div id="job_country_state_div"><?php echo select_tag('location_id', options_for_select($local_cities, $job->getLocationId(), array('include_custom' => __('select state/province')))) ?></div></li>
</ol>
<?php echo image_tag('layout/background/products/product-lsi.'.$sf_user->getCulture().'.png') ?>
<ol class="column span-130">
    <?php include_partial('jobs/job_lsi_form', array('culture' => 'en', 'job' => $job)) ?>
    <?php include_partial('jobs/job_lsi_form', array('culture' => 'tr', 'job' => $job)) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?></li>
</ol>
</form>
</div>
</div>