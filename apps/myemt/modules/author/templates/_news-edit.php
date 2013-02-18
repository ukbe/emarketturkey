<?php if ($object->isNew()): ?>
<?php
    $category_id = null;
    $i18ns = array();
?>
<h4><?php echo __('Create News') ?></h4>
<?php else: ?>
<?php
    $i18ns = $object->getExistingI18ns();
    $category_id = array_filter($sf_params->get('category_id', array($object->getCategoryId())));
    $category_id = array_pop($category_id);
?>
<h4><?php echo __('Editing: %1s', array('%1s' => $object->getName())) ?></h4>
<?php endif ?>
<?php $category = PublicationCategoryPeer::retrieveByPK($category_id) ?>
<?php
// Init variables with default values
$categorytree = array();

// Setup category hierarchy
if ($category) {
    $cat_point = $category;
    if (count($childs = $category->getSubCategories(true))) $categorytree[] = array(null => $childs);
    while ($cat_point !== null)
    {
        $parent = $cat_point->getParent();
        if ($parent) $cats = $parent->getSubCategories(true);
        else $cats = PublicationCategoryPeer::getBaseCategories(null, true);
        
        $categorytree[] = array($cat_point->getId() => $cats);
        
        $cat_point = $parent;
    }
}
else {
    $categorytree[] = array("" => PublicationCategoryPeer::getBaseCategories(null, true));
}

?>
<div class="hrsplit-3"></div>
<div id="boxContent">
<?php echo form_errors() ?>
<?php echo form_tag($object->getEditUrl(), 'multipart=true') ?>
<?php echo input_hidden_tag('id', $object->getId()) ?>
<?php echo input_hidden_tag('act', $act) ?>
<dl class="_table">
    <dt class="_req"><?php echo emt_label_for('article_name', __('Article Name')) ?></dt>
    <dd><?php echo input_tag('article_name', $sf_params->get('article_name', $object->getName())) ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 255)) ?></em></dd>
    <dt class="_req"><?php echo emt_label_for('author_id', __('Author')) ?></dt>
    <dd><?php echo $sf_user->hasCredential('editor') ?
                        select_tag('author_id', options_for_select(AuthorPeer::getOrderedNames(true), $sf_params->get('author_id', $object->isNew() ? $sesuser->getAuthor()->getId() : $object->getAuthorId()))) : 
                        input_hidden_tag('author_id', $sf_params->get('author_id', $author->getId())) . $author ?></dd>
    <dt class="_req"><?php echo emt_label_for('source_id', __('Publication Source')) ?></dt>
    <dd><?php echo select_tag('source_id', options_for_select(PublicationSourcePeer::getOrderedNames(true), $sf_params->get('source_id', $object->getSourceId()))) ?></dd>
    <dt class="_req"><?php echo emt_label_for('category_id', __('Publication Category')) ?></dt>
    <dd>
        <ul id="pcat" class="hs-group" style="margin: 0px; padding: 0px;">
            <?php if (count($categorytree)): ?>
            <?php $cat = array_pop($categorytree) ?>
            <?php $parent_key = '' ?>
                <?php while ($cat !== null): ?>
            <li class="hs-part" id="<?php echo "lcategory_id_item" . ($parent_key == '' ? "" : "_") . "$parent_key" ?>">
                <?php $keys = array_keys($cat);
                      $key = array_pop($keys);
                      echo select_tag($parent_key !== '' ? "lcategory_id_$parent_key" : "lcategory_id", options_for_select($cat[$key], $key, array('include_custom' => __('Please Select'), 'class' => 'column first')), array('class' => 'hs-selector', 'name' => count($categorytree) > 0 ? ($parent_key !== '' ? "lcategory_id_.$parent_key" : "lcategory_id") : "category_id")); ?>
            </li>
                <?php $parent_key = $key ?>
                <?php $cat = array_pop($categorytree) ?>
                <?php endwhile ?>
            <?php endif ?>
        </ul>
    </dd>
    <dt><?php echo emt_label_for('article_active', __('Publish')) ?></dt>
    <dd><?php echo checkbox_tag('article_active', 1, $sf_params->get('article_active', $object->getActive())) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Language Specific Details') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("article_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part _wideInput">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("article_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("article_lang_$key", $lang, array('languages' => sfConfig::get('app_i18n_cultures'), 'class' => 'ln-select', 'name' => 'article_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("article_title_$key", __('Title')) ?></dt>
    <dd><?php echo input_tag("article_title_$key",$sf_params->get("article_title_$key", $object->getTitle($lang)), 'size=50 maxlength=255') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 255)) ?></em></dd>
    <dt><?php echo emt_label_for("article_stitle_$key", __('Short Title')) ?></dt>
    <dd><?php echo input_tag("article_stitle_$key",$sf_params->get("article_stitle_$key", $object->getShortTitle($lang)), 'size=50 maxlength=60') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 60)) ?>
            <?php echo __('This information is not required since its used when publishing article on homepage.') ?></em></dd>
    <dt class="_req"><?php echo emt_label_for("article_summary_$key", __('Summary')) ?></dt>
    <dd><?php echo textarea_tag("article_summary_$key", $sf_params->get("article_summary_$key", $object->getSummary($lang)), 'cols=52 rows=3 maxlength=100') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 100)) ?></em></dd>
    <dt class="_req"><?php echo emt_label_for("article_introduction_$key", __('Introduction')) ?></dt>
    <dd><?php echo textarea_tag("article_introduction_$key", $sf_params->get("article_introduction_$key", $object->getIntroduction($lang)), 'cols=52 rows=7 maxlength=512') ?>
        <em class="ln-example"><?php echo __('Maximum %1num characters.', array('%1num' => 512)) ?></em></dd>
    <dt class="_req"><?php echo emt_label_for("article_content_$key", __('Content')) ?></dt>
    <dd><?php echo textarea_tag("article_content_$key", $sf_params->get("article_content_$key", $object->getClob(PublicationI18nPeer::CONTENT, $lang)), 'cols=52 rows=20') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan led add-11px')) ?></dd>
