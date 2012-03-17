<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="leftblock">
<h5><?php echo $object->getMajor() ?><em>(<?php echo $object->getResumeSchoolDegree() ?>)</em></h5>
<p class="flash"><?php echo $object->getSchool() ?></p>
<p><?php echo $object->getDateFrom() ? $object->getDateFrom('d F Y') : __('Not Specified') ?> -  <?php echo $object->getPresent()==false ? $object->getDateTo('d F Y') : __('Present') ?></p>
<?php if ($object->getSubjects()): ?>
<div class="bubble">
<strong><?php echo __('Key Subjects:') ?></strong>
<?php echo $object->getSubjects() ?>
</div>
<?php endif ?>
</div>
</div>
</div>