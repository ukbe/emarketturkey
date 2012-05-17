<?php use_helper('DateForm', 'Object') ?>

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
<?php include_partial('events/events', array('owner' => $owner, 'route' => $route)) ?>
        </div>
    </div>
    <div class="col_762">
        <div class="box_762 _titleBG_Transparent">
            <section id="boxContent">
                <h4><?php echo ($event->isNew() ? __('Add Event') : __('Edit Event')) ?></h4>
<?php echo form_errors() ?>
<?php echo form_tag($event->isNew()?"$route&action=add" : "$eventroute&action=add", 'novalidate=novalidate enctype=multipart/form-data') ?>
<h5><?php echo __('Event Details') ?></h5>
<?php foreach (($sf_request->getMethod()==sfRequest::POST ? $sf_params->get("event_lang") : (count($i18ns) ? $i18ns : array($sf_user->getCulture()))) as $key => $lang): ?>
<dl class="_table ln-part hide-on-exst-event">
    <dt></dt>
    <dd class="right"><div class="ln-show ghost"><?php echo link_to_function(image_tag('layout/icon/led-icons/cancel.png', array('title' => __('Remove Translation'))), '', "class=ln-removelink") ?></div></dd>
    <dt class="_req"><?php echo emt_label_for("event_lang_$key", __('<span class="ln-remove" style="display: inline;">Default </span>Language')) ?></dt>
    <dd><?php echo select_language_tag("event_lang_$key", $lang, array('languages' => array('tr', 'en'), 'class' => 'ln-select', 'name' => 'event_lang[]', 'include_blank' => true)) ?>
        <span><?php echo image_tag('layout/icon/led-icons/help.png', array('class' => 'frmhelp', 'title' => __('Since eMarketTurkey is a multi-language platform, you should specify the language of the information you provide.<br /><br />You may add information in languages other than Default Language* by clicking "Add Translation" link below.<br /><br />* Information which is provided in Default Language will be viewed for missing translations.'))) ?></span></dd>
    <dt></dt>
    <dd><span class="ln-notify"><?php echo __('<strong>Attention:</strong> The fields below should be filled in <span class="ln-tag">%1</span>', array('%1' => format_language($lang))) ?></span></dd>
    <dt class="_req"><?php echo emt_label_for("event_name_$key", __('Event Name')) ?></dt>
    <dd><?php echo input_tag("event_name_$key",$sf_params->get("event_name_$key", $event->getName($lang)), 'size=50 maxlength=400') ?></dd>
    <dt><?php echo emt_label_for("event_introduction_$key", __('Introduction')) ?></dt>
    <dd><?php echo textarea_tag("event_introduction_$key", $sf_params->get("event_introduction_$key", $event->getIntroduction($lang)), 'cols=52 rows=4 maxlength=1800') ?></dd>
