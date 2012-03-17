<?php slot('uppermenu') ?>
<?php include_partial('default/startup-uppermenu') ?>
<?php end_slot() ?>
<?php $has_p = $sesuser->getProfilePicture() ?>
<?php $horiz = $has_p ? $has_p->isHorizontal() : false ?>
<?php echo javascript_tag("
    function setupThumbnail()
    {
        var tmblr = jQuery('#thumbnailer');
        var tmbl = jQuery('#thumbnail');
        var imgPos = tmblr.offset();
        ah = tmblr.height();
        aw = tmblr.width();
        bh = tmbl.height();
        bw = tmbl.width();
        var x1 = (bw-aw > 0) ? imgPos.left - (bw-aw) + 1 : imgPos.left + 1;
        var y1 = (bh-ah > 0) ? imgPos.top - (bh-ah) + 1 : imgPos.top + 1;
        var x2 = (bw-aw < 0) ? imgPos.left + (bw-aw) + 1 : imgPos.left + 1;
        var y2 = (bh-ah < 0) ? imgPos.top + (bh-ah) + 1 : imgPos.top + 1;

        if (tmbl.is('.ui-draggable'))
        {
            tmbl.draggable('option', 'containment', [x1, y1, x2, y2]);
        }
        else
        {
            tmbl.draggable({ containment: [x1, y1, x2, y2], stop: function(event, ui){el=jQuery('#thumbnail').position();jQuery('#profileform #offx').val(-1*el.left);jQuery('#profileform #offy').val(-1*el.top);jQuery('#profileform #newi').val(1);} });
        }
        tmbl.css({cursor: 'move'});
    }
    
    var uploadStarted = false;
    var hasp = false;
    function OnUploadStart(){            
        uploadStarted = true;
        jQuery('#uploadform dd.upform').removeClass('focus');
        jQuery('#uploadform li').hide();
        jQuery('li.proc').show();
    }

    function interruptUpload(){            
        uploadStarted = false;
        if (navigator.appName == 'Microsoft Internet Explorer') {
            window.frames['upload-frame'].document.execCommand('Stop');
        } else {
            window.frames['upload-frame'].stop();
        }
        jQuery('#uploadform dt, #uploadform dd').hide();
        jQuery('#uploadform .upform').show();
        jQuery('#profileform #newi').val(0);
    }

    function cancelUpload(){            
        jQuery('#uploadform dt, #uploadform dd').hide();
        jQuery('#uploadform dd.upform').removeClass('focus');
        jQuery('#uploadform .thumbform').show();
    }

    function resetUpload(){            
        uploadStarted = false;
        document.forms['uploadform'].reset();
        jQuery('#uploadform dt, #uploadform dd').hide();
        jQuery('#uploadform .upform').show();
        jQuery('#profileform #newi').val(0);
    }

    function OnUploadComplete(state, message, uri){
       if(state == 1)
       {
        jQuery('#thumbnail').attr('src', uri);
        jQuery('#uploadform dt, #uploadform dd').hide();
        jQuery('#uploadform .thumbform').show();
        jQuery('#profileform #newi').val(1);
        jQuery('#profileform #offx, #profileform #offy').val(0);
       }     
       else if(state == 0 && uploadStarted)
       {
         jQuery('#upload_file_error .err-1').html(message);
         jQuery('#uploadform dd.upform').addClass('focus');
         jQuery('#profileform #newi').val(0);
       }
       uploadStarted = false;
    }
    ") ?>
<style>
.thumbformatter #thumbnailer
{
    width: 50px;
    height: 50px;
    background-color: #FFFFFF;
    overflow:hidden;
    z-index: 200;
    border: solid 1px;
    position: absolute;
}
.thumbformatter #thumbnailer img
{
    z-index: 150;
    position: relative;
    <?php echo "left: ".($has_p && $horiz ? (-1 *$has_p->getOffsetPad()) : 0) . "px; top:".($has_p && !$horiz ? -1 * $has_p->getOffsetPad() : 0)."px;" ?>
}
dl.easyform input[type=text]
{
    font: 11pt tahoma;
    padding: 4px;
    border: solid 1px #CCCCCC;
}
dl.easyform select
{
    border: solid 1px #CCCCCC;
    background-color: #FFFFFF;
    padding: 4px;
    margin: 0px;
}
dl.easyform input[type=file]
{
    border: solid 1px #CCCCCC;
    padding: 10px 10px;
    margin: 10px 0px;
    font: bold 9pt tahoma;
    color: #505050;
}
dl.form dt {width: 300px;}
dl.form dd {width: 550px;}
</style>
<?php echo form_tag('default/uploadProfile', array('target' => 'upload-frame', 'enctype' => 'multipart/form-data', 'onsubmit' => 'OnUploadStart()', 'id' => 'uploadform')) ?>
<dl class="form easyform thumbformatter">
    <dt class="upform<?php echo $has_p ? ' ghost': '' ?>"><?php echo emt_label_for('upload_file', __('Select an image file for your profile picture')) ?></dt>
    <dd class="upform upfile<?php echo ($has_p ? ' ghost': '') . ($sf_request->hasError('upload_file') ? ' focus"' : '') ?>"><?php echo input_file_tag('upload_file', '') ?><br />
        <span class="form-error" id="upload_file_error" style="float: none;">
        <span class="err-1" title=""></span><br />
        </span><?php echo submit_tag(__('Upload Photo'), 'class=nice') ?>&nbsp;&nbsp;<?php echo link_to_function(__('Cancel'), 'cancelUpload()', 'class=nice cancel-upload'.($has_p ? '' : ' ghost')) ?></dd>
    <dt class="thumbform<?php echo !$has_p ? ' ghost': '' ?>"><?php echo emt_label_for('thumbnail', __('Edit thumbnail')) ?></dt>
    <dd class="thumbform<?php echo !$has_p ? ' ghost': '' ?>">
        <div style="height: 50px;"><div id="thumbnailer"><?php echo image_tag($has_p ? $sesuser->getProfilePicture()->getUncroppedThumbUri() : $sesuser->getProfilePictureUri(), array('id' => 'thumbnail', 'onload' => 'setupThumbnail()', 'onmousedown' => 'javascript:if (event.preventDefault) event.preventDefault()')) ?></div></div><br />
        <?php echo button_to_function(__('Upload New'), 'resetUpload()', 'class=nice') ?>
        </dd>
    <dt></dt>
    <dd class="proc ghost"><?php echo __('Uploading your profile picture') ?><br />
        <?php echo button_to_function(__('Cancel Upload'), 'interruptUpload();', 'class=nice') ?>
        </dd>
</dl>
</form>
    <iframe id="upload-frame" name="upload-frame" style="width: 0px; height: 0px; border: none; display: none;" onload="OnUploadComplete(0);"></iframe>
<?php echo form_tag('default/setupProfile', 'id=profileform') ?>
<?php echo input_hidden_tag('newi', 0) ?>
<?php echo input_hidden_tag('offx', $has_p && $horiz ? $has_p->getOffsetPad() : 0) ?>
<?php echo input_hidden_tag('offy', $has_p && !$horiz ? $has_p->getOffsetPad() : 0) ?>
<dl class="form easyform">
<dt><?php echo emt_label_for('profile_hometown_country', __('Select your home country')) ?></dt>
<dd<?php echo $sf_request->hasError('profile_hometown_country') ? ' class="focus"' : '' ?>><?php echo select_country_tag('profile_hometown_country', $home_cnt, array('include_custom' => __('Select your home country'))) ?>
    <span class="form-error hangright" id="profile_hometown_country_error">
        <span class="err-1" title="^[A-Z]{2}$"><?php echo __('Please select your home country') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('profile_hometown_state', __('Select your home state/province')) ?></dt>
<dd<?php echo $sf_request->hasError('profile_hometown_state') ? ' class="focus"' : '' ?>><?php echo select_tag('profile_hometown_state', options_for_select($local_cities, $sf_params->get('profile_hometown_state', $profile->getHomeTownId()), array('include_custom' => __('Select state/province')))) ?>
    <span class="form-error" id="profile_hometown_state_error">
        <span class="err-1" title="^[0-9]{1,9}$"><?php echo __('Please select your home state/province') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('profile_preferred_lang', __('Select your preferred language')) ?></dt>
<dd<?php echo $sf_request->hasError('profile_preferred_lang') ? ' class="focus"' : '' ?>><?php echo select_language_tag('profile_preferred_lang', $sf_params->get('profile_preferred_lang', $profile->getPreferredLanguage() ? $profile->getPreferredLanguage() : $sf_user->getCulture()), array('include_custom' => __('Select language'))) ?>
    <span class="form-error" id="profile_preferred_lang_error">
        <span class="err-1" title="^(tr)|(en)$"><?php echo __('Please select your preferred language') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('profile_marital_status', __('Marital Status')) ?></dt>
<dd class="optional<?php echo $sf_request->hasError('profile_marital_status') ? ' focus' : '' ?>" style="margin-bottom: 25px;"><?php echo select_tag('profile_marital_status', options_for_select(
    array(UserProfilePeer::MAR_STAT_NA      => __('Prefer not to say'),
          UserProfilePeer::MAR_STAT_SINGLE  => __('Single'),
          UserProfilePeer::MAR_STAT_MARRIED => __('Married')), $sf_params->get('profile_marital_status', $profile->getMaritalStatus()))) ?>
    <span class="form-error" id="profile_marital_status_error">
        <span class="err-1" title="^(0)|(1)|(2)$"><?php echo __('Please specify your marital status') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('contact_type', __('Contact Type')) ?></dt>
<dd<?php echo $sf_request->hasError('contact_type') ? ' class="focus"' : '' ?>><?php echo select_tag('contact_type', options_for_select(array(ContactPeer::HOME => __(ContactPeer::textOf(ContactPeer::HOME).'%adr', array('%adr' => '')), ContactPeer::WORK => __(ContactPeer::textOf(ContactPeer::WORK).'%adr', array('%adr' => ''))), $sf_params->get('contact_type', $address->getType()), array('include_custom' => __('Select Contact Type')))) ?>
    <span class="form-error" id="contact_type_error">
        <span class="err-1" title="^(1)|(2)$"><?php echo __('Please select contact type') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('contact_country', __('Select your current residential country')) ?></dt>
<dd<?php echo $sf_request->hasError('contact_country') ? ' class="focus"' : '' ?>><?php echo select_country_tag('contact_country', $cont_cnt, array('include_custom' => __('Select your residential country'))) ?>
    <span class="form-error" id="contact_country_error">
        <span class="err-1" title="^[A-Z]{2}$"><?php echo __('Please select the country where you live') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('contact_street', __('Street Address')) ?></dt>
<dd<?php echo $sf_request->hasError('contact_street') ? ' class="focus"' : '' ?>><?php echo input_tag('contact_street', $sf_params->get('contact_street', $address->getStreet()), 'style=width:320px; maxlength=255') ?>
    <span class="form-error" id="contact_street_error">
        <span class="err-1" title="^[^]+$"><?php echo __('Please enter your street address') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('contact_state', __('State/Province')) ?></dt>
<dd<?php echo $sf_request->hasError('contact_state') ? ' class="focus"' : '' ?>><?php echo select_tag('contact_state', options_for_select($contact_cities, $sf_params->get('contact_state', $address->getState()), array('include_custom' => __('Select state/province')))) ?>
    <span class="form-error" id="contact_state_error">
        <span class="err-1" title="^[0-9]{1,9}$"><?php echo __('Please select your state/province') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('contact_town', __('City/Town')) ?></dt>
<dd<?php echo $sf_request->hasError('contact_town') ? ' class="focus"' : '' ?>><?php echo input_tag('contact_town', $sf_params->get('contact_town', $address->getCity()), 'maxlength=50 size=25') ?>
    <span class="form-error" id="contact_town_error">
        <span class="err-1" title="^[^]+$"><?php echo __('Please enter your city/town') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('contact_postal_code', __('Postal Code')) ?></dt>
<dd<?php echo $sf_request->hasError('contact_postal_code') ? ' class="focus"' : '' ?>><?php echo input_tag('contact_postal_code', $sf_params->get('contact_postal_code', $address->getPostalCode()), 'size=10 maxlength=10') ?>
    <span class="form-error" id="contact_postal_code_error">
        <span class="err-1" title="^[^]+$"><?php echo __('Please enter postal code') ?></span>
    </span></dd>
<dt><?php echo emt_label_for('contact_phone', __('Phone Number')) ?></dt>
<dd<?php echo $sf_request->hasError('contact_phone') ? ' class="focus"' : '' ?>><?php echo input_tag('contact_phone', $sf_params->get('contact_phone', $phone->getPhone()), 'maxlength=50 size=25') ?>
    <span class="form-error" id="contact_phone_error">
        <span class="err-1" title="^\+?([0-9]|\(|\)|-|\/|\s)+$"><?php echo __('Please enter your phone number') ?></span>
    </span></dd>
<dt></dt>
<dd><span class="hangright"><?php echo link_to(__('Skip this step'), '@cm.friendfinder?sup=true', 'class=action') ?></span> <?php echo submit_tag(__('Save Profile'), 'class=nice') ?></dd>
</dl>
</form>
<?php echo javascript_tag("
    $('#profile_hometown_country, #contact_country').change(function(){
        var t = $(this);
        var s = $('#'+t.attr('id').replace('_country', '_state'));
        if (this.value != '')
        {
            t.attr('disabled', true);
            s.attr('disabled', true);
            $.getJSON('".url_for('profile/locationQuery')."', {cc: t.val()}, 
                function(d){
                    s.find(\"option[value!='']\").remove();
                    $(d).each(function(g,i){s.append($('<option value='+i.ID+'>'+i.NAME+'</option>'));});
                }
            )
            .error(function(e,str){etag.removeClass('ghost');})
            .complete(function(){t.attr('disabled', false);s.attr('disabled', false);});
        }
        else if (this.value == '')
        {
            s.empty();
        }
    });

$.fn.validateForm = function(){
    var o = $(this[0]);
    $.extend(o, {fields: o.find('.form-error'),
        setupField: function(dl){
            $.extend(dl, {input: o.find('input#'+$(dl).attr('id').replace('_error', '')+',select#'+$(dl).attr('id').replace('_error', '')), label: o.find('label[for=\"'+$(dl).attr('id').replace('_error', '')+'\"]'), errorBlock: $(dl), errorTypes: $(dl).find('span[class^=\"err-\"]'), 
                validate: function(){
                    var result = true;
                    dl.errorTypes.each(function(i,ertyp){
                        var regex  =  new RegExp($(ertyp).attr('title'));
                        if (!regex.test(dl.input.val())) {
                            $(dl).parent().addClass('focus');
                            dl.label.addClass('error');
                            return (result = false);
                        }
                        else
                        {
                            $(dl).parent().removeClass('focus');
                            dl.label.removeClass('error');
                        }
                    });
                    return result;
                },
            });
        },
        validate: function(){
            var errs = [];
            o.fields.each(function(i,field){
                if (!field.validate())
                {
                    errs.push(field);
                }
            });
            return errs.length == 0;
        }
    });
    o.fields.each(function(i,l){o.setupField(l);});
    o.submit(function(){return o.validate();})
};
    $('#profileform').validateForm();
    ") ?>