<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="leftblock">
<h5><?php echo $object->getJobTitle() ?><em>(<?php echo distance_of_time_in_words($object->getDateFrom('U'), $object->getDateTo('U'), false) ?>)</em></h5>
<p class="flash"><?php echo ($object->getListedOnEmt()===1 && $object->getCompany())?$object->getCompany():$object->getCompanyName() ?></p>
<p><?php echo $object->getDateFrom() ? $object->getDateFrom('d F Y') : __('Not Specified') ?> -  <?php echo $object->getPresent()==false ? $object->getDateTo('d F Y') : __('Present') ?></p>
<?php if ($object->getProjects()): ?>
<div class="bubble">
<strong><?php echo __('Key Projects:') ?></strong>
<?php echo $object->getProjects() ?>
</div>
<?php endif ?>
</div>
</div>
</div>