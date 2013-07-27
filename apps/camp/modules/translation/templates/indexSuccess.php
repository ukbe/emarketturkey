<?php slot('subNav') ?>
<?php include_partial('global/subNav_tx') ?>
<?php end_slot() ?>

<div class="col_948">
<div class="presentation">

    <div class="boxTitle">
        <h2>
            Translators Directory
        </h2>
    </div>

    <div class="boxContent tabs noBorder">

        <dl class="_translation">
        </dl>
    </div>

    <div class="slidetabs">
        <a href="#">Translators Directory</a>
    </div>
</div>
    
    <div class="hrsplit-2"></div>

    <div class="col_312">
        <div class="box_312 noBorder">
            <div>
                <div class="pad-2">
                <?php echo image_tag('layout/background/translation-cloud.png', 'width=280') ?>
                </div>
            </div>
        </div>

    </div>

    <div class="col_576">
        <div class="box_576 pad-3 noBorder presentation">
            <h2><?php echo __('Welcome to eMarketTurkey Translation') ?></h2>
            <div class="hrsplit-2"></div>
            <h3><?php echo __('Are you a Translator?') ?></h3>
            <p><?php echo __('We are now calling Translators and Interpreters to register to Translators Directory. Apply for a translator account and once approved, get listed. You will be receiving translation requests.') ?></p>
            <h3><?php echo __('Corporate or Professional. All good!') ?></h3>
            <p><?php echo __('Are you running an agency? You may create a corporate account for your agency and receive translation requests for your business.') ?></p>
            <div class="hrsplit-1"></div>
            <?php echo link_to(__('Register Now'), '@tr-apply', 'class=dark-button') ?>
        </div>
    </div>

</div>
<?php echo javascript_tag("
$(function() {
    $('.slidetabs').tabs('.tabs > dl', {
        effect: 'fade',
        rotate: true
    }).slideshow({
        clickable: false,
        autoplay:true,
        interval:20000
    });
});

") ?>
