<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Admin'), 'admin/index') ?></li>
<li><?php echo link_to(__('Platform Ads'), 'admin/platformAds') ?></li>
<li class="last"><?php echo !$ad->isNew()?$ad->getTitle():__('New Platform Ad') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='platformAd' && $ad->isNew())?' class="selected"':'' ?>><?php echo link_to(__('New Platform Ad'), 'admin/platformAd') ?></li>
<li<?php echo $sf_context->getActionName()=='platformAds'?' class="selected"':'' ?>><?php echo link_to(__('List Platform Ads'), 'admin/platformAds') ?></li>
</ol>
<?php end_slot() ?>

<div class="blockfield">
<div class="section">
<?php if ($sf_request->hasErrors()): ?>
<?php echo form_errors() ?>
<div class="hrsplit-1"></div>
<?php endif ?>
<?php  echo form_tag('admin/platformAd'.(!$ad->isNew()?'?id='.$ad->getId()."&do=".md5($ad->getTitle().$ad->getId().session_id()):''), 'multipart=true') ?>
<dl class="clear">
    <dt><?php echo emt_label_for('ad_title', __('Title')) ?></dt>
    <dd><?php echo input_tag('ad_title', $sf_params->get('ad_title', $ad->getTitle()), 'maxlength=100') ?></dd>
    <dt><?php echo emt_label_for('ad_message', __('Description')) ?></dt>
    <dd><?php echo input_tag('ad_message', $sf_params->get('ad_message', $ad->getMessage()), 'maxlength=256') ?></dd>
    <dt><?php echo emt_label_for('ad_namespace_id', __('Namespace')) ?></dt>
    <dd><?php echo select_tag('ad_namespace_id', options_for_select(PlatformAdNamespacePeer::getSortedList(), $sf_params->get('ad_namespace_id', $ad->getAdNamespaceId()), array('include_custom' => __('(please select)')))) ?></dd>
    <dt><?php echo emt_label_for('ad_url', __('Target Url')) ?></dt>
    <dd><?php echo emt_label_for("ad_local", checkbox_tag("ad_local", 1, $sf_params->get("ad_local", $ad->getLocal())) . __('Local Page'), 'class=checkbox-label'. ($sf_params->get("ad_local", $ad->getLocal()) == 1 ? ' selected' : '')) ?>
        <div class="hrsplit-1"></div>
        <?php echo input_tag('ad_url', $sf_params->get('ad_url', $ad->getUrl()), 'maxlength=500') ?></dd>
    <dt><?php echo emt_label_for('ad_view_percentage', __('View Percentage (? %)')) ?></dt>
    <dd><?php echo input_tag('ad_view_percentage', $sf_params->get('ad_view_percentage', $ad->getViewPercentage()), 'maxlength=3 length=4') ?></dd>
    <dt><?php echo emt_label_for('ad_click_limit', __('Click Limit (N times)')) ?></dt>
    <dd><?php echo input_tag('ad_click_limit', $sf_params->get('ad_click_limit', $ad->getClickLimit()), 'maxlength=10 length=12') ?></dd>
    <dt><?php echo emt_label_for('ad_view_limit', __('View Limit (N times)')) ?></dt>
    <dd><?php echo input_tag('ad_view_limit', $sf_params->get('ad_view_limit', $ad->getViewLimit()), 'maxlength=10 length=12') ?></dd>
    <dt><?php echo emt_label_for('ad_valid_from', __('Start Date')) ?></dt>
    <dd><?php echo select_date_tag('ad_valid_from', $sf_params->get('ad_valid_from', $ad->getValidFrom('U')), array('year_start' => 2011, 'year_end' => 2020)) ?></dd>
    <dt><?php echo emt_label_for('ad_valid_until', __('End Date')) ?></dt>
    <dd><?php echo select_date_tag('ad_valid_until', $sf_params->get('ad_valid_until', $ad->getValidUntil('U')), array('year_start' => 2011, 'year_end' => 2020)) ?></dd>
    <dt><?php echo emt_label_for('ad_status', __('Status')) ?></dt>
    <dd><?php echo emt_label_for("ad_status1", radiobutton_tag("ad_status", PlatformAdPeer::PAD_STAT_ONLINE, $sf_params->get("ad_status", $ad->getStatus()) === PlatformAdPeer::PAD_STAT_ONLINE, 'id=ad_status1') . __(PlatformAdPeer::$statusNames[PlatformAdPeer::PAD_STAT_ONLINE]), 'class=checkbox-label'. ($ad->getStatus() === PlatformAdPeer::PAD_STAT_ONLINE ? ' selected' : '')) ?>
        <?php echo emt_label_for("ad_status2", radiobutton_tag("ad_status", PlatformAdPeer::PAD_STAT_SUSPENDED, $sf_params->get("ad_status", $ad->getStatus()) === PlatformAdPeer::PAD_STAT_SUSPENDED, 'id=ad_status2') . __(PlatformAdPeer::$statusNames[PlatformAdPeer::PAD_STAT_SUSPENDED]), 'class=checkbox-label'. ($ad->getStatus() === PlatformAdPeer::PAD_STAT_SUSPENDED ? ' selected' : '')) ?></dd>
    <dt><?php echo emt_label_for('ad_type_id', __('File Type')) ?></dt>
    <dd><?php echo select_tag('ad_type_id', options_for_select(PlatformAdPeer::$typeNames, $sf_params->get('ad_type_id', $ad->getTypeId()), array('include_custom' => __('(please select)')))) ?></dd>
    <dt><?php echo emt_label_for('ad_file', __('File')) ?></dt>
    <dd><?php if (count($files = $ad->getFiles())): ?>
            <?php foreach ($files as $file): ?>
            <div class="column span-30 pad-1 middle-content">
            <?php echo link_to(image_tag($file->getThumbnailUri(), 'class=bordered-image'), $file->getUri()) ?><br />
            <?php echo link_to(__('Remove'), 'admin/platformAd', array('query_string' => "id={$ad->getId()}&act=rmf&fid={$file->getGuid()}&do=".md5($ad->getTitle().$ad->getId().session_id()))) ?>&nbsp;|&nbsp;<?php echo link_to(__('View'), $file->getUri(), 'target=blank') ?>
            </div>
            <?php endforeach ?>
            <div class="hrsplit-1"></div>
        <?php endif ?>
        <?php echo input_file_tag('ad_file') ?></dd>
</dl>
    <div class="hrsplit-2"></div>
    <div class="center" style="text-align: center;"><?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;<?php echo link_to(__('Back to Platform Ads List'), 'admin/platformAds') ?></div>
</form>
</div>
</div>
<?php echo javascript_tag("
jQuery('.checkbox-label input').click(function(){ jQuery('input[name=' + jQuery(this).attr('name') + ']').closest('label').removeClass('selected'); if (this.selected || this.checked) jQuery(this).closest('label').addClass('selected');});
") ?>