</dl>
<div id="exst-event-block" class="ghost show-on-exst-event"></div>
<?php endforeach ?>
<dl class="_table hide-on-exst-event">
    <dt></dt>
    <dd><?php echo link_to_function(__('Add Translation' ), '', array('class' => 'ln-addlink greenspan  led add-11px')) ?></dd>
    <dt><?php echo emt_label_for("event_type_id", __('Type')) ?></dt>
    <dd class="_req"><?php echo select_tag("event_type_id", options_for_select(EventTypePeer::getOrderedNames(), $sf_params->get('event_type_id', $event->getTypeId()))) ?></dd>
    <dt><?php echo emt_label_for("event_organiser_name", __('Organiser')) ?></dt>
    <dd class="organiser-case-1<?php echo $event->getOrganiser() ? ' ghost' : '' ?>"><?php echo input_tag("event_organiser_name", $sf_params->get('event_organiser_name', $event->getOrganiserName()), array('style' => 'width:200px;', 'maxlength' => 255)) ?></dd>
    <dd class="organiser-case-2<?php echo $event->getOrganiser() ? '' : ' ghost' ?>"><?php echo input_hidden_tag("event_organiser_id", $sf_params->get('event_organiser_id', $event->getOrganiserId())) ?>
                      <?php echo input_hidden_tag("event_organiser_type_id", $sf_params->get('event_organiser_type_id', $event->getOrganiserTypeId())) ?>
                      <div id="organiser-block">
                      <?php if ($event->getOrganiser()): ?>
                      <?php include_partial('events/organiser', array('organiser' => $event->getOrganiser())) ?>
                      <?php endif ?>
                      </div><?php echo link_to_function(__('change'), "$('.organiser-case-2').addClass('ghost');$(this).siblings('input').val('');$('#organiser-block').html('');$('#event_organiser_name').val('');$('.organiser-case-1').removeClass('ghost');") ?></dd>
    <dt><?php echo emt_label_for("event_location_name", __('Location')) ?></dt>
    <dd class="location-case-1<?php echo $event->getPlace() ? ' ghost' : '' ?>"><?php echo input_tag("event_location_name", $sf_params->get('event_location_name', $event->getLocationName()), array('style' => 'width:200px;', 'maxlength' => 255)) ?></dd>
    <dt class="location-case-1<?php echo $event->getPlace() ? ' ghost' : '' ?>"><?php echo emt_label_for('event_location_country', __('Country')) ?></dt>
    <dd class="location-case-1<?php echo $event->getPlace() ? ' ghost' : '' ?>"><?php echo select_country_tag('event_location_country', $sf_params->get('event_location_country', $event->getLocationCountry()), array('class' => 'lc-country', 'include_custom' => __('(optional)'))) ?><span class="error lc-st-error ghost"><?php echo __('Error Occured') ?></span></dd>
    <dt class="location-case-1<?php echo $event->getPlace() ? ' ghost' : '' ?>"><?php echo emt_label_for('event_location_state', __('Region')) ?></dt>
    <dd class="location-case-1<?php echo $event->getPlace() ? ' ghost' : '' ?>"><?php echo select_tag('event_location_state', options_for_select($this->cities = GeonameCityPeer::getCitiesFor($event->getLocationCountry()), $event->getLocationState(), array('include_custom' => __('(optional)'))), array('class' => 'lc-state')) ?></dd>
    <dd class="location-case-2<?php echo $event->getPlace() ? '' : ' ghost' ?>"><?php echo input_hidden_tag("event_place_id", $sf_params->get('event_place_id', $event->getPlaceId())) ?>
                      <div id="location-block">
                      <?php if ($event->getPlace()): ?>
                      <?php include_partial('events/place', array('place' => $event->getPlace())) ?>
                      <?php endif ?>
                      </div><?php echo link_to_function(__('change'), "$('.location-case-2').addClass('ghost');$(this).siblings('input').val('');$('#location-block').html('');$('#event_location_name').val('');$('.location-case-1').removeClass('ghost');") ?></dd>
</dl>
<h5 class="clear hide-on-exst-event"><?php echo __('Event Schedule') ?></h5>
<dl class="_table hide-on-exst-event">
    <dt><?php echo emt_label_for("event_start_date", __('Start Date')) ?></dt>
    <dd class="_req"><?php echo input_tag("event_start_date", $sf_params->get('event_start_date', $event->getTimeScheme() ? $event->getTimeScheme()->getStartDate('d M Y') : null), array('style' => 'width:100px;')) ?>
        <?php echo select_hour_tag('event_start_time_hour', $sf_params->get('event_start_time_hour', $event->getTimeScheme() ? $event->getTimeScheme()->getStartDate('H') : null)) ?>
        <?php echo select_minute_tag('event_start_time_min', $sf_params->get('event_start_time_min', $event->getTimeScheme() ? $event->getTimeScheme()->getStartDate('i') : null)) ?>
        <?php echo input_hidden_tag('event_start') ?></dd>
    <dt><?php echo emt_label_for("event_start_date", __('End Date')) ?></dt>
    <dd><?php echo input_tag("event_end_date", $sf_params->get('event_end_date', $event->getTimeScheme() ? $event->getTimeScheme()->getEndDate('d M Y') : null), array('style' => 'width:100px;')) ?>
        <?php echo select_hour_tag('event_end_time_hour', $sf_params->get('event_end_time_hour', $event->getTimeScheme() ? $event->getTimeScheme()->getEndDate('H') : null)) ?>
        <?php echo select_minute_tag('event_end_time_min', $sf_params->get('event_end_time_min', $event->getTimeScheme() ? $event->getTimeScheme()->getEndDate('i') : null)) ?>
        <?php echo input_hidden_tag('event_end') ?></dd>
    <dt><?php echo emt_label_for("event_repeat_x", __('Repeat Event')) ?></dt>
    <dd><?php echo select_tag('event_repeat', options_for_select(array('0' => __('No'), '1' => __('Yes'))), $sf_params->get('event_repeat', $event->getTimeScheme() ? $event->getTimeScheme()->getRepeatTypeId() : null) > 0 ? 1 : 0) ?>
        <?php echo select_tag('event_repeat_type_id', options_for_select(TimeSchemePeer::$typeNames, $sf_params->get('event_repeat_type_id', $event->getTimeScheme() ? $event->getTimeScheme()->getRepeatTypeId() : null))) ?></dd>
