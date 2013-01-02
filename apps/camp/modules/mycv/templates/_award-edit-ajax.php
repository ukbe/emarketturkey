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
<?php echo __('Add New Award/Honor Item') ?>
<?php else: ?>
<?php echo __('Editing Award/Honor Information') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
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