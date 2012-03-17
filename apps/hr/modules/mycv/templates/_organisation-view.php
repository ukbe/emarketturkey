<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@mycv-action?action=organisations&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@mycv-action?action=organisations") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@mycv-action?action=organisations&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@mycv-action?action=organisations&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
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