<?php use_helper('DateForm') ?>
<emtAjaxResponse>
<emtInit>
<?php echo "
$('#ajx-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });

$('dl._table input').customInput();
" ?>
</emtInit>
<emtHeader>
<?php if ($object->isNew()): ?>
<?php echo __('Add New Publication Item') ?>
<?php else: ?>
<?php echo __('Editing Publication Information') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
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
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Save'), "", 'id=ajx-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>