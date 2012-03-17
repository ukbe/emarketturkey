<?php use_helper('DateForm', 'Object') ?>
<?php use_helper('EmtAjaxTable') ?>
<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">

<?php include_partial('tasks/toolbar', array('sesuser' => $sesuser)) ?>

    <div class="col_180">

<?php include_partial('leftmenu', array('sesuser' => $sesuser)) ?>

    </div>

    <div class="col_576">
        <h4><?php echo __('Publication Source') ?></h4>
        <div class="box_576 _titleBG_Transparent">

            <fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
            <?php echo image_tag('layout/background/author/source-details.'.$sf_user->getCulture().'.png') ?>
            <div class="hrsplit-1"></div>
            <?php echo form_errors() ?>
            <?php  echo form_tag('author/source'.(!$source->isNew()?'?id='.$source->getId()."&do=".md5($source->getName().$source->getId().session_id()):''), 'multipart=true') ?>
            <ol class="column span-130">
                <li class="column span-36 first right"><?php echo emt_label_for('source_name', __('Source Name')) ?></li>
                <li class="column span-92 prepend-2"><?php echo input_tag('source_name',$sf_params->get('source_name', $source->getName()), 'size=50') ?></li>
                <li class="column span-120">&nbsp;</li>
                <li class="column span-5 first"></li>
                <li class="column span-125"><h3><?php echo __('Language Specific Information') ?></h3></li>
                <?php $languages = $sf_params->get('languages'); $languages = is_array($languages)?$languages:array() ?>
                <?php include_partial('author/source_lsi_form', array('culture' => 'en', 'source' => $source, 'active' => ($source->hasLsiIn('en')||array_search('en', $languages)!==false))) ?>
                <?php include_partial('author/source_lsi_form', array('culture' => 'tr', 'source' => $source, 'active' => ($source->hasLsiIn('tr')||array_search('tr', $languages)!==false))) ?>
            <?php if ($source->isNew()): ?>    
                <li class="column span-5 first"></li>
                <li class="column span-125"><h3><?php echo __('Upload New Photo') ?></h3></li>
                <li class="column span-36 first right"><?php echo emt_label_for('new_photo', __('Select Photo')) ?></li>
                <li class="column span-92 prepend-2"><?php echo input_file_tag('new_photo') ?></li>
                <li class="column span-10 first"></li>
                <li class="column span-120" style="border-bottom: dotted 1px #BEBEBE">
            <?php endif ?>
                <li class="column span-36 right"></li>
                <li class="column span-92 prepend-2"><?php echo submit_tag(__('Save')) ?>&nbsp;<?php echo link_to(__('Back to Sources List'), 'author/sources') ?></li>
            </ol>
            </form>
            </fieldset>
            <?php if (!$source->isNew()): ?>
            <fieldset class="column span-157 prepend-1" style="border: none;padding: 0px;">
            <?php echo image_tag('layout/background/author/source-photos.'.$sf_user->getCulture().'.png') ?>
            <div class="hrsplit-1"></div>
            <?php if (count($photos)): ?>
            <div class="column span-100">
            <?php foreach ($photos as $photo): ?>
            <div class="column span-19 pad-1">
            <?php echo link_to(image_tag($photo->getThumbnailUri()), $photo->getUri()) ?>
            </div>
            <?php endforeach ?>
            </div>
            <?php else: ?>
            <p>
            <?php echo __('No photos uploaded yet.') ?>
            </p>
            <?php endif ?>
            <?php echo form_tag('author/upload?id='.$source->getId()."&do=".md5($source->getName().$source->getId().session_id()), 'multipart=true') ?>
            <ol class="column span-130">
                <li class="column span-5 first"></li>
                <li class="column span-125"><h3><?php echo __('Upload New Photo') ?></h3></li>
                <li class="column span-36 first right"><?php echo emt_label_for('new_photo', __('Select Photo')) ?></li>
                <li class="column span-92 prepend-2"><?php echo input_file_tag('new_photo') ?></li>
                <li class="column span-36 right"></li>
                <li class="column span-92 prepend-2"><?php echo submit_tag(__('Upload Photo')) ?>&nbsp;<?php echo link_to(__('Back to Sources List'), 'author/sources') ?></li>
            </ol>
            </form>
            </fieldset>
            <?php endif ?>
        </div>

    </div>

    <div class="col_180">
    </div>
</div>