</dl>
<h5 class="clear"><?php echo __('Photos and Other Material') ?></h5>
<dl class="_table whoatt">
    <dt></dt>
    <dd><?php if (count($photos = $object->getPhotos())): ?>
        <?php foreach ($photos as $photo): ?>
        <div>
        <?php echo link_to(image_tag($photo->getThumbnailUri(), 'class=bordered-image'), $photo->getUri(), array('title' => __('Click to view'), 'target' => 'blank')) ?><br />
        </div>
        <?php endforeach ?>
        <div class="hrsplit-1"></div>
        <?php else: ?>
        <?php echo __('No photos') ?>
        <?php endif ?></dd>
    </dd>
</dl>
<dl class="_table">
    <dt><?php echo emt_label_for('article_file', __('Upload File'))?></dt>
    <dd><?php echo input_file_tag('article_file') ?></dd>
</dl>
<div class="hrsplit-3"></div>
<div class="txtCenter">
    <?php echo submit_tag(__('Save'), 'class=green-button') ?>&nbsp;&nbsp;
    <?php echo link_to(__('Cancel'), ($object->isNew() ? "@author-action?action=newss" : $object->getEditUrl('view')).(($filter = $sf_params->get('filter')) ? "&filter=$filter" : ''), 'class=inherit-font bluelink hover') ?></span>
</div>
</form>
<div class="hrsplit-3"></div>
</div>
<?php use_javascript("emt.langform-1.0.js") ?>
<?php use_javascript('emt.hierarchyselector-1.0.js') ?>
<?php use_javascript('jquery.customCheckbox.js') ?>
<?php echo javascript_tag("
    $('#boxContent').langform();

    $('.hs-group').hierarchyselector({
        queryUrl: '".url_for('@author-action?action=publicationCategories')."', 
        paramKey: 'category_id', 
        sendKey: 'pcategory_id',
        isArrayInput: true,
        staticParams: {attr: 'yes'}
    });

    $('dl._table input').customInput();

    $('.whoatt a[title!=\"\"]').tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });
") ?>