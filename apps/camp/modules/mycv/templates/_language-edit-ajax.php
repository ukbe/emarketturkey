<?php $options = array(null                                      => __('Not Specified'),
                       ResumeLanguagePeer::RLANG_LEVEL_LOW       => __('Low'),
                       ResumeLanguagePeer::RLANG_LEVEL_FAIR      => __('Fair'),
                       ResumeLanguagePeer::RLANG_LEVEL_FLUENT    => __('Fluent'),
                      );
      $nativeClass = ($sf_params->get('rsml_native', $object->getNative()) ? ' ghost' : ''); ?>
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
<?php echo __('Add New Language Item') ?>
<?php else: ?>
<?php echo __('Editing Language Information') ?>
<?php endif ?>
</emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag('@mycv-action?action=languages', 'id=ajx-form') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt><?php echo emt_label_for('rsml_language', __('Language')) ?></dt>
    <dd><?php echo select_language_tag('rsml_language', $sf_params->get('rsml_language', $object->getLanguage()), array('include_custom' => __('Select Language'))) ?></dd>
    <dt><?php echo emt_label_for('rsml_native', __('Native')) ?></dt>
    <dd><?php echo checkbox_tag('rsml_native', 1, $sf_params->get('rsml_native', $object->getNative()), array('onchange' => "if ($(this).is(':checked')) $('.levels').hide(); else $('.levels').show();")) ?></dd>
    <dt class="levels<? echo $nativeClass ?>"><?php echo emt_label_for('rsml_read_level', __('Reading')) ?></dt>
    <dd class="levels<? echo $nativeClass ?>"><?php echo select_tag('rsml_read_level', options_for_select($options, $sf_params->get('rsml_read_level', $object->getLevelRead()))) ?></dd>
    <dt class="levels<? echo $nativeClass ?>"><?php echo emt_label_for('rsml_write_level', __('Writing')) ?></dt>
    <dd class="levels<? echo $nativeClass ?>"><?php echo select_tag('rsml_write_level', options_for_select($options, $sf_params->get('rsml_write_level', $object->getLevelWrite()))) ?></dd>
    <dt class="levels<? echo $nativeClass ?>"><?php echo emt_label_for('rsml_speak_level', __('Speaking')) ?></dt>
    <dd class="levels<? echo $nativeClass ?>"><?php echo select_tag('rsml_speak_level', options_for_select($options, $sf_params->get('rsml_speak_level', $object->getLevelSpeak()))) ?></dd>
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