<?php use_helper('DateForm', 'Object', 'Date') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Media Items'), 'admin/mediaItems') ?></li>
<li class="last"><?php echo !$mediaItem->isNew()?$mediaItem->getFilename():__('New Media Item') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo $sf_context->getActionName()=='mediaItems'?' class="selected"':'' ?>><?php echo link_to(__('List Media Items'), 'admin/mediaItems') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/mediaitem-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/mediaItem'.(!$mediaItem->isNew()?'?id='.$mediaItem->getId()."&do=".md5($mediaItem->getFilename().$mediaItem->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo __('File Name') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo $mediaItem->getFilename() ?></b></li>
    <li class="column span-36 first right"><?php echo __('Size') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo $mediaItem->getFileSize(). ' bytes' ?></b></li>
    <li class="column span-36 first right"><?php echo __('File Folder') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo $mediaItem->getMediaItemFolder()?$mediaItem->getMediaItemFolder()->getName() : __('Not Available') ?></b></li>
    <li class="column span-36 first right"><?php echo __('Uploaded At') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo format_datetime($mediaItem->getCreatedAt('U')) ?></b></li>
    <li class="column span-36 first right"><?php echo __('GUID') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo $mediaItem->getGuid() ?></b></li>
    <li class="column span-36 first right"><?php echo __('Owner') ?></li>
    <li class="column span-92 prepend-2"><?php echo ($mediaItem instanceof Company || $mediaItem instanceof Product) ? link_to($mediaItem->getOwner(), $mediaItem->getOwner()->getProfileUrl()) : $mediaItem->getOwner() ?></li>
    <li class="column span-36 first right"><?php echo __('Owner Type') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo __(PrivacyNodeTypePeer::$typeNames[$mediaItem->getOwnerTypeId()]) ?></b></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('File Storage') ?></h3></li>
    <li class="column span-36 first right"><?php echo __('Large File') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo file_exists($mediaItem->getPath()) ? image_tag($mediaItem->getUri()) . '<br />' . $mediaItem->getPath() : __('Not Available') ?></b></li>
    <li class="column span-36 first right"><?php echo __('Medium File') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo file_exists($mediaItem->getMediumPath()) ? image_tag($mediaItem->getMediumUri()) . '<br />' . $mediaItem->getMediumPath() : __('Not Available') ?></b></li>
    <li class="column span-36 first right"><?php echo __('Thumbnail File') ?></li>
    <li class="column span-92 prepend-2"><b><?php echo file_exists($mediaItem->getThumbnailPath()) ? image_tag($mediaItem->getThumbnailUri()) . '<br />' . $mediaItem->getThumbnailPath() : __('Not Available') ?></b></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('File Modifications') ?></h3></li>
    <li class="column span-5 first"></li>
    <li class="column span-125 attention"><?php echo __('Please handle these tasks with care. Do not click any buttons unless you know what you are doing.') ?></li>
    <li class="column span-36 first right"><?php echo __('Re-make From Large Version') ?></li>
    <li class="column span-92 prepend-2"><?php echo submit_image_tag('layout/button/go.en.png', array('name'=> 'act', 'value' => 'rmk')) ?></li>
    <li class="column span-36 first right"><?php echo __('Replace with New File') ?></li>
    <li class="column span-92 prepend-2"><div class="field"><?php echo input_file_tag('upload_file') ?><br /><?php echo submit_image_tag('layout/button/go.en.png', array('name'=> 'act', 'value' => 'rpl')) ?></div></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo link_to(__('Back to Media Items List'), 'admin/mediaItems') ?></li>
</ol>
</form>
</fieldset>