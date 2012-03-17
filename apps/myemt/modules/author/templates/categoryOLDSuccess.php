<?php use_helper('DateForm', 'Object') ?>
<?php slot('mappath') ?>
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tasks'), 'tasks/index') ?></li>
<li><?php echo link_to(__('Author'), 'author/index') ?></li>
<li><?php echo link_to(__('Publication Categories'), 'author/categories') ?></li>
<li class="last"><?php echo !$category->isNew()?$category->getName():__('New Payment Term') ?></li>
</ol>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='category' && $category->isNew())?' class="selected"':'' ?>><?php echo link_to(__('Add Publication Category'), 'author/category') ?></li>
<li<?php echo $sf_context->getActionName()=='categories'?' class="selected"':'' ?>><?php echo link_to(__('List Publication Categories'), 'author/categories') ?></li>
</ol>
<?php end_slot() ?>

<fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
<?php echo image_tag('layout/background/author/pubcategory-details.'.$sf_user->getCulture().'.png') ?>
<div class="hrsplit-1"></div>
<?php echo form_errors() ?>
<?php  echo form_tag('author/category'.(!$category->isNew()?'?id='.$category->getId()."&do=".md5($category->getName().$category->getId().session_id()):''), 'multipart=true') ?>
<ol class="column span-130">
    <li class="column span-36 first right"><?php echo emt_label_for('pubcategory_parent_id', __('Parent Category')) ?></li>
    <li class="column span-92 prepend-2"><?php echo input_tag('pubcategory_parent_id',$sf_params->get('pubcategory_parent_id', $category->getParentId()), 'size=20') ?></li>
    <li class="column span-36 first right"><?php echo emt_label_for('pubcategory_active', __('Active')) ?></li>
    <li class="column span-92 prepend-2"><?php echo checkbox_tag('pubcategory_active', 1, $sf_params->get('pubcategory_active', $category->getActive())) ?></li>
    <li class="column span-120">&nbsp;</li>
    <li class="column span-5 first"></li>
    <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
    <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
    <?php include_partial('author/category_lsi_form', array('culture' => 'en', 'category' => $category, 'active' => ($category->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
    <?php include_partial('author/category_lsi_form', array('culture' => 'tr', 'category' => $category, 'active' => ($category->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
    <li class="column span-36 right"></li>
    <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Publication Categories List'), 'author/categories') ?></li>
</ol>
</form>
</fieldset>