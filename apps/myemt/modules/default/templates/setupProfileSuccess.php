<?php use_helper('DateForm') ?>
<?php slot('subNav') ?>
<?php include_partial('subNav-setupProfile', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948 login">
    <div class="box_657 _titleBG_Transparent" style="float: none; margin: 0 auto;">
        <h4><?php echo __('Profile Photo') ?></h4>
        <div class="_noBorder">
            <div id="profile-photo-holder">
            
                <div id="existing-photo"<?php echo $photo ? '' : ' class="ghost"' ?>>
                    <div class="margin-t1"><?php echo __('Your current profile photo.') ?></div>
                    <div class="hrsplit-3"></div>
                    <div class="pad-2">
                        <dl class="_table">
                            <dt style="background: url(/images/layout/icon/green-tick.png) no-repeat right center; padding: 0px; height: 64px;">
                        <dd><?php echo image_tag($photo ? $photo->getThumbnailUri() : '', 'border: solid 5px #ccc;') ?>
                        <div class="hrsplit-2"></div>
                        <?php echo link_to_function(__('Edit Thumbnail'), "$('#profile-photo-holder > *').slideUp(); $('#edit-thumbnail').slideDown(null, function(){ $('#cropbox').data('logoWidget')._reloadImage(); });", 'class=action-button') ?>&nbsp;&nbsp;
                        <?php echo link_to_function(__('Upload New'), "$('#profile-photo-holder > *').slideUp(); $('#upload-photo').slideDown();", 'class=action-button') ?>
                        </dd>
                        </dl>
                    </div>
                </div>
                <div id="upload-photo"<?php echo $photo ? 'class="ghost"' : '' ?>>
                    <div class="margin-t1"><?php echo __('Upload a file as your profile photo.') ?></div>
                    <div class="hrsplit-3"></div>
                    <div class="pad-2">
                        <?php echo form_tag("profile/photo", array('enctype' => 'multipart/form-data', 'id' => 'thumbform')) ?>
                        <div class="error-block"></div>
                        <dl class="_table">
                        <dt class="frm-st-select"><?php echo emt_label_for('profilephoto', 'Please select a file') ?></dt>
                        <dd class="frm-st-select"><?php echo input_file_tag('profilephoto') ?></dd>
                        <dt class="frm-st-select"></dt>
                        <dd class="frm-st-select"><?php echo submit_tag(__('Upload Photo'), 'class=frm-submit') ?>&nbsp;&nbsp;
                                                  <?php echo link_to_function(__('Cancel'), "$('#profile-photo-holder > *').slideUp(); $('#existing-photo').slideDown();") ?></dd>
                        <dt class="frm-st-process"></dt>
                        <dd class="frm-st-process"><?php echo __('Loading .. ') . image_tag('layout/icon/loading.gif') ?></dd>
                        <dt class="frm-st-process"></dt>
                        <dd class="frm-st-process"><?php echo link_to_function(__('Cancel Upload'), '', 'id=cancelupload') ?></dd>
                        </dl>
                        </form>
                    </div>
                </div>
                <div id="edit-thumbnail" class="ghost">
                    <div class="margin-t1"><?php echo __('Edit thumbnail of your profile photo.') ?></div>
                    <div class="hrsplit-3"></div>
                    <table style="margin: 0px; width: 100%; border: solid 2px #ddd; background-color: #F6F6F6;">
                        <tr>
                            <td style="margin: 0px; width: 400px; vertical-align: middle; text-align: center;"> 
                            <div id="cropbox" class="_comMng_nologo" style="width: 400px; height: 300px; text-align: center;background-color: white;">
                                <?php echo $photo ? image_tag($photo->getOriginalFileUri()) : image_tag('content/user/no-photo-e.png') ?>
                            </div>
                            </td>
                            <td style="background-color: #EFEFEF; vertical-align: middle; text-align: center; position: relative;">
                                <div id="preview" style="margin: auto;"></div>
                                <div class="hrsplit-2"></div>
                                <?php echo form_tag("profile/photo") ?>
                                <?php echo input_hidden_tag('process', 'thumb') ?>
                                <?php echo input_hidden_tag('crop', $photo ? $photo->getCrop() : '') ?>
                                <?php echo input_hidden_tag('ref', $photo ? $photo->getGuid() : '') ?>
                                <?php echo input_hidden_tag('coords', $photo ? $photo->getOffsetCoords() : '') ?>
                                <?php echo submit_tag(__('Save'), 'id=savephoto class=action-button') ?>&nbsp;&nbsp;
                                <?php echo link_to_function(__('Remove'), 'id=removephoto', 'class=bluelink') ?>
                                </form>
                                <div style="position: absolute; right: 10px; bottom: 10px;"><?php echo link_to_function(__('Upload New'), "$('#profile-photo-holder > *').slideUp(); $('#upload-photo').slideDown();", 'class=inherit-font bluelink hover') ?></div>
                            </td>
                        </tr>
                    </table> 
    
                </div>
            </div>
        <div class="hrsplit-2"></div>
        <h4><?php echo __('Profile Information') ?></h4>

<?php echo form_tag('default/setupProfile', 'id=profileform') ?>
<div class="hrsplit-3"></div>
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
<dd<?php echo $sf_request->hasError('profile_preferred_lang') ? ' class="focus"' : '' ?>><?php echo select_tag('profile_preferred_lang', options_for_select(array('en' => 'English', 'tr' => 'Türkçe', 'ru' => 'русский', ), $sf_params->get('profile_preferred_lang', $profile->getPreferredLanguage() ? $profile->getPreferredLanguage() : $sf_user->getCulture()), array('include_custom' => __('Select language')))) ?>
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
<dd><span class="_right"><?php echo link_to(__('Skip this step'), '@cm.friendfinder?sup=true', 'class=inherit-font bluelink hover') ?></span> <?php echo submit_tag(__('Save Profile'), 'class=green-button') ?></dd>
</dl>
</form>
<?php use_javascript('emt-location-1.0.js') ?>
<?php $dims = sfConfig::get('app_photoConfig_size') ?>
<?php $dims = $dims[MediaItemPeer::MI_TYP_ALBUM_PHOTO] ?>
<?php echo javascript_tag("
    $('#cropbox').logoWidget({formSelector: '#thumbform', imageUrl: '', prwDims: [".$dims['small']['width'].", ".$dims['small']['height']."], crop: ".($photo && $photo->getCrop() ? 'true' : $dims['crop']).", left: ".($photo && is_numeric($photo->getOffsetCoord('x')) ? $photo->getOffsetCoord('x') : 'undefined').", top: ".($photo && is_numeric($photo->getOffsetCoord('y')) ? $photo->getOffsetCoord('y') : 'undefined').", right: ".($photo && is_numeric($photo->getOffsetCoord('x2')) ? $photo->getOffsetCoord('x2') : 'undefined').", bottom: ".($photo && is_numeric($photo->getOffsetCoord('y2')) ? $photo->getOffsetCoord('y2') : 'undefined')."}).bind('logowidgetafterupload', function(){ $('#profile-photo-holder > *').slideUp(); $('#edit-thumbnail').slideDown(); });
    $('#profile_hometown_country, #contact_country').location({url: '".url_for('@location-query')."'});
") ?>
        </div>
    </div>
</div>