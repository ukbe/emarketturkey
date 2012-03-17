<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@mycv-action?action=references&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@mycv-action?action=references") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@mycv-action?action=references&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@mycv-action?action=references&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
<div class="leftblock">
<h5><?php echo $object->getName() ?><em>(<?php echo $object->getJobTitle() ?>)</em></h5>
<p class="flash"><?php echo $object->getCompanyName() ?></p>
<?php $inf = array_filter(array(
                   $object->getEmail() ? '<strong>'.  __('Email:'). '</strong> ' . $object->getEmail() : null,
                   $object->getPhoneNumber() && $object->getPhoneNumber()->getPhone() ? '<strong>' . __('Phone:'). '</strong> ' . $object->getPhoneNumber()->getPhone() : null
              ));
?>
<?php if (count($inf)): ?>
<ul class="sepdot"><li><?php echo implode('</li><li>', $inf) ?></li></ul>
<?php endif ?>
<div class="clear"></div>
</div>
</div>
</div>