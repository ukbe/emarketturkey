<?php echo form_tag("$route&action=messageTemplates", array('id' => 'templatefrm')) ?>
<?php echo input_hidden_tag('act', '') ?>
<table class="data-table extended">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Status Type') ?></th>
        </tr>
    </thead>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $template): ?>
<?php $url = $template->getEditUrl() ?>
    <tr>
        <td><?php echo $template->getHrProfileId() ? checkbox_tag('templates[]', $template->getId()) : image_tag('layout/icon/b-icon.png', array('title' => __('Built-in Template'))) ?></td>
        <td><?php echo $url ? link_to($template->getName(), $url) . ($template->getTypeId() ? ' <span class="t_grey">(*)</span>' : '') : $template->getName() ?>
            <div class="t_grey">
            <?php $larr = array() ?>
            <?php foreach ($template->getExistingI18ns() as $lang): ?>
            <?php $larr[] = format_language($lang) ?>
            <?php endforeach ?>
            <?php echo implode(', ', $larr) ?>
            </div>
            <div class="greyback"><?php echo str_replace(array("\n", "#uname", "#oname", "#joblink") , array("<br />", '<span class="t_orange">'.__('APPLICANT NAME').'</span>', '<strong>'.$profile->getName().'</strong>', '<span class="t_orange">'.__('JOB POST LINK').'</span>'), $template->getClob(JobMessageTemplateI18nPeer::CONTENT, $template->hasLsiIn($sf_user->getCulture()) ? null : $template->getDefaultLang())) ?></div>
            </td>
        <td><?php echo $url ? link_to($template->getTypeId() ? UserJobPeer::$statusLabels[$template->getTypeId()] : __('Standalone'), $url) : ($template->getTypeId() ? UserJobPeer::$statusLabels[$template->getTypeId()] : __('Standalone')) ?></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>
<div class="hrsplit-2"></div>
<ul class="sepdot">
<li><?php echo link_to_function(__('Select All'), "$('input[type=checkbox][name=templates[]]').attr('checked', 'checked')") ?></li>
<li><?php echo link_to_function(__('De-select All'), "$('input[type=checkbox][name=templates[]]').attr('checked', false)") ?></li>
<li><?php echo link_to_function(__('Remove Selected'), "$('#act').val('rm');$('form.templatefrm')[0].post();", 'class=act cancel-13px') ?></li>
<li><?php echo link_to(__('Add Template'), "$route&action=messageTemplate&act=new", 'class=act plus-13px') ?></li>
</ul>
</form>
<div class="clear"></div>
<div class="ln-example">(*) <?php echo __('This template overrides built-in template.') ?></div>