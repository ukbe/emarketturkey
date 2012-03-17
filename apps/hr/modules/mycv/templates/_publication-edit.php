<?php use_helper('DateForm') ?>
<div id="editrecord" class="cvRecordBlock">
<div>
<?php if ($object->isNew()): ?>
<h2><?php echo __('Add New Publication Item') ?></h2>
<?php else: ?>
<h2><?php echo __('Editing Publication Information') ?></h2>
<?php endif ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=publications', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsmp_subject', __('Subject')) ?></dt>
    <dd><?php echo input_tag('rsmp_subject', $sf_params->get('rsmp_subject', $object->getSubject()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmp_publisher', __('Publisher')) ?></dt>
    <dd><?php echo input_tag('rsmp_publisher', $sf_params->get('rsmp_publisher', $object->getPublisher()), 'size=50') ?></dd>
    <dt><?php echo emt_label_for('rsmp_edition', __('Edition')) ?></dt>
    <dd><?php echo input_tag('rsmp_edition', $sf_params->get('rsmp_edition', $object->getEdition()), 'size=20') ?></dd>
    <dt><?php echo emt_label_for('rsmp_coauthors', __('Co-Authors')) ?></dt>
    <dd><?php echo textarea_tag('rsmp_coauthors', $sf_params->get('rsmp_coauthors', $object->getCoAuthors()), 'cols=50 rows=3') ?></dd>
    <dt><?php echo emt_label_for('rsmp_binding', __('Binding')) ?></dt>
    <dd><?php echo select_year_tag('rsmp_binding', $sf_params->get('rsmp_binding', $object->getBinding()), array('year_start' => date('Y')+3, 'year_end' => date('Y')-50, 'include_custom' => __('year'))) ?></dd>
    <dt><?php echo emt_label_for('rsmp_isbn', __('ISBN')) ?></dt>
    <dd><?php echo input_tag('rsmp_isbn', $sf_params->get('rsmp_isbn', $object->getIsbn()), 'size=30') ?></dd>
</dl>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), "@mycv-action?action=publications", 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
</div>