<?php use_helper('Date') ?>
<div class="col_948">

    <div class="breadcrumb">
        <ul>
            <li><?php echo link_to(__('Venues'), '@venues') ?></li>
            <li><span><?php echo $place ?></span></li>
        </ul>
    </div>

    <div class="hrsplit-2"></div>

    <div class="col_180">
    <?php if ($place->getLogo()): ?>
        <div class="box_180 txtCenter">
            <?php echo link_to_function(image_tag($place->getLogo()->getMediumUri()), '') ?>
        </div>
    <?php endif ?>
        <div class="box_180 txtCenter">
            <div class="_noBorder">
                <?php echo like_button($place, $_here) ?>
            </div>
        </div>
    </div>
            
    <div class="col_576 b2bProduct">

        <h3 class="pname"><?php echo $place ?><span class="subinfo"><?php echo $place->getPlaceType() ?></span></h3>
        <div>
            <?php if ($place->getIntroduction()): ?>
            <div class="box_576">
                <div class="_noBorder pad-2">
                    <?php echo $place->getIntroduction() ?>
                </div>
            </div>
            <?php endif ?>
            <div class="box_576">
                <h4><?php echo __('Information') ?></h4>
                <div class="_noBorder pad-0">
                    <dl class="_table _noInput">
                        <dt><?php echo emt_label_for('none', __('Location')) ?></dt>
                        <dd><?php echo $place->getLocationText() ?></dd>
                        <dt><?php echo emt_label_for('none', __('Map')) ?></dt>
                        <dd>
                <?php if ($address): ?>
                <?php $addr[] = $address->getStreet() ?>
                <?php $addr[] = $address->getCity() ?>
                <?php $addr[] = $address->getGeonameCity() ?>
                <?php $addr[] = $address->getPostalCode() ?>
                <?php $addr[] = $address->getCountry() ?>
                <?php $str = urlencode(implode(',', $addr)) ?>
                            <?php echo link_to(image_tag("http://maps.google.com/maps/api/staticmap?zoom=6&size=270x150&maptype=roadmap&markers=color:red|$str&sensor=true"), "http://maps.google.com/?q=$str", array('target' => 'blank', 'title' => __('Click to view location in Google Maps'))) ?>
                            <div><em class="t_grey" style="font-size: 11px;"><?php echo __('Click the map to view location on Google Maps.') ?></em></div>
                <?php endif ?>
                        </dd>
                    </dl>
                    
                </div>
            </div>
            <?php if (count($future_events)): ?>
            <div class="box_576 _titleBG_Transparent">
                <h4><?php echo __('Future Events') ?></h4>
                <dl class="_table">
                <?php foreach ($future_events as $key => $event): ?>
                <dt><?php echo $event->getLogo() ? link_to(image_tag($event->getLogoUri(), array('alt' => $event)), $event->getUrl(), 'class=margin-t2') : '' ?></dt>
                <dd><?php echo link_to($event, $event->getUrl(), 'class=inherit-font bluelink hover') ?>
                    <ul class="sepdot">
                        <li><em class="clear"><?php echo $event->getEventType() ?></em></li>
                        <li><?php echo $event->getPlaceText() ?></li>
                    </ul></dd>
                <?php endforeach ?>
                </dl>
            </div>
            <?php endif ?>
            <?php if (count($past_events)): ?>
            <div class="box_576 _titleBG_Transparent">
                <h4><?php echo __('Past Events') ?></h4>
                <dl class="_table">
                <?php foreach ($past_events as $key => $event): ?>
                <dt><?php echo $event->getLogo() ? link_to(image_tag($event->getLogoUri(), array('alt' => $event)), $event->getUrl(), 'class=margin-t2') : '' ?></dt>
                <dd><?php echo link_to($event, $event->getUrl(), 'class=inherit-font bluelink hover') ?>
                    <ul class="sepdot">
                        <li><em class="clear"><?php echo $event->getEventType() ?></em></li>
                        <li><?php echo $event->getPlaceText() ?></li>
                    </ul></dd>
                <?php endforeach ?>
                </dl>
            </div>
            <?php endif ?>
        </div>

    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
            <h3><?php echo __('Owner Information') ?></h3>
            <div class="t_smaller">
            <?php if ($owner): ?>
                <div class="txtCenter"><?php echo $owner->getLogo() ? link_to(image_tag($owner->getLogo()->getThumbnailUri()), $owner->getProfileUrl()) : '' ?></div>
                <h4 class="txtCenter"><?php echo $owner ?></h4>
                <?php if ($owner->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
                <strong><?php echo __('Industry') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getBusinessSector() ?></div>
                <strong><?php echo __('Business Type') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getBusinessType() ?></div>
                <strong><?php echo __('Location') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getLocationLabel() ?></div>
                <p><?php echo link_to(__('Go to Company Profile'), $owner->getProfileUrl(), 'class=bluelink hover')?></p>
                <?php elseif ($owner->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_GROUP): ?>
                <strong><?php echo __('Group Type') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getGroupType() ?></div>
                <?php if ($group->getContact()): ?>
                <strong><?php echo __('Location') ?>:</strong>
                <div class="t_smaller t_grey"><?php echo $owner->getLocationLabel() ?></div>
                <?php endif ?>
                <p><?php echo link_to(__('Go to Group Profile'), $owner->getProfileUrl(), 'class=bluelink hover')?></p>
                <?php endif ?>
                <p><?php echo link_to(__('Contact Owner'), $owner->getProfileActionUrl('contact'), array('query_string' => "rel={$venue->getPlug()}", 'class' => 'contactlink'))?></p>
            <?php else: ?>
            <?php echo __('This venue is not claimed yet.')?>
            <p>
            <?php echo __('Do you own this venue? Claim your ownership %1herelink', array('%1herelink' => link_to(__('here'), '@lobby.contactus', 'class=inherit-font bluelink hover')))?>
            </p>
            <?php endif ?>
            </div>
        </div>
    </div>

</div>