<?php slot('subNav') ?>
<?php include_partial('global/subNav_cm') ?>
<?php end_slot() ?>

<div class="col_948">
    <div class="col_180">

<?php include_partial('events') ?>

    </div>

    <div class="col_576">
        <div class="box_576 _titleBG_Transparent">
            <h4 style="border-bottom:none;"><?php echo __('Find an Event') ?></h4>
            <?php echo form_tag("@events-action?action=results") ?>
            <dl class="_table">
                <dt><?php echo emt_label_for('event-keyword', __('Search Event')) ?></dt>
                <dd><?php echo input_tag('event-keyword', $sf_params->get('event-keyword'), 'style=width:250px;') ?>
                    <?php echo submit_tag(__('Search'), 'class=green-button') ?>
                    <div class="adv-switch pad-1"><?php echo link_to_function(__('Advanced Search ..'), "$('.adv-switch').toggleClass('ghost');", 'class=bluelink') ?></div></dd>
                <dt class="adv-switch ghost"><?php echo emt_label_for('country', __('Country'))?></dt>
                <dd class="adv-switch ghost">
                    <?php echo select_country_tag('country', $sf_params->get('country'), array('size' => 5, 'multiple' => 'multiple')) ?>
                    </dd>
            </dl>
            </form>
        </div>
        
        <div class="box_576">
            <h5 class="margin-0"><?php echo __('Featured Events') ?></h5>
            <div class="_noBorder">
                <?php include_partial('layout_extended_event', array('results' => $featured_shows)) ?>
                <?php echo link_to(__('List all Featured Events'), "@events-action?action=featured", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>

    </div>

    <div class="col_180">
    <?php if (count($net_attenders)): ?>
        <div class="box_180">
            <h5 class="margin-0"><?php echo __("Who is Attending?") ?></h5>
            <div class="_noBorder smalltext">
                <dl class="inline-objects">
                <?php foreach ($net_attenders as $attender): ?>
                    <dt><?php echo image_tag($attender->getProfilePictureUri()) ?></dt>
                    <dd><?php echo $attender ?></dd>
                <?php endforeach ?>
                </dl>
                <?php echo link_to(__('see more'), "@events-action?action=attenders", 'class=clear inherit-font hover bluelink margin-t1') ?>
            </div>
        </div>
    <?php endif ?>
    </div>

<?php use_javascript('jquery.customCheckbox.js') ?>
<?php echo javascript_tag("
    $('dl._table input').customInput();
") ?>
    
</div>