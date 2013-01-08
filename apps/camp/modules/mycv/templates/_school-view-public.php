<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<?php if ($thisIsMe): ?>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@mycv-action?action=education&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@mycv-action?action=education") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@mycv-action?action=education&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@mycv-action?action=education&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
<?php endif ?>
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