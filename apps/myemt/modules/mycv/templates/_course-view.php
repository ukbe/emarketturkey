<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="leftblock">
<h5><?php echo $object->getName() ?></h5>
<p class="flash"><?php echo $object->getInstitute() ?></p>
<?php if ($object->getDateFrom() || $object->getDateTo()): ?>
<p><?php echo $object->getDateFrom() ? $object->getDateFrom('d F Y') : __('Not Specified') ?>
<?php if ($object->getDaily()): ?>
 (<?php echo __('Single Day') ?>)
<?php else: ?>
 - <?php echo $object->getPresent()==false ? $object->getDateTo('d F Y') : __('Present') ?>
<?php endif ?>
 </p>
<?php endif ?>
</div>
</div>
</div>