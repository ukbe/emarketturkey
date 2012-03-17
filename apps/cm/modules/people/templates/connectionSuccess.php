<div class="col_948">
    <div class="col_180">
&nbsp;
    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __('Connect to %1user', array('%1user' => $user)) ?></h4>
            <?php echo form_tag("@connect-user?user={$user->getPlug()}") ?>
            <?php echo input_hidden_tag('_ref', $_ref) ?>
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
        </div>
        <div class="hrsplit-2"></div>
        <?php echo submit_tag(__('Connect'), 'class=green-button') ?>&nbsp;&nbsp;
        <?php echo link_to(__('Cancel'), $_ref ? $_ref : '@people', 'class=inherit-font bluelink hover')?>
        </dd>
</dl>
            </form>
        </div>
        
    </div>

    <div class="col_180">
    </div>

</div>