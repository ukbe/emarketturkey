<?php slot('mappath') ?>
<?php include_partial('profile/user_pagetop', array('map'   => array(__('Profile') => $sesuser->getProfileUrl(), 
                                                                     __('Photos') => $sesuser->getPhotosUrl(),
                                                                     __('Upload Photo') => null
                                                                 ),
                                                    'user'  => $sesuser
                                                   )) ?> 
<?php end_slot() ?>
<div class="column span-100 pad-1 append-1">
<h2>Upload Photo</h2>
<p><?php echo __('You may upload photos for your profile. Please take care of requirements while selecting the files to upload.') ?></p>
<ul>
<li><?php echo __('Maximum size of the file should be 2MB.') ?></li>
<li><?php echo __('Only files with an extention of .jpeg, .jpg, .png. are allowed.') ?></li>
</ul>
<?php echo form_errors() ?>
<?php echo form_tag($sesuser->getUploadUrl(), 'multipart=true') ?>
<ol class="column span-100">
<li class="column span-28 append-2 right"><?php echo emt_label_for('upload_file', __('Select File')) ?></li>
<li class="column span-70"><?php echo input_file_tag('upload_file', '') ?><br />
<?php echo checkbox_tag('set_as_profile_image', 'yes').__('Set as profile picture.') ?></li>
<li class="column span-28 append-2 right"><?php echo emt_label_for('store_in_album', __('Store in album')) ?></li>
<li class="column span-70"><?php echo select_tag('store_in_album', array_merge_recursive(array('0' => 'none', 'new' => __('new album ..')), $albums), array('onchange' => 'if (this.options[this.selectedIndex].value==\'new\') {'.visual_effect('appear', 'new_album').'} else {'.visual_effect('fade', 'new_album').'}')) ?>
<?php echo input_tag('new_album', '', 'style=display:none;') ?></li>
<li class="column span-28 append-2 right"></li>
<li class="column span-70"><?php echo submit_tag(__('Upload Photo')) ?></li>
</ol>
</form>
</div>