<?php slot('subNav') ?>
<?php include_partial('global/subNav_tx') ?>
<?php end_slot() ?>

<div class="col_948">

<div class="col_657 clear _center">
<div class="box_657">
<h4>
<div class="_right t_orange"><? echo __('Step 2') ?></div>
<?php echo __('Apply for Translator Account') ?></h4>
<div class="pad-3 _noBorder">
<div class="ghost">
<table>
    <tbody id="new-lang-tmpl">
        <tr>
            <th>#langname# <?php echo input_hidden_tag('langs[]', '#lang#') ?></th>
            <td><?php echo checkbox_tag('lang-#lang#-native', 1, false, array('onclick' => "if ($(this).attr('checked')) $(this).closest('tr').find('select').attr('disabled', true); else $(this).closest('tr').find('select').attr('disabled', false);")) ?></td>
            <td><?php echo select_tag('lang-#lang#-read', options_for_select(array(1 => __('Low'), 2=> __('Fair'), 3 => __('High')), null, array('include_blank' => true))) ?></td>
            <td><?php echo select_tag('lang-#lang#-write', options_for_select(array(1 => __('Low'), 2=> __('Fair'), 3 => __('High')), null, array('include_blank' => true))) ?></td>
            <td><?php echo select_tag('lang-#lang#-speak', options_for_select(array(1 => __('Low'), 2=> __('Fair'), 3 => __('High')), null, array('include_blank' => true))) ?></td>
            <td><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png'), "$('#translator_add > option[value=\"'+$(this).closest('tr').find('input[type=hidden][name=\"langs[]\"]').val()+'\"]').attr('disabled', false); $(this).closest('tr').remove(); if ($('.lang-table').find('input[name=\"langs[]\"]').length == 0) { $('.lang-table tr.no-items').show(); $('.lang-table tr.header').hide(); } ", 'class=removelink') ?></td>
        </tr>
    </tbody>
</table>
</div>
<?php echo form_tag('@tr-apply') ?> <?php echo input_hidden_tag('step', 2) ?>
<?php if ($sesuser->isNew()): ?> <?php else: ?> <?php echo __('Please provide additional information for Translator profile:') ?>
<div class="hrsplit-3"></div>
<?php echo form_errors() ?> <?php if (isset($error)): ?>
<div class="t_red"><?php echo __($error) ?></div>
<div class="hrsplit-3"></div>
<?php endif ?>
<dl class="_table">
    <dt><?php echo emt_label_for('account', __('Account Holder')) ?></dt>
    <dd class="t_larger"><span class="t_green t_bold"><?php echo $account ?></span>&nbsp;&nbsp;<?php echo link_to(__('(change)'), "@tr-apply", 'class=inherit-font bluelink hover') ?>
    <div class="hrsplit-3"></div>
    </dd>
    <dt class="_req"><?php echo emt_label_for('translator_introduction', __('Introduction')) ?></dt>
    <dd><?php echo textarea_tag('translator_introduction', $sf_params->get('translator_introduction'), array('style' => 'width: 400px;', 'cols' => 50, 'rows' => 6)) ?>
    <em class="ln-example"><?php echo __('Describe your translation services clearly.<br /> This information will be displayed to visitors on Translator profile page.') ?></em></dd>
</dl>
<h4><?php echo __('Languages') ?></h4>
<?php $langs = $sf_params->get('langs') ?>
<table class="lang-table">
    <tr class="header<?php echo count($langs) ? '' : ' ghost' ?>">
        <td></td>
        <td><?php echo __('Native') ?></td>
        <td><?php echo __('Reading') ?></td>
        <td><?php echo __('Writing') ?></td>
        <td><?php echo __('Speaking') ?></td>
        <td></td>
    </tr>
    <tr class="no-items<?php echo count($langs) ? ' ghost' : '' ?>">
        <td colspan="4"><?php echo __('No Languages Selected') ?></td>
    </tr>
</table>
<dl class="_table">
    <dt class="add-lang-link ghost">
    <?php if (is_array($sf_params->get('langs')) && count($sf_params->get('langs'))): ?>
