<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<?php if ($thisIsMe): ?>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@hr.mycv-action?action=work&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@hr.mycv-action?action=work") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@hr.mycv-action?action=work&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@hr.mycv-action?action=work&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
<?php endif ?>
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