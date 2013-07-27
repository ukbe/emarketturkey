<?php slot('subNav') ?>
<?php include_partial('profile/subNav', array('sesuser' => $sesuser)) ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_630">
        <div class="box_630 _titleBG_Transparent">
            <div class="_noBorder post-box">
                <ul class="selectorlist">
                <li><?php echo __('Share :') ?></li>
                <li id="p-status" class="selected"><?php echo link_to_function(image_tag('layout/wall/post-status.png').'<span>'.__('Status').'</span>','') ?></li>
                <li id="p-link"><?php echo link_to_function(image_tag('layout/wall/post-link.png').'<span>'.__('Link').'</span>','') ?></li>
                <li id="p-video"><?php echo link_to_function(image_tag('layout/wall/post-video.png').'<span>'.__('Video').'</span>','') ?></li>
                <li id="p-location"><?php echo link_to_function(image_tag('layout/wall/post-location.png').'<span>'.__('Location').'</span>','') ?></li>
                <?php /* ?>
                <li id="p-job"><?php echo link_to_function(image_tag('layout/wall/post-job.png').'<span>'.__('Job').'</span>','') ?></li>
                <li id="p-opportunity"><?php echo link_to_function(image_tag('layout/wall/post-opportunity.png').'<span>'.__('Opportunity').'</span>','') ?></li>
                <?php */ ?>
                </ul>
                <div id="target-box">
                <div class="p-status">
                <?php echo form_tag('profile/post', 'id=status-form') ?>
                <?php echo input_hidden_tag('type', PrivacyNodeTypePeer::PR_NTYP_POST_STATUS) ?>
                <div class="bordered">
                <?php echo textarea_tag('status-message', '', array('rows' => 1, 'class' => 'watermark', 'alt' => __('Type your status message ..'))) ?>
                </div>
                <div class="out-p-status p-status-post _right ghost-sub" style="margin-top: 5px;">
                <?php echo submit_tag(__('Share'), 'class=action-button') ?>
                </div>
                </form>
                <div id="clonediv" class="clone-textarea ghost" style="word-wrap: break-word;"></div>
                </div>
                <div class="p-link ghost bordered">
                <?php echo form_tag('profile/post') ?>
                <?php echo input_hidden_tag('type', PrivacyNodeTypePeer::PR_NTYP_POST_LINK) ?>
                <table cellspacing="0" cellpadding="5" border="0" width="100%" style="vertical-align: middle; text-align: left;">
                <tr>
                <td style="width: 480px;"><div class="pad-1"><?php echo input_tag('plink', '', array('class' => 'watermark', 'alt' => 'http://')) ?></div></td>
                <td><div class="pad-1"><?php echo submit_tag(__('Share'), 'class=action-button') ?></div></td>
                </tr>
                </table>
                </form>
                </div>
                <div class="p-video ghost bordered status-select">
                <?php echo form_tag('profile/post') ?>
                <?php echo input_hidden_tag('type', PrivacyNodeTypePeer::PR_NTYP_POST_VIDEO) ?>
                <?php echo input_hidden_tag('video-id', '') ?>
                <?php echo input_hidden_tag('video-service-id', '') ?>
                <table id="select-video" cellspacing="0" cellpadding="5" border="0" width="100%" style="vertical-align: middle; text-align: left;">
                <tr>
                <td style="width: 480px;"><div class="pad-1"><?php echo input_tag('pvideo', '', array('class' => 'watermark', 'alt' => 'http://', 'onfocus' => "$('#video-error').hide();")) ?></div></td>
                <td><div class="pad-1"><?php echo link_to_function(__('Share'), '', 'id=get-video-link class=action-button') ?></div></td>
                </tr>
                </table>
                <div id="video-error" class="inherit-font t_red txtCenter pad-1 ghost"><?php echo __('Something went wrong while retrieving video information. Sorry!') ?></div>
                <table id="save-video" cellspacing="0" cellpadding="0" border="0" width="100%" style="vertical-align: middle; text-align: center;">
                <tr>
                <td style="width: 200px"><div id="video-thumb">
                    </div>
                    <?php echo input_hidden_tag('_ref', url_for('@homepage', true)) ?></td>
                <td style="text-align: left;"><div class="pad-3">
                    <strong id="video-title-label"><?php echo "###" ?></strong>
                    <?php echo input_hidden_tag('video-title', '') ?>
                    <div class="hrsplit-1"></div>
                    <?php echo textarea_tag('video-comment', '', array('class' => 'watermark', 'style' => 'width:400px;', 'rows' => 2, 'alt' => __('Comments'))) ?>
                    <div class="hrsplit-1"></div>
                    <?php echo submit_tag(__('Post Video'), 'class=action-button') ?>
                    </div></td>
                </tr>
                </table>
                </form>
                </div>
                <div class="p-location ghost bordered status-select" style="padding: 10px;">
                <?php echo form_tag('profile/post') ?>
                <?php echo input_hidden_tag('type', PrivacyNodeTypePeer::PR_NTYP_POST_LOCATION) ?>
                <table id="select-location" cellspacing="0" cellpadding="0" border="0" width="100%" style="vertical-align: middle; text-align: center;">
                <tr>
                <td style="width: 50%;"><div class="pad-3">
                    <?php echo __('You may automatically check-in your location.')?>
                    <div class="hrsplit-1"></div>
                    <?php echo link_to_function(__('Check-in My Location'), '', 'id=get-location-link class=action-button') ?>
                    </div></td>
                <td class="or-splitter"><span><?php echo __('or') ?></span></td>
                <td style="width: 50%;"><div class="pad-3">
                    <?php echo __('You may manually set your location.')?>
                    <div class="hrsplit-1"></div>
                    <?php echo input_tag('location-manual', '', 'style=width:200px;') ?>
