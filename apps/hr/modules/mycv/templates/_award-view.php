<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@mycv-action?action=awards&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@mycv-action?action=awards") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@mycv-action?action=awards&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@mycv-action?action=awards&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
<div class="leftblock">
<h5><?php echo $object->getTitle() ?><em>(<?php echo $object->getYear() ?>)</em></h5>
<p class="flash"><?php echo $object->getIssuer() ?></p>
<?php if ($object->getNotes()): ?>
<div class="bubble">
<strong><?php echo __('Notes:') ?></strong>
<?php echo $object->getNotes() ?>
</div>
<?php endif ?>
</div>
</div>
</div>