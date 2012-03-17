<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Media') => '@group-manage?action=media&stripped_name='.$group->getStrippedName(),
                                                                  __('Group Logo') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuMedia', array('group' => $group)) ?>
<?php end_slot() ?>
<div class="column span-107 pad-1 append-1">
<h2><?php echo __('Group Logo') ?></h2>
<br />
<?php if ($logo): ?>
<?php echo image_tag($logo->getUri()) ?>
<br /><br />
<?php echo __('If you would like to change your logo please click the "Upload New" button below.') ?>
<br /><br />
<?php echo link_to_function(image_tag('layout/button/uploadnew.'.$sf_user->getCulture().'.png'), visual_effect('fade', 'uploadbutton', array('duration' => 0.1)).visual_effect('appear', 'upload-form', array('duration' => 0.3))."if ($('error')) $('error').hide();", array('id' => 'uploadbutton', 'style' => form_errors()?'display: none':'')) ?>
<?php else: ?>
<?php echo __('You have not uploaded a logo for your group, yet.') ?>
<br /><br />
<?php echo __('If you would like to upload your logo please click the "Upload" button below.') ?>
<br /><br />
<?php echo link_to_function(image_tag('layout/button/upload.'.$sf_user->getCulture().'.png'), visual_effect('fade', 'uploadbutton', array('duration' => 0.1)).visual_effect('appear', 'upload-form', array('duration' => 0.3))."if ($('error')) $('error').hide();", array('id' => 'uploadbutton', 'style' => form_errors()?'display: none':'')) ?>
<?php endif ?>
<div class="hrsplit-2"></div>
<div id="upload-form"<?php if (!form_errors()): ?> style="display:none;"<?php endif ?>>
<?php if (form_errors()): ?>
<?php echo form_errors() ?>
<div class="hrsplit-2"></div>
<?php endif ?>
<?php echo form_tag('@group-manage?action=logo&stripped_name='.$group->getStrippedName(), 'multipart=true') ?>
<?php echo input_hidden_tag('id', $group->getId()) ?>
<?php echo input_file_tag('grouplogo') ?>
<?php echo submit_tag(__('Upload')) ?><br /><br /><?php echo link_to_function(image_tag('layout/button/cancelupload.'.$sf_user->getCulture().'.png'), visual_effect('fade', 'upload-form', array('duration' => 0.1)).visual_effect('appear', 'uploadbutton', array('duration' => 0.3))) ?>
</form>
</div>