<emtAjaxResponse>
<emtInit>
$('#con-form').dynabox({clickerOpenClass: '_btn_up', clickerId: '_ID_-submit', clickerMethod: 'click', highlightUnless: 'clicked', isFeed: false,
    loadType: 'html', loadMethod: 'ajax', keepContent: false, autoUpdate: false, method: 'POST', position: 'window'  
    });

window.initElementsScript('#TB_window');
</emtInit>
<emtHeader><?php echo __('Connect to %1', array('%1' => $user)) ?></emtHeader>
<emtBody>
<section>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php echo form_tag(url_for("@connect-user?user={$user->getPlug()}", true), 'id=con-form') ?>
<?php echo input_hidden_tag('_ref', $_ref) ?>
<?php echo input_hidden_tag('mod', 'commit') ?>
<dl class="_table">
    <dt><?php echo image_tag($user->getProfilePictureUri()) ?></dt>
    <dd><strong><?php echo $user ?></strong>
        <div class="hrsplit-2"></div>
        <?php echo __('Click the Connect link below to send a request to %1user.', array('%1user' => $user))?>
        <div class="hrsplit-2"></div>
        <?php $has_message = $sf_params->get('message') != '' ?>
        <?php echo link_to_function(__('Include Message'), "$(this).hide(); $('#con-message').slideDown('fast', function(){ $('include-message').val(1); });", 'id=con-include-message class=bluelink hover'. ($has_message ? ' ghost' : ''))?>
        <div class="hrsplit-1"></div>
        <div id="con-message"<?php echo !$has_message ? 'class="ghost"' : '' ?>>
            <?php echo input_hidden_tag('include-message', $sf_params->get('include-message', 0))?>
            <?php echo textarea_tag('message', $sf_params->get('message', __('I would like to add you to my professional network')), 'cols=50 rows=3') ?>
            <div><?php echo link_to_function(__('Dismiss Message'), "$('#con-message').slideUp('fast', function(){ $('include-message').val(0); }); $('#con-include-message').show();", 'class=bluelink hover') ?></div>
        </div></dd>
</dl>
</form>
<div class="clear"></div>
</section>
</emtBody>
<emtFooter>
<span class="center">
<?php echo link_to_function(__('Connect'), "", 'id=con-form-submit class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$.ui.dynabox.openBox.close()", 'class=inherit-font bluelink hover') ?></span>
</emtFooter>
</emtAjaxResponse>