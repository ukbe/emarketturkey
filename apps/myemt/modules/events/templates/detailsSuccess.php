<?php use_helper('Date') ?>

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
    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <section id="boxContent">
                <h4><?php echo __('Event Details') ?></h4>
                <dl class="_table">
                    <dt><?php echo image_tag($event->getLogoUri(MediaItemPeer::LOGO_TYPE_MEDIUM), 'style=width:100%;') ?>
                        <div class="hrsplit-2"></div>
                        <ul class="simple-menu"><li><?php echo link_to(__('Edit Event'), "$eventroute&action=add") ?></li>
                            <li><?php echo link_to(__('Upload Photo'), "$eventroute&action=add#upload-photo") ?></li>
                            </ul>
                        </dt>
                    <dd><div class="_right"><?php echo link_to(__('Go to Event Page'), $event->getUrl()) ?></div>
    <div class="tabgroup" style="width:400px;">
        <ul class="flowtabs" id="flowtabs">
            <?php foreach ($i18ns as $key => $lang): ?>
            <li><a href="t<?php echo $key ?>"<?php echo $sf_user->getCulture() == $lang || (!in_array($sf_user->getCulture(), $i18ns) && $lang == $job->getDefaultLang()) ? 'class=current' : '' ?>><?php echo format_language($lang) ?></a></li>
            <?php endforeach ?>
        </ul>
        <?php if (count($i18ns) < count(sfConfig::get('app_i18n_cultures'))): ?>
        <ul class="flowtabs"><li><?php echo link_to(__('+'), "$eventroute&action=add#addtrans", array('title' => __('Add Translation'), 'class' => 'frmhelp')) ?></li></ul>
        <?php endif ?>
        <div class="flowpanes" style="width: 400px;">   
           <div class="items">
            <?php foreach ($i18ns as $key => $lang): ?>
                <table style="400px;">
                <tr><th><?php echo __('Event Name') ?></th>
                    <td><?php echo $event->getName($lang) ?></td></tr>
                <tr><th><?php echo __('Type') ?></th>
                    <td><?php echo $event->getEventType()->getName($lang) ?></td></tr>
                <tr><th><?php echo __('Location') ?></th>
                    <td><?php echo $place ? $place->getName($lang) . ($place->getGeonameCity() ? ', ' . $place->getGeonameCity() : '') . ($place->getCountry() ? ', ' . format_country($place->getCountry(), $lang) : '')
                                              : $event->getLocationName() . ($event->getGeonameCity() ? ', ' . $event->getGeonameCity() : '') . ($event->getLocationCountry() ? ', ' . format_country($event->getLocationCountry(), $lang) : '') ?></td></tr>
                <tr><th><?php echo __('Organiser') ?></th>
                    <td><?php echo $organiser ? $organiser : $event->getOrganiserName() ?></td></tr>
                <tr><th><?php echo __('Date') ?></th>
                    <td><?php echo __('Starts at %1', array('%1' => format_datetime($time_scheme->getStartDate('U'), 'D', $lang))) ?>
                        <?php echo $time_scheme->isOneDay() ? '' : '<br />' . __('Ends at %1', array('%1' => format_datetime($time_scheme->getEndDate('U'), 'D', $lang))) ?></td></tr>
                <tr><th><?php echo __('Repeat') ?></th>
                    <td><?php echo $time_scheme->getRepeatTypeId() ? __(EventPeer::$rtypNames[$time_scheme->getRepeatTypeId()]) : __('No Repeat') ?></td></tr>
                <tr><th><?php echo __('Introduction') ?></th>
                    <td><?php echo $event->getIntroduction($lang) ?></td></tr>
                </table>
            <?php endforeach ?>
           </div>
        </div>
    </div>
                    </dd>
                </dl>
            <div class="hrsplit-2"></div>
            <h5><?php echo __('Who is attending?') ?></h5>
            <dl class="_table whoatt">
                <dt><?php echo __('Individuals') ?></dt>
                <dd>
                    <?php if (count($attenders[PrivacyNodeTypePeer::PR_NTYP_USER])): ?>
                    <?php foreach ($attenders[PrivacyNodeTypePeer::PR_NTYP_USER] as $attendee): ?>
                    <?php echo link_to(image_tag($attendee->getProfilePictureUri()), $attendee->getProfileUrl(), array('title' => $attendee)) ?>
                    <?php endforeach ?>
                    <?php else: ?>
                    <?php echo __('No individuals') ?>
                    <?php endif ?></dd>
                <dt><?php echo __('Companies') ?></dt>
                <dd>
                    <?php if (count($attenders[PrivacyNodeTypePeer::PR_NTYP_COMPANY])): ?>
                    <?php foreach ($attenders[PrivacyNodeTypePeer::PR_NTYP_COMPANY] as $attendee): ?>
                    <?php echo link_to(image_tag($attendee->getProfilePictureUri()), $attendee->getProfileUrl(), array('title' => $attendee)) ?>
                    <?php endforeach ?>
                    <?php else: ?>
                    <?php echo __('No companies') ?>
                    <?php endif ?></dd>
                <dt><?php echo __('Groups') ?></dt>
                <dd>
                    <?php if (count($attenders[PrivacyNodeTypePeer::PR_NTYP_GROUP])): ?>
                    <?php foreach ($attenders[PrivacyNodeTypePeer::PR_NTYP_GROUP] as $attendee): ?>
                    <?php echo link_to(image_tag($attendee->getProfilePictureUri()), $attendee->getProfileUrl(), array('title' => $attendee)) ?>
                    <?php endforeach ?>
                    <?php else: ?>
                    <?php echo __('No groups') ?>
                    <?php endif ?></dd>
            </dl>
            <div class="hrsplit-1"></div>
            <h5><?php echo __('Photos') ?></h5>
            <dl class="_table whoatt">
                <dt><?php echo __('Official Photos') ?></dt>
                <dd>
                    <?php if (count($photos)): ?>
                        <?php foreach ($photos as $photo): ?>
                        <div>
                        <?php echo link_to(image_tag($photo->getThumbnailUri(), 'class=bordered-image'), $photo->getUri(), array('title' => __('Click to view'))) ?><br />
                        <?php echo link_to('&nbsp;', "$eventroute&action=add&act=rmp&pid={$photo->getId()}&_ref=$_here", array('class' => 'remove', 'title' => __('Remove Photo'))) ?>
                        </div>
                        <?php endforeach ?>
                    <div class="hrsplit-1"></div>
                    <?php else: ?>
                    <?php echo __('No photos') ?>
                    <?php endif ?></dd>
                <dt><?php echo __('User Contributed') ?></dt>
                <dd>
                    <?php if (count($user_photos)): ?>
                        <?php foreach ($photos as $photo): ?>
                        <div>
                        <?php echo link_to(image_tag($photo->getThumbnailUri(), 'class=bordered-image'), $photo->getUri(), array('title' => __('Click to view'))) ?><br />
                        <?php echo link_to('&nbsp;', "$eventroute&action=add&act=rmp&pid={$photo->getId()}&_ref=$_here", array('class' => 'remove', 'title' => __('Remove Photo'))) ?>
                        </div>
                        <?php endforeach ?>
                    <?php else: ?>
                    <?php echo __('No photos') ?>
                    <?php endif ?></dd>
            </dl>
