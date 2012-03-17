    <div id="search_bar"<?php echo isset($open) && $open ? ' class="open"' : '' ?>>
        <?php echo form_tag('@jobsearch', 'method=get id=search-jobs') ?>
        <?php echo input_hidden_tag('do', 'search') ?>
        <table id="search_bar_left">
            <tr>
                <td><?php $countries = isset($params['country']) ? $params['country'] : array() ?>
                    <?php echo link_to_function("<span></span>" . (count($countries) > 1 ? __('%1d Locations', array('%1d' => count($countries))) : (count($countries) == 0 ? __('No Locations Selected') : CountryPeer::retrieveByISO($countries[0]))), '', 'id=geo_select') ?>
                </td>
                <td class="keyword"><?php echo emt_label_for('job_keyword', __('Search Keyword')) ?>
                    <div>
                    <?php echo input_tag('job_keyword', $sf_params->get('job_keyword', __('search keyword')), array('title' => 'Enter keywords to search in job posts.', 'onfocus' => "if (this.value=='".__('search keyword')."') this.value=''", 'onblur' => "if (this.value=='') this.value='".__('search keyword')."'"))?>
                    </div>
                </td>
                <td><?php echo submit_tag(__('Search'), array('title' => __('Search in Job Posts'), 'id' => 'search_submit'))?>
                </td>
                <td><?php echo emt_label_for('period', __('Post Period')) ?>
                    <span id="period"></span> <span id="periodUpdate"></span>
                </td>
            </tr>
        </table>

        <fieldset id="search_bar_right">

                    <span id="quickJobAccess"></span>
                    <span id="detailedJobSearch"></span>

        </fieldset>

        <fieldset id="advanced-search">
            <div class="adv-content">
                <div class="divide">
                    <div id="select-country-div" class="block">
                        <h3><?php echo __('Select Country :') ?></h3>
                        <dl class="four_columns" style="height: 9em; overflow: hidden; overflow-y: scroll;">
                        <dt class="ghost"><?php echo __('Select Country')?></dt>
                        <?php foreach (CountryPeer::getOrderedNames(true) as $iso => $cnt): ?>
                        <dd><?php echo checkbox_tag("cnt[]", $iso, in_array($iso, $sf_params->get("cnt", $countries)), "id=cnt_$iso") ?>
                            <?php echo emt_label_for("cnt_$iso", $cnt) ?></dd>
                        <?php endforeach ?>
                        </dl>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="divide two_columns">
                    <div><div class="block">
                        <h3><?php echo __('Position Level :') ?></h3>
                        <div class="three_columns">
                        <?php foreach (JobGradePeer::getSortedList() as $id => $grd): ?>
                            <?php echo checkbox_tag("grd[]", $id, in_array($id, $sf_params->get("grd", array())), "id=grd_$id") ?>
                            <?php echo emt_label_for("grd_$id", $grd) ?>
                            <?php endforeach ?></div>
                        <div class="clear"></div>
                    </div></div>
                    <div><div class="block">
                        <h3><?php echo __('Education Level :') ?></h3>
                        <div class="three_columns">
                            <?php foreach (ResumeSchoolDegreePeer::getSortedList(null, true, ResumeSchoolDegreePeer::RSC_DEG_SORT_LEVEL_SEQ) as $key => $label): ?>
                            <?php echo checkbox_tag("edu[]", $key, in_array($key, $sf_params->get("edu", array())), "id=edu_$key") ?>
                            <?php echo emt_label_for("edu_$key", $label) ?>
                            <?php endforeach ?></div>
                        <div class="clear"></div>
                    </div></div>
                </div>
                <div class="divide four_columns">
                    <div><div class="block">
                        <h3><?php echo __('Working Schedule :') ?></h3>
                        <div class="two_columns">
                        <?php foreach (JobWorkingSchemePeer::getSortedList() as $key => $schm): ?>
                            <?php echo checkbox_tag("sch[]", $key, in_array($key, $sf_params->get("sch", array())), "id=sch_$key") ?>
                            <?php echo emt_label_for("sch_$key", $schm) ?>
                            <?php endforeach ?></div>
                        <div class="clear"></div>
                    </div></div>
                    <div><div class="block">
                        <h3><?php echo __('Military Service :') ?></h3>
                        <div>
                        <?php foreach (ResumePeer::$mservLabels as $key => $label): ?>
                            <?php echo checkbox_tag("mserv[]", $key, in_array($key, $sf_params->get("mserv", array())), "id=mserv_$key") ?>
                            <?php echo emt_label_for("mserv_$key", __($label)) ?>
                            <?php endforeach ?></div>
                        <div class="clear"></div>
                    </div></div>
                    <div><div class="block">
                        <h3><?php echo __('Gender :') ?></h3>
                        <div>
                        <?php foreach (ResumePeer::$genderOptLabels as $key => $label): ?>
                            <?php echo checkbox_tag("gen[]", $key, in_array($key, $sf_params->get("gen", array())), "id=gen_$key") ?>
                            <?php echo emt_label_for("gen_$key", __($label)) ?>
                            <?php endforeach ?></div>
                        <div class="clear"></div>
                    </div></div>
                    <div><div class="block">
                        <h3><?php echo __('Special Cases :') ?></h3>
                        <div class="two_columns">
                        <?php foreach (JobSpecialCasesPeer::getSpecialCases() as $case): ?>
                            <?php echo checkbox_tag("scs[]", $case->getId(), in_array($case->getId(), $sf_params->get("scs", array())), "id=scs_{$case->getId()}") ?>
                            <?php echo emt_label_for("scs_{$case->getId()}", $case->getName()) ?>
                            <?php endforeach ?></div>
                        <div class="clear"></div>
                    </div></div>
                </div>
            </div>
        </fieldset>
        </form>
    </div> <!--// end of div#search_bar //-->

