<?php use_helper('EmtAjaxTable', 'Object', 'DateForm') ?>
<?php slot('pagetop') ?>
<?php if ($otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
<?php include_partial('company/company_pagetop', array('company' => $owner)) ?> 
<?php elseif ($otyp == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
<?php include_partial('group/group_pagetop', array('group' => $owner)) ?> 
<?php endif ?>
<?php end_slot() ?>
<?php slot('pageheader', __('Post Job')) ?>
<?php slot('pageactions', link_to(__('Cancel'), "@company-jobs-action?action=home&hash=$own", 'class=cancel-13px')) ?>
<?php slot('leftcolumn') ?>
<?php include_partial('company/leftmenu', array('company' => $owner)) ?>
<?php end_slot() ?>
<div class="pad-1">
<div class="blockfield">
<div class="section">
<h2><span class="circle green">1</span><?php echo __('Provide Job Details') ?></h2>
<div class="hrsplit-1"></div>
<?php echo form_tag("@company-jobs-action?action=post&hash=$own") ?>
    <dl class="ln-part clear">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost" style="position: absolute; top: 10px; right: 10px;"><?php echo link_to_function(__('remove'), '', "class=ln-removelink") ?></div></dd>
    <dt><?php echo emt_label_for('job_lang', __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag('job_lang', $sf_user->getCulture(), array('languages' => sfConfig::get('app_i18n_cultures'), 'class' => 'ln-select', 'include_blank' => true)) ?></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<span class="redspan">Attention:</span> The fields below should be filled in <span class="ln-tag">English</span>') ?></span></dd>
    <dt><?php echo emt_label_for('job_title', __('Job Title')) ?></dt>
    <dd><?php echo input_tag('job_title', $sf_params->get('job_title'), 'maxlength=250') ?></dd>
    <dt><?php echo emt_label_for('job_description', __('Description')) ?></dt>
    <dd><?php echo textarea_tag('job_description', $sf_params->get('job_description'), 'maxlength=10000 rows=5') ?></dd>
    <dt><?php echo emt_label_for('job_responsibilities', __('Responsibilities')) ?></dt>
    <dd><?php echo textarea_tag('job_responsibilities', $sf_params->get('job_responsibilities'), 'maxlength=10000 rows=5') ?></dd>
    <dt><?php echo emt_label_for('job_requirements', __('Requirements')) ?></dt>
    <dd><?php echo textarea_tag('job_requirements', $sf_params->get('job_requirements'), 'maxlength=10000 rows=5') ?></dd>
    </dl>
    <dl class="clear">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'act greenspan plus-13px ln-addlink')) ?></dd>
    <dt><?php echo emt_label_for('job_function', __('Job Function')) ?></dt>
    <dd><?php echo select_tag('job_function', options_for_select(JobFunctionPeer::getSortedList(), $sf_params->get('job_function'), array('include_custom' => __('(optional)')))) ?></dd>
    <dt><?php echo emt_label_for('job_position_level', __('Position Level')) ?></dt>
    <dd><?php echo select_tag('job_position_level', options_for_select(JobGradePeer::getSortedList(), $sf_params->get('job_position_level'), array('include_custom' => __('(optional)')))) ?></dd>
    <dt><?php echo emt_label_for('job_working_scheme', __('Attendence')) ?></dt>
    <dd><?php echo select_tag('job_working_scheme', options_for_select(JobWorkingSchemePeer::getSortedList(), $sf_params->get('job_working_scheme'), array('include_custom' => __('(optional)')))) ?></dd>
    <?php $exp = array(1 => "1 " . __('Year')); for ($i=2; $i<11; $i++) $exp[$i] = "$i " . __('Years'); $exp['11'] = __('1..5 Years'); $exp['12'] = __('6..10 Years'); $exp['13'] = __('11..15 Years'); $exp['14'] = __('16..20 Years');  ?>
    <dt><?php echo emt_label_for('job_experience', __('Experience')) ?></dt>
    <dd><?php echo select_tag('job_experience', options_for_select($exp, $sf_params->get('job_experience'), array('include_custom' => __('(optional)')))) ?></dd>
    <dt><?php echo emt_label_for('job_education_level', __('Education Level')) ?></dt>
    <dd><?php echo select_tag('job_education_level', options_for_select(ResumeSchoolDegreePeer::getSortedList(), $sf_params->get('job_education_level'), array('include_custom' => __('(optional)')))) ?></dd>
    <dt><?php echo emt_label_for('job_sex', __('Sex')) ?></dt>
    <dd><?php echo select_tag('job_sex', options_for_select(array(0 => __('Any'), 1 => __('Male'), 2 => __('Female')), $sf_params->get('job_sex'))) ?></dd>
    <dt><?php echo emt_label_for('job_special_case', __('Special Cases')) ?></dt>
    <dd><?php foreach (JobSpecialCasesPeer::getSpecialCases() as $case): ?>
        <?php echo emt_label_for("job_special_case[{$case->getId()}]", checkbox_tag("job_special_case[{$case->getId()}]", 1, $sf_params->get("job_special_case[{$case->getId()}]")) . $case->getName(), 'class=checkbox-label') ?>
        <?php endforeach ?></dd>
    </dl>
    <div class="hrsplit-2"></div>
<h2><span class="circle green">2</span><?php echo __('Location and Number of Staff') ?></h2>
    <div class="hrsplit-1"></div>
    <dl class="lc-part clear">
    <dt><?php echo emt_label_for('job_country', __('Country')) ?></dt>
    <dd><?php echo select_country_tag('job_country', $sf_params->get('job_location', $owner->getContact()->getWorkAddress()->getCountry()), array('class' => 'lc-country', 'include_blank' => true)) ?></dd>
    <dt><?php echo emt_label_for('job_state', __('Region')) ?></dt>
    <dd><?php echo select_tag('job_state', options_for_select($this->cities = GeonameCityPeer::getCitiesFor($owner->getContact()->getWorkAddress()->getCountry()), $owner->getContact()->getWorkAddress()->getState(), array('include_custom' => __('select state/province'))), array('class' => 'lc-state')) ?></dd>
    <dt><?php echo emt_label_for('job_personel', __('Number of Staff')) ?></dt>
    <dd><?php echo input_tag('job_personel', $sf_params->get('job_personel'), array('class' => 'lc-personel', 'style' => 'width: 50px;')) ?></dd>
    <dt class="ghost"></dt>
    <dd class="lc-view ghost"><ul>
            <li class="pin"></li>
            <li><div class="personel"><span class="lc-personel"></span>&nbsp;<?php echo __('personel') ?></div><span class="lc-state"></span><span class="lc-country"></span></li>
            <li class="lc-removelink"><?php echo link_to_function('&nbsp;', '', 'class=lc-removelink') ?></li>
        </ul></dd>
    </dl>
    <dl class="clear">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Another Location' ), '', array('class' => 'act greenspan plus-13px lc-addlink')) ?></dd>
    </dl>
    <div class="hrsplit-3"></div>
    <div class="center-block right"><?php echo submit_tag(__('Continue'), 'class=green-button') ?></div>
</form>
</div>
</div>
</div>
<?php echo javascript_tag("
jQuery.fn.langform = function(){
    var o = jQuery(this[0]);
    jQuery.extend(o, {availangs: {'tr': [0, 'Turkish'], 'en': [0, 'English']}, blocks: o.find('dl.ln-part'), addlink: o.find('a.ln-addlink'), lastblock: o.find('dl.ln-part:last').next(), emptydl: o.find('dl:first').clone(),
        setupBlock: function(dl){
            jQuery.extend(dl, {select: jQuery(dl).find('select.ln-select'), lang: '', removelink: jQuery(dl).find('.ln-removelink'), notify: jQuery(dl).find('.ln-notify'), 
                remove: function(){
                        var offs = dl.prev().offset().top;
                        if (this.lang != '') o.availangs[this.lang][0] = 0;
                        o.blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) jQuery(op).removeAttr('disabled');});}});
                        x = jQuery.inArray(this, o.blocks);
                        o.blocks.splice(x);
                        jQuery(this).remove();
                        jQuery('html, body').animate({scrollTop: offs-100}, 500);
                }
            });
            jQuery.extend(dl.select, {kk: dl, tag: jQuery(dl).find('span.ln-tag')});
            dl.select.change(function(){
                if (this.value != '' && o.availangs[this.value][0] == 0 &&  dl.lang != this.value)
                {
                    if (dl.lang in o.availangs) o.availangs[dl.lang][0] = 0;
                    o.blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) jQuery(op).removeAttr('disabled');});}});
                    p = this.value;
                    dl.lang = this.value;
                    o.availangs[dl.lang][0] = 1;
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    o.blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option').each(function(i,op){if (op.value==dl.lang) jQuery(op).attr('disabled', 'disabled');});}});
                    dl.notify.removeClass('ghost');
                }
                else if (this.value == '')
                {
                    if (dl.lang != '') o.availangs[dl.lang][0] = 0;
                    o.blocks.each(function(i, bl){if (bl.lang!=dl.lang){bl.select.find('option:disabled').each(function(i,op){if (op.value==dl.lang) jQuery(op).removeAttr('disabled');});}});
                    dl.select.tag.html(dl.select.find('option:selected').text());
                    dl.lang = '';
                    dl.notify.addClass('ghost');
                }
                else {
                    return false;
                }
            });
            dl.select.change();
            dl.removelink.click(function(){
                dl.remove();
                if (Object.keys(o.availangs).length > o.blocks.length) o.addlink.show();
            });
            if (jQuery.inArray(dl, o.blocks) < 0) o.blocks.push(dl);
            x = jQuery.inArray(dl, o.blocks);
            jQuery(dl).find('input, select, textarea').each(function(i, m){jQuery(m).attr('id', jQuery(m).attr('id') + '_' + x);});
            jQuery(dl).find('input, select, textarea').each(function(i, m){jQuery(m).attr('name', jQuery(m).attr('name') + '_' + x);});
            jQuery(dl).find('label').each(function(i, m){jQuery(m).attr('for', jQuery(m).attr('for') + '_' + x);});
        },
        retblock: function(lng){
            o.blocks.each(function(){if (this.lang == lng) return this;});
        }
    });
    o.emptydl.find('select.ln-select option:selected').removeAttr('selected');
    o.blocks.each(function(i,pl){ o.setupBlock(pl); });
    
    o.addlink.click(function(){
        var pl = o.emptydl.clone();
        o.setupBlock(pl);
        pl.find('.ln-remove').remove();
        pl.find('.ln-show').removeClass('ghost');
        pl.select.find('option').each(function(i,el){if (el.value in o.availangs && o.availangs[el.value][0]==1) jQuery(el).attr('disabled', 'disabled');});
        pl.insertBefore(o.lastblock);
        jQuery('html, body').animate({scrollTop: pl.offset().top-100}, 500);
        if (o.blocks.length == Object.keys(o.availangs).length) this.hide();        
    });
};
jQuery('.blockfield').langform();

