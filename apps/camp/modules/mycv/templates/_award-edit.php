<?php use_helper('DateForm') ?>
<div id="editrecord" class="cvRecordBlock">
<div>
<?php if ($object->isNew()): ?>
<h2><?php echo __('Add New Award/Honor Item') ?></h2>
<?php else: ?>
<h2><?php echo __('Editing Award/Honor Information') ?></h2>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=awards', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsma_title', __('Title')) ?></dt>
    <dd><?php echo input_tag('rsma_title', $sf_params->get('rsma_title', $object->getTitle()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsma_issuer', __('Issuer')) ?></dt>
    <dd><?php echo input_tag('rsma_issuer', $sf_params->get('rsma_issuer', $object->getIssuer()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsma_year', __('Year Presented')) ?></dt>
    <dd><?php echo select_year_tag('rsma_year', $sf_params->get('rsma_year', $object->getYear()), array('year_start' => date('Y'), 'year_end' => date('Y')-60, 'include_custom' => __('year'))) ?></dd>
    <dt><?php echo emt_label_for('rsma_notes', __('Notes')) ?></dt>
    <dd><?php echo textarea_tag('rsma_notes', $sf_params->get('rsma_notes', $object->getNotes()), 'cols=50 rows=3') ?></dd>
</dl>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), "@mycv-action?action=awards", 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
</div>