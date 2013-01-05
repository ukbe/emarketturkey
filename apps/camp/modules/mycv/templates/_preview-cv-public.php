<?php use_helper('Date', 'Number') ?>
<?php if (!$resume): ?>
<?php echo __('No Career Information') ?>
<?php else: ?>
<?php $works = $resume->getResumeWorks() ?>
<?php usort($works, 'myTools::sortResumeItems') ?>
<section>
    <h5 class="clear"><?php echo __('Work Experience') ?></h5>
<?php if (count($works)): ?>
<?php foreach($works as $object): ?>
<?php include_partial('mycv/work-view', array('object' => $object, 'act' => 'view', 'thisIsMe' => $thisIsMe)) ?>
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
<?php include_partial('mycv/school-view', array('object' => $object, 'act' => 'view', 'thisIsMe' => $thisIsMe)) ?>
<?php endforeach ?>
<?php else: ?>
<div class="resume-block"><span class="t_grey"><?php echo __('Education history not found.') ?></span></div>
<?php endif ?>
</section>
<?php endif ?>