jQuery.fn.locform = function(){
    var o = jQuery(this[0]);
    jQuery.extend(o, {locations: [], blocks: o.find('dl.lc-part'), addlink: o.find('a.lc-addlink'), lastblock: o.find('dl.lc-part:last').next(), emptydl: o.find('dl.lc-part:first').clone(),
        setupBlock: function(dl){
            jQuery.extend(dl, {index: '', select_cn: jQuery(dl).find('select.lc-country'), select_st: jQuery(dl).find('select.lc-state'), input_pr: jQuery(dl).find('input.lc-personel'), country: '', state: '', personel: '', removelink: jQuery(dl).find('.lc-removelink'), 
                remove: function(){
                        alert(dl.state);
                        if (dl.state == '') {alert('m');alert(o.blocks.length);o.blocks.each(function(i, bl){alert(bl.country+'!='+dl.country);if (bl.country!=dl.country){alert('t');bl.select_cn.find('option[value='+dl.country+']:disabled').removeAttr('disabled');}});}
                        o.blocks.splice(dl.index);
                        jQuery(this).remove();
                },
                ident: function(){ return [this.country, this.state, this.personel]; },
                isValid: function(){ return (this.country!='' && this.personel != ''); },
                switch: function(){ jQuery(dl).addClass('view'); },
                setCountry: function(v){dl.select_cn.find('option[value='+v+']').attr('selected', 'selected'); dl.country=v;},
                setState: function(v){dl.select_st.find('option[value='+v+']').attr('selected', 'selected'); dl.state=v;}
            });
            jQuery.extend(dl.select_cn, {tag: jQuery(dl).find('span.lc-country')});
            dl.select_cn.change(function(){
                if (this.value != '' && dl.country != this.value)
                {
                    p = this.value;
                    o.blocks.each(function(i, bl){if (bl.country == dl.country){bl.select_st.find('option[value='+dl.state+']').removeAttr('disabled');}});
                    dl.country = this.value;
                    dl.state = '';
                    dl.select_cn.tag.html(dl.select_cn.find('option:selected').text());
                    dl.select_st.tag.html('');
                    dl.select_st.find('option:selected').removeAttr('selected');
                    o.blocks.each(function(i, bl){if (bl.country != dl.country){bl.select_cn.find('option[value='+dl.country+']').attr('disabled', 'disabled');}});
                    o.blocks.each(function(i, bl){if (bl.country == dl.country){dl.select_st.find('option[value='+bl.state+']').attr('disabled', 'disabled');}});
                    o.blocks.each(function(i, bl){if (bl.country == dl.country && bl.state!=''){bl.css('background-color: red;');}});
                }
                else if (this.value == '')
                {
                    o.blocks.each(function(i, bl){if (bl.country!=dl.country){bl.select_cn.find('option[value='+dl.country+']:disabled').removeAttr('disabled');}});
                    dl.select_cn.tag.html('');
                    dl.select_st.tag.html(dl.select_st.find('option:selected').text());
                    dl.country = '';
                    dl.state = '';
                }
                else {
                    return false;
                }
            });
            jQuery.extend(dl.select_st, {tag: jQuery(dl).find('span.lc-state')});
            dl.select_st.change(function(){
                if (this.value != '' && dl.state != this.value)
                {
                    o.blocks.each(function(i, bl){if (bl.country == dl.country && bl.state != dl.state){bl.select_st.find('option[value='+dl.state+']:disabled').removeAttr('disabled');}});
                    o.blocks.each(function(i, bl){if (bl.country != dl.country){bl.select_cn.find('option[value='+dl.country+']:disabled').removeAttr('disabled');}});
                    dl.state = this.value;
                    dl.select_st.tag.html(dl.select_st.find('option:selected').text());
                    o.blocks.each(function(i, bl){if (bl.country == dl.country && bl.state!=dl.state){bl.select_st.find('option[value='+dl.state+']').attr('disabled', 'disabled');}});
                }
                else if (this.value == '')
                {
                    o.blocks.each(function(i, bl){if (bl.country == dl.country && bl.state!=dl.state){bl.select_st.find('option[value='+dl.state+']:disabled').removeAttr('disabled');}});
                    o.blocks.each(function(i, bl){if (bl.country != dl.country){bl.select_cn.find('option[value='+dl.country+']').attr('disabled', 'disabled');}});
                    dl.select_st.tag.html('');
                    dl.state = '';
                }
                else {
                    return false;

                }
            });
            jQuery.extend(dl.input_pr, {tag: jQuery(dl).find('span.lc-personel')});
            dl.input_pr.change(function(){
                if (this.value != '' && dl.personel != this.value)
                {
                    dl.personel = this.value;
                    o.locations[dl.index] = dl.ident();
                    dl.input_pr.tag.html(dl.input_pr.val());
                }
                else {
                    return false;
                }
            });
            dl.removelink.click(function(){
                dl.remove();
            });
            if (jQuery.inArray(dl, o.blocks) < 0) o.blocks.push(dl);
            dl.index = jQuery.inArray(dl, o.blocks);
            dl.select_cn.change();
            jQuery(dl).find('input, select, textarea').each(function(i, m){jQuery(m).attr('id', jQuery(m).attr('id') + '_' + dl.index);});
            jQuery(dl).find('input, select, textarea').each(function(i, m){jQuery(m).attr('name', jQuery(m).attr('name') + '_' + dl.index);});
            jQuery(dl).find('label').each(function(i, m){jQuery(m).attr('for', jQuery(m).attr('for') + '_' + dl.index);});
        },
        retblock: function(cnt, st){
            o.blocks.each(function(){if ((this.country == cnt) && (this.state == st)) return this;});
        }
    });
    o.emptydl.find('select.lc-country option:selected').removeAttr('selected');
    o.emptydl.find('select.lc-state option:selected').removeAttr('selected');
    o.blocks.each(function(i,pl){ o.setupBlock(pl); });
    
    o.addlink.click(function(){
        o.blocks.each(function(){if (this.isValid()) this.switch();});
        var pl = o.emptydl.clone();
        o.setupBlock(pl);
        pl.find('.lc-remove').remove();
        pl.find('.lc-show').removeClass('ghost');
        o.blocks.each(function(i, bl){alert(bl.country);if (bl.country != '' && bl.state == '') pl.select_cn.find('option[value='+bl.country+']').attr('disabled', 'disabled');});
        pl.insertBefore(o.lastblock);
        jQuery('html, body').animate({scrollTop: pl.offset().top-100}, 500);
    });
};
jQuery('.blockfield').locform();

jQuery('.checkbox-label input').click(function(){ if (this.checked) jQuery(this).closest('label').addClass('selected'); else jQuery(this).closest('label').removeClass('selected');});
") ?>