</dl>
<h5 class="clear hide-on-exst-event" id="upload-photo"><?php echo __('Event Photo') ?></h5>
<dl class="_table hide-on-exst-event">
    <dt></dt>
    <dd><?php if (count($photos)): ?>
        <?php foreach ($photos as $photo): ?>
        <?php echo link_to(image_tag($photo->getThumbnailUri()), "$eventroute&action=gallery&pid={$photo->getId()}") ?>
        <?php endforeach ?>
        <?php else: ?>
        <?php echo __('No photos') ?>
        <?php endif ?></dd>
    </dd>
    <dt><?php echo emt_label_for("event_photo", __('Select File')) ?></dt>
    <dd><?php echo input_file_tag("event_photo", '') ?></dd>
    <dt></dt>
    <dd><?php echo submit_tag($event->isNew() ? __('Save Event') : __('Save Changes'), 'class=green-button') ?></dd>
</dl>
<h5 class="clear ghost show-on-exst-event"><?php echo __('Event Participation') ?></h5>
<dl class="_table ghost show-on-exst-event">
    <dt><?php echo emt_label_for("event_attending", __('Are you attending?')) ?></dt>
    <dd>
        <?php echo radiobutton_tag('event_attending', 0, false, array('id' => 'event_attending_no')) ?>
        <?php echo emt_label_for('event_attending_no', __('No')) ?>
        <?php echo radiobutton_tag('event_attending', 1, false, array('id' => 'event_attending_yes')) ?>
        <?php echo emt_label_for('event_attending_yes', __('Yes')) ?>
        <?php echo input_hidden_tag('event_selected', '') ?>
        </dd>
    <dt></dt>
    <dd><?php echo submit_tag(__('Save Attendance'), 'class=green-button') ?></dd>
</dl>
</form>
            </section>
        </div>
    </div>
</div>
<?php
$data = sfDateTimeFormatInfo::getInstance('tr');

$json = json_encode(array('months' => implode(',', $data->getMonthNames()), 
                          'shortMonths' => implode(',', $data->getAbbreviatedMonthNames()), 
                          'days' => implode(',', $data->getDayNames()),
                          'shortDays' => implode(',', $data->getAbbreviatedDayNames())
                    )
        );
$jurl = "http://tx.geek.emt/en/default/boxtest";
  ?>
