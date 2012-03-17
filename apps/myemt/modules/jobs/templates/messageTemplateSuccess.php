<?php slot('subNav') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/subNav', array('company' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/subNav', array('group' => $owner)) ?>
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_USER): ?>
<?php endif ?>
<?php end_slot() ?>
<div class="col_948">
    <div class="col_180">
        <div class="box_180">
<?php include_partial('jobs/jobs', array('owner' => $owner, 'route' => $route)) ?>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section id="boxContent">
                <h4 style="border-bottom: none;">
                    <?php echo __('Message Template: <span class="t_green">%1</span>', array('%1' => $template->getName())) ?>
                </h4>
                <?php echo form_tag("$route&action=messageTemplate". ($template->isNew() ? '&act=new' : "&id={$template->getId()}")) ?>
                <?php echo form_errors() ?>
                <?php $statTypes = $profile->getAvailableTemplateTypesFor($template->getTypeId());
                      $statTypes['standalone'] = __('Standalone') ?>
                <dl class="_table">
                    <dt><?php echo emt_label_for("template_name", __('Template Name')) ?></dt>
                    <dd><?php echo input_tag("template_name", $sf_params->get('template_name', $template->getName())) ?></dd>
                    <dt><?php echo emt_label_for("template_type_id", __('Status Type')) ?></dt>
                    <dd><?php echo select_tag("template_type_id", options_for_select($statTypes, $sf_params->get('template_type_id', $template->getTypeId()), array('include_custom' => __('Please Select')))) ?></dd>
                </dl>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("template_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("template_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("template_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'template_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("template_title_$key", __('Message Title')) ?></dt>
    <dd><?php echo input_tag("template_title_$key", $sf_params->get("template_title_$key", $template->getTitle($lang)), 'size=50 maxlength=400') ?></dd>
    <dt class="_req"><?php echo emt_label_for("template_content_$key", __('Message')) ?></dt>
    <dd><?php echo textarea_tag("template_content_$key", $sf_params->get("template_content_$key", $template->getClob(JobMessageTemplateI18nPeer::CONTENT, $lang)), 'cols=52 rows=10 maxlength=1800') ?></dd>
</dl>
<?php endforeach ?>
<dl class="_table">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan  led add-11px')) ?></dd>
    <dt></dt>
<?php if ($template->isNew()): ?>
    <dd><?php echo submit_tag(__('Save Template'), 'class=green-button') ?></dd>
<?php else: ?>
    <dd><?php echo submit_tag(__('Save Changes'), 'class=green-button') ?></dd>
<?php endif ?>
</dl>
                </form>
            </section>
        </div>
    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_Red">
        <h3><?php echo __('Formatting Guide:') ?></h3>
        <div class="smalltext">
            <p><?php echo __('You may use built-in variables to include some dependent information like "Job Post Title" or "Applicant Name" in your message templates.') ?></p>
            <p><?php echo __('Please refer to list below:') ?></p>
            <dl>
                <dt class="t_orange"><b><?php echo '#uname' ?></b></dt>
                <dd><?php echo __("Applicant's name and lastname.") ?><em class="ln-example margin-t0"><?php echo __('ex: Tom Markus') ?></em></dd>
                <dt class="t_orange"><b><?php echo '#joblink' ?></b></dt>
                <dd><?php echo __("Link to related job post.") ?><em class="ln-example margin-t0">ex: <?php echo link_to(__('Marketing Manager'), '@homepage', 'class=t_blue') ?></em></dd>
                <dt class="t_orange"><b><?php echo '#jobtitle' ?></b></dt>
                <dd><?php echo __("Title of job post without a link.") ?><em class="ln-example margin-t0"><?php echo __('ex: Marketing Manager') ?></em></dd>
                <dt class="t_orange"><b><?php echo '#oname' ?></b></dt>
                <dd><?php echo __("Organisation name which is set in HR Profile.") ?><em class="ln-example margin-t0"><?php echo __('ex: Best Sellers Inc.') ?></em></dd>
            </dl>
        </div>
        </div>
    </div>
    
</div>
<?php echo javascript_tag("
$(function() {
    $('#boxContent').langform({afterAdd: function(){\$('.frmhelp').tooltip();}});
});
") ?>