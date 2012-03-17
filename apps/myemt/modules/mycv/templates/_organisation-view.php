<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="leftblock">
<h5><?php echo $object->getName() ?>
<?php if ($object->getActivityId()): ?>
<em>(<?php echo __(ResumeOrganisationPeer::$typeAttNames[$object->getActivityId()]) ?>)</em>
<?php endif ?>
</h5>
<p class="flash"><?php echo implode(', ', array($object->getCity(), $object->getState(), format_country($object->getCountryCode()))) ?></p>
<?php if ($object->getJoinedInYear()!=''): ?>
<p><?php echo __('Member since %1', array('%1' => $object->getJoinedInYear())) ?></p>
<?php endif ?>
</div>
</div>
</div>