<?php use_javascript("jquery.customCheckbox.js") ?>
<?php use_javascript("jquery.ninjaui.min.js") ?>
<?php use_javascript("sprintf-0.7.js") ?>
<?php use_stylesheet("ninjaui.css") ?>
<?php echo javascript_tag("
$(function(){

    $('.adv-content input').customInput();

    $('#period').ninjaSliderCreate({
      names:['".__('Posts of Today')."', '".__('%1 Days', array('%1' => 3))."', '".__('%1 Days', array('%1' => 7))."', '".__('%1 Days', array('%1' => 15))."', '".__('%1 Days', array('%1' => 30))."', '".__('%1 Days', array('%1' => 60))."', '".__('All Job Posts')."'],
      onSelect:function(){
        $('#period').ninjaSliderUpdate();
      },
      onStop:function(){ // optional JavaScript function
      },
      selected:".(isset($params['period']) ? $params['period'] : 360).",
      title:'".__('Job Post Period')."',
      values:[1, 3, 7, 15, 30, 60, 360],
      width:110
    });
    
    $('body').data('openJobSearch', function(){
        $('#search_bar').addClass('advon');
        $('#advanced-search').slideDown('fast');
    });
    $('body').data('closeJobSearch', function(){
        $('#advanced-search').slideUp('fast', function(){ $('#search_bar').removeClass('advon'); });
    });
    /*
    $('#quickJobAccess').ninjaButtonCreate({
      icon:'target', // optional image before title
      onSelect:function(){
      },
      title:'".__('Quick ')."'
    });
    */
    
    $('#detailedJobSearch').ninjaButtonCreate({
      icon:'target',
      onSelect: $('body').data('openJobSearch'),
      onDeselect: $('body').data('closeJobSearch'),
      title:'".__('Advanced Search')."',
      select: true
    });
    
    var updcnt = function(){ var pickl = $(\"input[name='cnt[]']:checked\"); if (pickl.length > 1) { $('#geo_select').html('<span></span>'+sprintf('".__('%1d Locations')."', pickl.length)); $('#geo_select').attr('title', pickl.map(function(){ return $(\"label[for='cnt_\"+$(this).val()+\"']\").text(); }).get().join(' | ')); } else if (pickl.length == 1) $('#geo_select').html('<span></span>'+$(\"label[for='cnt_\"+pickl.val()+\"']\").text()); else $('#geo_select').html('<span></span>".__('No Locations Selected')."'); };
    updcnt();
    $(\"input[name='cnt[]']\").click(updcnt);

    $('.hr-job-search').click(function(){ $('#detailedJobSearch').click(); $('html, body').animate({scrollTop: $('#subNav').offset().top - 20}, 500, null); return false; });
    
    $('#search-jobs').submit(function(){ if ($(this).find('#job_keyword').val()=='".__('search keyword')."') $(this).find('#job_keyword').val(''); });

    if ($('#search_bar.open').length > 0) $('#detailedJobSearch').click();
});
") ?>