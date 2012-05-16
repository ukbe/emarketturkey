<div class="spot-job-card" style="background: url(<? echo ($back = $owner->getHRProfile()->getSpotBoxBackground()) ? $back->getUri() : '/images/layout/background/spot-job-post-default-bg.jpg' ?>) no-repeat 0px;">
<div class="logo"><img src="<?php echo $owner->getHRProfile()->getHRLogo() ? $owner->getHRProfile()->getHRLogo()->getMediumUri() : $owner->getLogo()->getMediumUri() ?>" /></div>
<div class="_right-block blurred">
        <dl>
            <dt><?php echo $job ?></dt>
            <?php foreach (explode("\n", $job->getClob(JobI18nPeer::REQUIREMENTS)) as $line): ?>
            <dd><?php echo $line ?></dd>
            <?php endforeach ?>
        </dl><?php $loc = $job->getLocations(null, null, true) ?>
        
        <div class="_job_location">
            <?php if (count($loc)): ?>
            <em class="_job_city"><?php echo CountryPeer::retrieveByISO($loc->getCountryCode()) ?></em> 
            <em class="_job_town"><?php echo $loc->getGeonameCity() ?></em>
            <?php if (count($loc) > 1): ?>
            <em><?php echo __('%1num more', array('%1num' => count($loc)-1)) ?></em>
            <?php endif?>
            <?php endif ?> 
            <small><?php echo __('REF:') ?></small> <em class="_job_ref"><?php echo $job->getRefCode() ?></em>
        </div>
        <div class="_job_tools"><div class="_job_tools_button"><a href="<?php echo url_for($job->getUrl()) ?>"><span><?php echo __('VIEW JOB POST') ?></span></a></div><div class="_job_tools_link"><?php echo link_to($job->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? __('GO TO COMPANY PROFILE') : __('GO TO GROUP PROFILE'), $owner->getProfileUrl()) ?><?php echo $job->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? link_to(__('MORE JOBS FROM THIS COMPANY'), "@company-jobs?hash={$owner->getHash()}") : link_to(__('MORE JOBS FROM THIS GROUP'), "@group-jobs?hash={$owner->getHash()}") ?><?php echo link_to(__('SIMILAR JOBS'), "@similar-jobs?guid={$job->getGuid()}")?></div></div>
    </div>
</div>