<table>
    <tbody id="new-lang-tmpl">
    <?php foreach ($sf_params->get('langs') as $lang): ?>
        <tr>
            <th>#langname# <?php echo input_hidden_tag('langs[]', '#lang#') ?></th>
            <td><?php echo checkbox_tag('lang-#lang#-native', 1, false, array('onclick' => "if ($(this).attr('checked')) $(this).closest('tr').find('select').attr('disabled', true); else $(this).closest('tr').find('select').attr('disabled', false);")) ?></td>
            <td><?php echo select_tag('lang-#lang#-read', options_for_select(array(1 => __('Low'), 2=> __('Fair'), 3 => __('High')), null, array('include_blank' => true))) ?></td>
            <td><?php echo select_tag('lang-#lang#-write', options_for_select(array(1 => __('Low'), 2=> __('Fair'), 3 => __('High')), null, array('include_blank' => true))) ?></td>
            <td><?php echo select_tag('lang-#lang#-speak', options_for_select(array(1 => __('Low'), 2=> __('Fair'), 3 => __('High')), null, array('include_blank' => true))) ?></td>
            <td><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png'), "$('#translator_add > option[value=\"'+$(this).closest('tr').find('input[type=hidden][name=\"langs[]\"]').val()+'\"]').attr('disabled', false); $(this).closest('tr').remove(); if ($('.lang-table').find('input[name=\"langs[]\"]').length == 0) { $('.lang-table tr.no-items').show(); $('.lang-table tr.header').hide(); } ", 'class=removelink') ?></td>
        </tr>
    <?php endif ?>
    </tbody>
</table>
    <?php endif ?>
        </dt>
    <dd class="add-lang-link ghost"><?php echo link_to_function(__('Add Language'), "$('.add-lang-link').slideUp('fast'); $('.add-lang').slideDown('fast');", 'class=ln-addlink greenspan led add-11px') ?></dd>
    <dt class="_req add-lang"><?php echo emt_label_for('translator_add', __('Select Language')) ?></dt>
    <dd>
    <div class="fieldset-div pad-3 add-lang"
        style="border: solid 1px #cad9de; background-color: #f3f7f9; border-radius: 3px;">
        <?php echo select_language_tag('translator_add', $sf_params->get('translator_add'), array('style' => 'width:400px;', 'size' => 10, 'multiple' => 'multiple')) ?>
    <div class="pad-t2 pad-b2"><?php echo link_to_function(__('Add Selected'), "if ($('#translator_add').find('option:selected').length > 0) { $('.lang-table tr.no-items').hide(); $('.lang-table tr.header').show(); } else { $('.lang-table tr.no-items').show(); $('.lang-table tr.header').hide();  } $('#translator_add').find('option:selected').each(function(i,j){ var html = $('#new-lang-tmpl').clone(); html.find('select[id*=\"#lang#\"]').each(function(){ var att = $(this).attr('id').replace('#lang#', $(j).val()); $(this).attr('id', att); $(this).attr('name', att); }); html.html(html.html().replace('#langname#', $(this).text())).find('input[type=hidden][name=\"langs[]\"]').val($(this).val());
                        $(html.html()).appendTo($('.lang-table')); $(this).attr('selected', false); $(this).attr('disabled', 'disabled'); }); $('.add-lang').slideUp('fast'); $('.add-lang-link').slideDown('fast');", 'class=action-button') ?>&nbsp;&nbsp;
    <?php echo link_to_function(__('Cancel'), "$('.add-lang').slideUp('fast'); $('.add-lang-link').slideDown('fast');", 'class=inherit-font bluelink hover') ?>
    </div>
    <em class="ln-example"><?php echo $account->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? __('Select one or more languages which your company provides translation services.') : __('Select one or more languages which you provide translation services.') ?></em>
    </div>
    </dd>
</dl>
<?php /* ?>
<h4><?php echo __('Translation Couples') ?></h4>
<table class="trans-table">
    <tr class="header">
        <td><?php echo __('Source') ?></td>
        <td></td>
        <td><?php echo __('Target') ?></td>
        <td><?php echo __('Simultaneous Translation?') ?></td>
    </tr>
    <tr class="bi-dir">
        <td>#source#</td>
        <td class="symbol"></td>
        <td>#target#</td>
        <td><?php echo checkbox_tag('simul[]') ?>
            <?php echo select_tag('simulevel[]', options_for_select(array(1 => __('Low'), 2=> __('Fair'), 3 => __('High')), null, array('include_blank' => true))) ?></td>
    </tr>
    <tr class="">
        <td>#source#</td>
        <td class="symbol"></td>
        <td>#target#</td>
        <td><?php  ?></td>
    </tr>
</table>
<?php */ ?>
<div class="clear margin-t2 _right"><?php echo submit_tag(__('Apply'), 'class=dark-button') ?>
</div>
    <?php endif ?>
</form>
</div>
</div>

</div>

</div>