<?php echo javascript_tag("
$('#location-manual').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: 'http://ws.geonames.org/searchJSON',
                    dataType: 'jsonp',
                    data: {
                        featureClass: 'P',
                        style: 'full',
                        maxRows: 12,
                        name_startsWith: request.term
                    },
                    success: function( data ) {
                        response( $.map( data.geonames, function( item ) {
                            return {
                                label: item.name + (item.adminName1 ? ', ' + item.adminName1 : '') + ', ' + item.countryName,
                                value: item.name,
                                latitude: item.lat,
                                longitude: item.lng
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                emtProcessLocation({ 'coords' : { 'longitude' : ui.item.longitude, 'latitude' : ui.item.latitude }});
            },
            open: function() {
                $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );
            },
            close: function() {
                $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-all' );
            }
        });
") ?>                    
                    </div></td>
                </tr>
                </table>
                <table id="save-location" cellspacing="0" cellpadding="0" border="0" width="100%" style="vertical-align: middle; text-align: center;">
                <tr>
                <td style="width: 200px"><div id="location-map">
                    </div>
                    <?php echo input_hidden_tag('location_data', '') ?>
                    <?php echo input_hidden_tag('_ref', url_for('@homepage', true)) ?></td>
                <td style="text-align: left;"><div class="pad-3">
                    <strong id="location-label"><?php echo "###" ?></strong>
                    <div class="hrsplit-1"></div>
                    <?php echo textarea_tag('location-comment', '', array('class' => 'watermark', 'style' => 'width:400px;', 'rows' => 2, 'alt' => __('Comments'))) ?>
                    <div class="hrsplit-1"></div>
                    <?php echo submit_tag(__('Share My Location'), 'class=action-button') ?>
                    </div></td>
                </tr>
                </table>
                </form>
                </div>
                </div>
            
            </div>
        </div>
        <div class="box_630 _titleBG_Transparent">
            <div class="_noBorder">
                <h3 class="margin-t0" style="font: bold 13px 'trebuchet ms'; color: #4D4D4D; border-bottom: solid 2px #F1F1F1;padding: 3px 5px;margin-bottom: 10px;"><?php echo __('Updates') ?>&nbsp;<?php echo link_to_function(__('(refresh)'), "$('.activity').update(0);", 'class=action') ?></h3>
                <?php include_partial('network/network_activity', array('activities' => $activities)) ?>
            </div>
        </div>
    </div>
    <div class="col_312">
        <div class="box_312 _border_Shadowed">
            <h3><span class="_right"><?php echo link_to(__('Add Company'), '@register-comp', 'class=action') ?></span>
                <span class="blue"><?php echo __('Companies') ?></span></h3>
            <div>
            <?php if (count($companies)): ?>
                <div class="col_assets margin-t2">
                    <dl>
                    <?php foreach ($companies as $company): ?>
                        <dt><?php echo link_to(image_tag($company->getProfilePictureUri()), $company->getProfileUrl()) ?></dt>
                        <dd>
                            <?php echo link_to($company->getName(), $company->getProfileUrl(), 'class=t_black') ?>
                            <div class="asset-name"><?php echo $company->getBusinessSector() ?></div>
                            <div class="asset-name t_black"><?php echo $company->getBusinessType() ?></div>
                            <?php echo link_to(__('Manage'), '@company-manage?hash='.$company->getHash(), 'class=bluelink hover') ?>
                            </dd>
                    <?php endforeach ?>
                    </dl>
                </div>
            <?php else: ?>
                <?php echo __('A large number of companies use eMarketTurkey B2B for their business operations.') ?>
                <div class="hrsplit-1"></div>
                <?php echo __('Register your company and get listed on eMarketTurkey B2B Directory.') ?>
                <div class="hrsplit-1"></div>
                <?php echo link_to(__('Register Your Company'), '@register-comp') ?>
            <?php endif ?>
            </div>
        </div>
        <div class="box_312 _border_Shadowed">
            <h3><span class="_right"><?php echo link_to(__('Add Group'), '@group-start', 'class=action') ?></span>
                <span class="blue"><?php echo __('Groups') ?></span></h3>
            <div>
            <?php if (count($groups)): ?>
                <div class="col_assets margin-t2">
                    <dl>
                    <?php foreach ($groups as $group): ?>
                        <dt><?php echo link_to(image_tag($group->getProfilePictureUri()), $group->getProfileUrl()) ?></dt>
                        <dd>
                            <?php echo link_to($group, $group->getProfileUrl(), 'class=t_black') ?>
                            <div class="asset-name"><?php echo $group->getGroupType() ?></div>
                            <?php echo link_to(__('Manage'), '@group-manage?action=manage&hash='.$group->getHash()) ?>
                            </dd>
                    <?php endforeach ?>
                    </dl>
                </div>
            <?php else: ?>
                <?php echo __('Business groups, alumni groups or even social organisations get connected on eMarketTurkey Community.') ?>
                <div class="hrsplit-1"></div>
                <?php echo __('You can start your own group and invite friends in your network.') ?>
                <div class="hrsplit-1"></div>
                <?php echo link_to(__('Start Your Group'), '@group-start') ?>
            <?php endif ?>
            </div>
        </div>
        <?php $advises = $sesuser->getSuggestedFriendsPager(null, true, 3) ?>
        <?php if (count($advises)): ?>
        <div class="box_312 _border_Shadowed">
            <h3><span class="_right"><?php echo link_to(__('See All'), '@camp.pymk') ?></span>
                <span class="blue"><?php echo __('People You May Know') ?></span>
            </h3>
            <div>
            <?php $myfriends = $sesuser->getFriends() ?>
                <div class="col_assets margin-t2">
                    <dl>
                    <?php foreach ($advises as $friend): ?>
                        <dt><?php echo link_to(image_tag($friend->getProfilePictureUri()), $friend->getProfileUrl()) ?></dt>
                        <dd>
                            <?php echo link_to($friend, $friend->getProfileUrl(), 'class=t_black') ?>
                            <?php $hisfriends = $friend->getFriends();
                                  $comm = array_intersect($hisfriends, $myfriends);
                                  $fcount = count($comm);
                            ?>
                            <div class="asset-name"><?php echo link_to_function(format_number_choice(__('[0]No common friends|[1]%1 friend in common|(1,+Inf]%1 friends in common'), 
                             array('%1' => $fcount), $fcount), '', array('id' => 'cmf-'.($friend->getId()))) ?></div>
                            <?php if (!$friend->isFriendsWith($sesuser->getId()) && $sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $friend)) 
                                    echo link_to(__('Connect'), "@connect-user?user={$friend->getPlug()}", "class=action-button ajax-enabled id=conus-{$friend->getPlug()}") ?>
                            <div id="cmf-<?php echo $friend->getId() ?>" class="ghost">
                            <table cellspacing="0" cellpadding="5" border="0" width="100%" class="network-list">
                                <?php foreach ($comm as $com): ?>
                                <tr>
                                <td><?php echo image_tag($com->getProfilePictureUri()) ?></td>
                                <td width="90%" class="name">
                                <?php echo $com ?>
                                </td>
                                </tr>
                                <?php endforeach ?>
                            </table>
                            </div>
                            </dd>
                    <?php endforeach ?>
                    </dl>
                </div>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>

<style>
    .post-box ul.selectorlist
    {
        margin: 0px;
        padding: 0px;
        font: 11px arial;
    }
    .post-box ul.selectorlist li
    {
        float: left;
        height: 28px;
        background-image: none;
        margin: 0px;
    }
    .post-box ul.selectorlist li.selected
    {
        background: url(/images/layout/wall/post-indicator.png) no-repeat 11px bottom;
    }
    .post-box ul.selectorlist a
    {
        display: inline-block;
        border: none;
        text-decoration: none;
        color: #4772A7;
        font: 11px tahoma;
        vertical-align: middle;
        padding: 2px 2px;
        margin: 0px 8px;
        line-height: 13px;
    }
    .post-box ul.selectorlist img
    {
        border: none;
        margin: 0px 4px 0px 0px;
        vertical-align: middle;
    }
    .post-box ul.selectorlist a span
    {
        vertical-align: middle;
    }
    .post-box .p-status textarea
    {
        width: 200px;
    }
    .post-box #target-box .bordered
    {
        border: solid 1px #88BCDF;
        margin-top: 27px;
        padding: 0px;
    }
    .post-box #target-box form
    {
        margin: 0px;
        padding: 0px;
    }
    .post-box #target-box div.p-status
    {
        padding: 0px;
    }
    .post-box #target-box div.p-status #status-message, .clone-textarea
    {
        font: 12px arial;
        outline: none;
        width: 600px;
        margin: 0px;
        resize: none;
        padding: 6px;
        overflow: hidden;
        border: none;
        min-height: 16px;
        display: block;
    }
    .post-box #target-box div.p-link #plink,
    .post-box #target-box div.p-video #pvideo
    {
        font: 12px arial;
        outline: none;
        width: 100%;
        margin: 0px;
        padding: 3px;
        min-height: 16px;
    }
    
    .p-location.status-select #select-location
    {
        display: table;
    }
    .p-location.status-select #save-location
    {
        display: none;
    }
    .p-location #select-location
    {
        display: none;
    }
    .p-location #save-location
    {
        display: table;
    }
    
    .p-video.status-select #select-video
    {
        display: table;
    }
    .p-video.status-select #save-video
    {
        display: none;
    }
    .p-video #select-video
    {
        display: none;
    }
    .p-video #save-video
    {
        display: table;
    }
    #video-thumb img
    {
        width: 120px;
        display: block;
    }
</style>


<?php echo javascript_tag("

$('.watermark').focus(function(){if ($(this).val()==$(this).attr('alt')) $(this).removeClass('blurred-input-tip').val('');});
$('.watermark').blur(function(){if ($(this).val()=='') $(this).addClass('blurred-input-tip').val($(this).attr('alt'));}).blur();
                
function emtProcessLocation(location){
    var geo = '".url_for('profile/geoLocate')."';
    $.getJSON(geo,{latlng: location.coords.latitude + ',' + location.coords.longitude },
      function(loc){
        $('#location_data').val($.toJSON(loc));
        $('#location-label').text(loc.result.town_city + ', ' + loc.result.country);
        $('#alt').text(loc.result.town_city + ', ' + loc.result.country);
        $('#save-location #location-map').html('').append($('<img />').attr('src', 'http://maps.google.com/maps/api/staticmap?center=' + loc.result.latitude + ',' + loc.result.longitude + '&zoom=14&size=150x150&maptype=roadmap&&sensor=true'));
        $('.p-location').removeClass('status-select');
      }
    );
}

function emtDeniedLocation(){

}


$('#get-location-link').click(function(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(emtProcessLocation, emtDeniedLocation);
    }    
});

$('#get-video-link').click(function(){
    var geo = '".url_for('profile/parseVideoId')."';
    $.getJSON(geo,{url: $('#pvideo').val() },
      function(video){
        if (video.stat != 'success') {
           $('#video-error').show();
           return;
        }
        $('#video-title-label').text(video.title);
        $('#video-title').val(video.title);
        $('#save-video #video-thumb').html('').append($('<img />').attr('src', video.thumb));
        $('.p-video').removeClass('status-select');
      }
    );
});


$('.post-box > ul > li > a').click(function(){
    $('.post-box li').removeClass('selected');
    $(this).closest('li').addClass('selected');
    $('div#target-box div[class^=\"p-\"]').addClass('ghost');
    $('div[class^=\"out-\"]').addClass('ghost');
    $('div#target-box div.'+$(this).closest('li').attr('id')).removeClass('ghost');
    $('div.out-'+$(this).closest('li').attr('id')).removeClass('ghost');
});
function FitToContent(id, maxHeight)
{
   var text = id && id.style ? id : document.getElementById(id);
   if (!text) return;
   $('#clonediv').html($(text).val().replace(/\\n$/g, '<br />&nbsp;').replace(/\\n/g, '<br />'));
   $(text).height($('#clonediv').height());
}

window.onload = function() {
    $('div#target-box #status-message').keyup(function() {
        FitToContent(this);
      });
    $('div#target-box #status-message').focus(function(){ $('.p-status-post').removeClass('ghost-sub'); });
    };

") ?>
