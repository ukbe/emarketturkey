<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@mycv-action?action=courses&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@mycv-action?action=courses") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@mycv-action?action=courses&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@mycv-action?action=courses&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
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