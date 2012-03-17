<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@mycv-action?action=publications&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@mycv-action?action=publications") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@mycv-action?action=publications&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@mycv-action?action=publications&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
<div class="leftblock">
<h5><?php echo $object->getSubject() ?>
<?php if ($object->getEdition()): ?>
<em>(<?php echo $object->getEdition() ?>)</em>
<?php endif ?>
</h5>
<p class="flash"><?php echo $object->getPublisher() ?></p>
<?php if ($object->getBinding()): ?>
<p><?php echo $object->getBinding() ?></p>
<?php endif ?>
<?php if ($object->getIsbn()): ?>
<p><?php echo __('ISBN:') . ' ' . $object->getIsbn() ?></p>
<?php endif ?>
<?php if ($object->getCoAuthors()): ?>
<div class="bubble">
<strong><?php echo __('Key Subjects:') ?></strong>
<?php echo $object->getCoAuthors() ?>
</div>
<?php endif ?>
</div>
</div>
</div>