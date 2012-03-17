<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
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