<style>
.simple-menu { margin: 0px; padding: 0px; width: 100%; }
.simple-menu li { border-bottom: solid 1px #eee; padding: 2px 0px; }
.simple-menu li a { font: 12px arial; color: #444; display: block; text-align: right; padding: 4px 5px 2px 5px }
.simple-menu li a:hover { background-color: #ca0606; color: #fff; }

</style>
            </section>
        </div>
    </div>
    <div class="col_180">
        <div class="box_180 _WhiteBox">
            <h3><?php echo __('No participant yet?') ?></h3>
            <div>
            <?php echo __('You can invite friends, partners, and followers to this event.') ?><br /><br />
            <?php echo link_to(__('Send Invitations'), "$eventroute&action=invite", 'class=green-button') ?>
            </div>
        </div>
        <div class="box_180">
            <h3><?php echo __('Event Photos') ?></h3>
            <div>
            <?php echo image_tag('layout/background/gallery.jpg', 'style=margin: 0 auto;display: block;') ?>
            <div class="hrsplit-1"></div>
            <?php echo __('Let photos tell everything about your event.') ?>
            <div class="hrsplit-1"></div>
            <?php echo link_to(__('Upload Photos'), "$eventroute&action=add#upload-photo", 'class=green-button') ?>
            </div>
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

    $('.flowpanes').scrollable({ circular: true, mousewheel: false }).navigator({
        navi: '#flowtabs',
        naviItem: 'a',
        activeClass: 'current',
        history: true
    });
    
    $('.whoatt a[title!=\"\"]').tooltip({offset: [10, 2],effect: 'slide'}).dynamic({ bottom: { direction: 'down', bounce: true } });
});
") ?>