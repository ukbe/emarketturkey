<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Administrator'), 'admin/index') ?></li>
<li><?php echo link_to(__('Business Sectors'), 'admin/businessSectors') ?></li>
<li class="last"><?php echo !$sector->isNew()?($sector->getName()!=''?$sector->getName():$sector->getName('en')):
                                               __('New Business Sector') ?></li>
</ol>
<?php end_slot() ?> 
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='businessSector' && $sector->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Business Sector'), 'admin/businessSector') ?></li>
<li<?php echo $sf_context->getActionName()=='businessSectors'?' class="selected"':'' ?>><?php echo link_to(__('List Business Sectors'), 'admin/businessSectors') ?></li>
</ol>
<?php end_slot() ?>
<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/admin/business-sector-'.($sector->isNew()?'new':'edit').'.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('admin/businessSector'.(!$sector->isNew()?'?id='.$sector->getId()."&do=".md5($sector->getName().$sector->getId().session_id()):'')) ?>
<ol class="column span-110">
    <li class="column span-36 first right"><?php echo emt_label_for('active', __('Active')) ?></li>
    <li class="column span-72 prepend-2"><?php echo checkbox_tag('active', 1, $sf_params->get('active', $sector->getActive())) ?></li>
    <li class="column span-110">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-105"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php include_partial('admin/sector_lsi_form', array('culture' => 'en', 'sector' => $sector)) ?>
    <?php include_partial('admin/sector_lsi_form', array('culture' => 'tr', 'sector' => $sector)) ?>
    <li class="column span-36 right"></li>
    <li class="column span-72 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Business Sector List'), 'admin/businessSectors', array('query_string' => 'filter_keyword='.$sf_params->get('filter_keyword'))) ?></li>
</ol>
</form>
</fieldset>