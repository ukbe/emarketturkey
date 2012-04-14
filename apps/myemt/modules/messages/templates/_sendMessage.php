<emtAjaxResponse>
<emtInit>
<?php echo "
$('#mess-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });
$.ajaxSetup({async: false});
$.getScript('/js/emt-dynalist-1.0.js');
$.ajaxSetup({async: true});
$('#reco').dynalist({
    data: $recdata,
    autoCompleteConf: {url: '".url_for('@query-network', true)."', data: { scope: $('#_s').val() }},
    classMap: { TYPE_ID: {1: 'user-px', 2: 'company-px', 3: 'group-px'} },
    includeSpan: true, mapFields: {HASH: '_r[]'}
    });
" ?>
</emtInit>
<emtHeader><?php echo __('Send Message to %1', array('%1' => $header)) ?></emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag(url_for("@compose-message", true), 'id=mess-form') ?>
<?php echo input_hidden_tag('_ref', $_ref) ?>
<?php echo input_hidden_tag('mod', 'commit') ?>
<dl class="_table">
<dt><?php echo emt_label_for('_s', __('Sender')) ?></dt>
<dd><?php echo image_tag($sender->getProfilePictureUri(), 'class=_left style=margin: -2px 10px 0px 0px; height: 20px;') . $sender ?>
    <?php echo input_hidden_tag('_s', $sender->getPlug()) ?></dd>
<dt><?php echo emt_label_for('_r', __('Recipient')) ?></dt>
<dd><div id="reco"></div></dd>
<dt><?php echo emt_label_for('_subject', __('Subject')) ?></dt>
<dd><?php echo input_tag('_subject', $sf_params->get('_subject')) ?></dd>
<dt><?php echo emt_label_for('_message', __('Message')) ?></dt>
<dd><?php echo textarea_tag('_message', $sf_params->get('_message'), 'cols=40 rows=4') ?></dd>
</dl>
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Send Message'), "", 'id=mess-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>