<?php echo javascript_tag("
$(function() {

    $('#boxContent').langform({afterAdd: function(){\$('.frmhelp').tooltip();}});

    $('dl._table input').customInput();

    $.tools.dateinput.localize('{$sf_user->getCulture()}', $json);
    $('#event_start_date').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#event_start').val(isoDate);
    },
    min: -1, max: '2023-01-01', firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});

    $('#event_end_date').dateinput({
    change: function() {
        var isoDate = this.getValue('yyyy-mm-dd');
        $('#event_end').val(isoDate);
    },
    min: -1, max: '2023-01-01', firstDay: 1, format: 'dd mmmm yyyy', lang: '{$sf_user->getCulture()}'}).css({width: '150px'});

    $('#event_repeat').branch({map: {1: '#event_repeat_type_id'}})

    $('#event_name_0').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: 'http://my.geek.emt/en/events/query',
                dataType: 'jsonp',
                data: {
                    maxRows: 12,
                    typ: 'evn',
                    keyword: request.term
                },
                success: function( data ) {
                    response( $.map( data.ITEMS, function( item ) {
                        return {
                            label: item.NAME + ', ' + item.STARTDATE,
                            desc: item.ORGANISER + ', ' + item.LOCATION,
                            value: item.NAME,
                            id: item.ID
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            $.ajax({
                url: 'http://my.geek.emt/en/events/query',
                dataType: 'html',
                data: {
                    id: ui.item.id
                },
                success: function( data ) {
                    $('#exst-event-block').html(data);
                    $('#event_selected').val(ui.item.value);
                }
            });
            $('.hide-on-exst-event').addClass('ghost');
            $('.show-on-exst-event').removeClass('ghost');
        },
        open: function() {
            $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
        },
        close: function() {
            $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
        }
    })
    .data( 'autocomplete' )._renderItem = function( ul, item ) {
        return $( '<li></li>' )
            .data( 'item.autocomplete', item )
            .append( '<a>' + item.label + '<br>' + item.desc + '</a>' )
            .appendTo( ul );
    };    

    $('#event_organiser_name').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: 'http://my.geek.emt/en/events/query',
                dataType: 'jsonp',
                data: {
                    maxRows: 12,
                    typ: 'org',
                    keyword: request.term
                },
                success: function( data ) {
                    response( $.map( data.ITEMS, function( item ) {
                        return {
                            label: item.NAME,
                            desc: item.CATEGORY,
                            value: item.NAME,
                            id: item.ID,
                            type: item.TYPE
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            $.ajax({
                url: 'http://my.geek.emt/en/events/query',
                dataType: 'html',
                data: {
                    org: ui.item.id,
                    typ: ui.item.type
                },
                success: function( data ) {
                    $('#organiser-block').html(data);
                    $('#event_organiser_id').val(ui.item.value);
                    $('#event_organiser_type_id').val(ui.item.type);
                }
            });
            $('.organiser-case-1').addClass('ghost');
            $('.organiser-case-2').removeClass('ghost');
        },
        open: function() {
            $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
        },
        close: function() {
            $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
        }
    })
    .data( 'autocomplete' )._renderItem = function( ul, item ) {
        return $( '<li></li>' )
            .data( 'item.autocomplete', item )
            .append( '<a>' + item.label + '<br>' + item.desc + '</a>' )
            .appendTo( ul );
    };    

    $('#event_location_name').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: 'http://my.geek.emt/en/events/query',
                dataType: 'jsonp',
                data: {
                    maxRows: 12,
                    typ: 'plc',
                    keyword: request.term
                },
                success: function( data ) {
                    response( $.map( data.ITEMS, function( item ) {
                        return {
                            label: item.NAME,
                            desc: item.STATE + ', ' + item.COUNTRY,
                            value: item.NAME,
                            id: item.ID,
                            type: item.CATEGORY
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            $.ajax({
                url: 'http://my.geek.emt/en/events/query',
                dataType: 'html',
                data: {
                    plc: ui.item.id
                },
                success: function( data ) {
                    $('#location-block').html(data);
                    $('#event_place_id').val(ui.item.value);
                }
            });
            $('.location-case-1').addClass('ghost');
            $('.location-case-2').removeClass('ghost');
        },
        open: function() {
            $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
        },
        close: function() {
            $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
        }
    })
    .data( 'autocomplete' )._renderItem = function( ul, item ) {
        return $( '<li></li>' )
            .data( 'item.autocomplete', item )
            .append( '<a>' + item.label + '<br>' + item.desc + '</a>' )
            .appendTo( ul );
    };

    $('#event_location_country').change(function(){
        var t = $(this);
        var s = $('#'+t.attr('id').replace('_country', '_state'));
        if (this.value != '')
        {
            t.attr('disabled', true);
            s.attr('disabled', true);
            $.getJSON('".url_for('profile/locationQuery')."', {cc: t.val()}, 
                function(d){
                    s.find(\"option[value!='']\").remove();
                    $(d).each(function(g, i){s.append($('<option value='+i.ID+'>'+i.NAME+'</option>'));});
                }
            )
            .error(function(e,str){etag.removeClass('ghost');})
            .complete(function(){t.attr('disabled', false);s.attr('disabled', false);});
        }
        else if (this.value == '')
        {
            s.empty();
        }
    });
});
") ?>