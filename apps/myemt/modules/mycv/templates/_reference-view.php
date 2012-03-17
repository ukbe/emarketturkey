<?php use_helper('Date') ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
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