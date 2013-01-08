<?php slot('subNav') ?>
<?php include_partial('global/subNav_cm') ?>
<?php end_slot() ?>

<?php use_helper('Date') ?>
<div class="col_948">

    <div class="breadcrumb">
        <ul>
            <li><?php echo link_to(__('Trade Shows'), '@tradeshows') ?></li>
            <li><span><?php echo $event ?></span></li>
        </ul>
    </div>

    <div class="hrsplit-2"></div>

    <div class="col_180">
    <?php if (count($photos) && ($photo = $photos[0])): ?>
        <div class="box_180 txtCenter">
            <?php echo link_to_function(image_tag($photo->getMediumUri()), '') ?>
        </div>
    <?php endif ?>
        <?php if (!$time_scheme->isNew()): ?>
        <div class="box_180 txtCenter">
            <div class="_noBorder txtCenter">
                <div class="clndr-leaf" style="display: inline-block">
                    <div><?php echo strtoupper(format_date($time_scheme->getStartDate('U'), 'MMMM')) ?></div>
                    <?php echo $time_scheme->getStartDate('d') ?>
                </div>
                <em class="clear t_smaller t_grey"><?php echo $time_scheme->getStartDate('Y') ?></em>
            </div>
        </div>
        <?php endif ?>
        <div class="hrsplit-2"></div>
        <div class="box_180 txtCenter">
            <div class="_noBorder">
                <?php echo like_button($event) ?>
            </div>
        </div>
    </div>
            
    <div class="col_576 b2bProduct">

        <h3 class="pname"><?php echo $event ?><span class="subinfo"><?php echo $event->getEventType() ?></span></h3>
        <div>
            <div class="box_576">
                <div class="_noBorder pad-0">
                <?php if ($event->getIntroduction()): ?>
                <div class="pad-2">
                    <?php echo $event->getIntroduction() ?>
                </div>
                <?php endif ?>
                <div>
                    <table class="infopanel">
                        <tr>
                            <td><strong><?php echo __('When?') ?></strong>
                                <div>
                                    <?php echo $time_scheme->getStartDate() ? '<p><strong>'.__('Starts').':</strong>' . format_date($time_scheme->getStartDate('U'), 'f') . '</p>' : '' ?>
                                    <?php echo $time_scheme->getEndDate() ? '<p><strong>'.__('Ends').':</strong>' . format_date($time_scheme->getEndDate('U'), 'f') . '</p>' : '' ?>
                                </div>
                            </td>
                            <td><strong><?php echo __('Where?') ?></strong>
                                <div>
                                    <?php if ($place = $event->getPlace()): ?>
                                    <p><?php echo link_to($place, $place->getUrl()) ?></p>
                                    <em><?php echo $place->getLocationText() ?></em>
                                    <?php else: ?>
                                    <p><?php echo $event->getLocationName() ?></p>
                                    <em><?php echo $event->getLocationText() ?></em>
                                    <?php endif ?>
                                </div>
                            </td>
                            <td><strong><?php echo __('Who?') ?></strong>
                                <div>
                                    <?php if ($organ = $event->getOrganiser()): ?>
                                    <p><?php echo link_to($organ, $organ->getProfileUrl()) ?></p>
                                    <em><?php echo $organ->getLocationLabel() ?></em>
                                    <?php echo $organ->getLogo() ? link_to(image_tag($organ->getLogo()->getThumbnailUri()), $organ->getProfileUrl(), 'class=clear margin-t2') : '' ?>
                                    <?php else: ?>
                                    <p><?php echo $event->getOrganiserName() ?></p>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h4><?php echo __('Participants') . "($att_count)" ?>
                        <div class="_right"><?php //echo link_to(__('See All'), $event->getUrl(), array('query_string' => 'tab=attenders', 'class' => 'bluelink hover')) ?></div>
                    </h4>
                    <?php foreach ($attenders as $type => $list): ?>
                    <div class="t_smaller t_grey margin-t2 margin-b1"><?php echo $type == PrivacyNodeTypePeer::PR_NTYP_USER && count($list) ? __('Individuals') . ':' : '' ?>
                        <?php echo $type == PrivacyNodeTypePeer::PR_NTYP_COMPANY && count($list) ? __('Companies') . ':' : '' ?>
                        <?php echo $type == PrivacyNodeTypePeer::PR_NTYP_GROUP && count($list) ? __('Groups') . ':' : '' ?>
                        </div>
                    <?php foreach ($list as $key => $node): ?>
                    <?php echo link_to($node, $node->getProfileUrl(), 'class=inherit-font hover') . ($key+1 < count($list) ? ', ' : '') ?> 
                    <?php endforeach ?>
                    <?php endforeach ?>
                    <?php if ($att_count == 0): ?>
                    <p class="t_grey pad-1"><?php echo __('No participants yet.') ?></p>
                    <?php endif ?>
                </div>
                
                <div>
                    <h4><?php echo __('Event Photos') ?></h4>
                    <?php if (count($photos)): ?>
                    <div class="photoGallery _noBorder">
                        <dl>
                            <dt><?php echo __('Event Photos') ?></dt>
                            <?php foreach ($photos as $ph): ?>
                            <dd>
                                <?php echo link_to(image_tag($ph->getThumbnailUri()), $ph->getUrl()) ?>
                            </dd>
                            <?php endforeach ?>
                        </dl>
                    </div>
                    <?php else: ?>
                    <div class="pad-2">
                    <?php echo __('No photos') ?>
                    </div>
                    <?php endif ?>
                </div>
                
                </div>
            </div>
        </div>

    </div>

    <div class="col_180">
        <div class="box_180 _titleBG_White">
        </div>
    </div>

</div>