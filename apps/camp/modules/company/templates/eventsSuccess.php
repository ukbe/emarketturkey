<?php slot('subNav') ?>
<?php include_partial('global/subNav_b2b') ?>
<?php end_slot() ?>

<div class="col_948 b2bCompany">

<?php include_partial('profile_top', array('company' => $company, 'nums' => $nums))?>

<div class="hrsplit-1"></div>

    <div class="col_180">
<?php include_partial('leftmenu', array('company' => $company))?>

    </div>

    <div class="col_762">

        <div class="col_576">
            <div class="box_576">
                <h4><?php echo __("Events") ?></h4>
                <div class="_noBorder">
                    <?php if (count($events)): ?>
                    <?php foreach ($events as $event): ?>
                    <?php include_partial('event/event', array('event' => $event)) ?>
                    <?php endforeach?>
                    <?php else: ?>
                    <?php echo __('There is no event participation for the company.') ?>
                    <?php endif ?>

                </div>
            </div>
        </div>

        <div class="col_180">
            <?php if ($own_company): ?>
            <?php include_partial('owner_actions', array('company' => $company)) ?>
            <?php else: ?>
            <?php include_partial('connect_box', array('company' => $company, 'nums' => $nums)) ?>
            <?php endif ?>
            
            <div class="box_180 _titleBG_White">
                <h3><?php echo __('How are you connected?') ?></h3>
                <div>
                    <?php include_partial('global/connected_how', array('subject' => $sesuser, 'target' => $company)) ?>
                </div>
            </div>

        </div>

    </div>
</div>