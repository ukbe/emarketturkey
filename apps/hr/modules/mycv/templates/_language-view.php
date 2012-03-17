<?php use_helper('Date') ?>
<?php $levels = ResumeLanguagePeer::$langLevels;
      $classes = array(ResumeLanguagePeer::RLANG_LEVEL_LOW       => 'level-low',
                       ResumeLanguagePeer::RLANG_LEVEL_FAIR      => 'level-fair',
                       ResumeLanguagePeer::RLANG_LEVEL_FLUENT    => 'level-fluent',
                       0                                         => 'level-unknown',
                      ); ?>
<div class="cvRecordBlock<?php echo $act == 'rem' ? ' confirm-removal' : '' ?>">
<div>
<div class="actions">
    <?php if ($act == 'rem'): ?>
    <?php echo link_to(__('Yes, Delete!'), "@mycv-action?action=languages&act=rem&id={$object->getId()}&do=commit", 'id=confirmremoval') ?>
    <?php echo link_to(__('Cancel'), "@mycv-action?action=languages") ?>
    <?php else: ?>
    <?php echo link_to(__('Edit'), "@mycv-action?action=languages&act=edit&id={$object->getId()}#editrecord", "id=edit{$object->getId()} class=ajax-enabled") ?>
    <?php echo link_to(__('Remove'), "@mycv-action?action=languages&act=rem&id={$object->getId()}#confirmremoval", "id=remove{$object->getId()} class=ajax-enabled removelink") ?>
    <?php endif ?>
</div>
<div class="leftblock">
<h5><?php echo format_language($object->getLanguage()) ?>
<?php if ($object->getNative()): ?>
<em>(<?php echo __('Native Speaker') ?>)</em>
<?php endif?>
</h5>
<?php if (!$object->getNative()): ?>
<p class="flash">
<div class="<?php echo $classes[$object->getLevelRead()] ?>"><?php echo __('Reading: ') ?><div class="level-bar"><div><span><?php echo $levels[$object->getLevelRead()] ?></span></div></div></div>
<div class="<?php echo $classes[$object->getLevelWrite()] ?>"><?php echo __('Writing: ') ?><div class="level-bar"><div><span><?php echo $levels[$object->getLevelWrite()] ?></span></div></div></div>
<div class="<?php echo $classes[$object->getLevelSpeak()] ?>"><?php echo __('Speaking: ') ?><div class="level-bar"><div><span><?php echo $levels[$object->getLevelSpeak()] ?></span></div></div></div>
</p>
<?php endif ?>
</div>
</div>
</div>