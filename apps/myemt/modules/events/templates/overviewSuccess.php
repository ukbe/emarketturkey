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
            <section>
                <h4><?php echo __('Upcoming Events') ?></h4>
                
                <dl class="_table">
                    <dt><?php echo emt_label_for('today', __('Today')) ?></dt>
                    <dd><?php if (count($events_today)): ?>
                        <?php foreach ($events_today as $event): ?>
                        <?php include_partial('events/event', array('event' => $event)) ?>
                        <?php endforeach ?>
                        <?php else: ?>
                        <em class="ln-example"><?php echo __('No events for today') ?></em>
                        <?php endif ?>
                        <hr />
                        </dd>
                    <dt><?php echo emt_label_for('this_week', __('This Week')) ?></dt>
                    <dd><?php if (count($events_this_week)): ?>
                        <?php foreach ($events_this_week as $event): ?>
                        <?php include_partial('events/event', array('event' => $event)) ?>
                        <?php endforeach ?>
                        <?php else: ?>
                        <em class="ln-example"><?php echo __('No events for this week') ?></em>
                        <?php endif ?>
                        <hr />
                        </dd>
                    <dt><?php echo emt_label_for('next_week', __('Next Week')) ?></dt>
                    <dd><?php if (count($events_next_week)): ?>
                        <?php foreach ($events_next_week as $event): ?>
                        <?php include_partial('events/event', array('event' => $event)) ?>
                        <?php endforeach ?>
                        <?php else: ?>
                        <em class="ln-example"><?php echo __('No events for next week') ?></em>
                        <?php endif ?>
                        </dd>
                </dl>
                
            </section>
            
        </div>
        
    </div>

    <div class="col_180">
        <div class="box_180 _WhiteBox">
            <h3><?php echo __('New Event?') ?></h3>
            <div>
            <?php echo __('Create a page for your event and invite people.') ?><br /><br />
            <?php echo link_to(__('Add Event'), "$route&action=add", 'class=green-button') ?>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">

$(function() {
        $('ul.tabs').tabs('div.panes > div');
});
</script>