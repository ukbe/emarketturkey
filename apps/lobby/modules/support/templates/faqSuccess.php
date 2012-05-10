<div class="col_948">

    <div class="col_180">
<?php include_partial('leftmenu')?>
    </div>

    <div class="col_576">
        <div class="box_576">

            <h4><?php echo __('Frequently Asked Questions') ?></h4>
            <?php $cat = new FaqCategory() ?>
            <div class="_noBorder">
                <dl class="faq-list">
                    <?php foreach ($faqs as $faq): ?>
                    <?php if ($cat->getId() != $faq->getCategoryId()): ?>
                    <?php $cat = $faq->getFaqCategory() ?>
                    <dt class="category"><?php echo $cat->getName() ?></dt>
                    <?php endif ?>
                    <dt><?php echo link_to_function($faq->getQuestion(), '', 'class=inherit-font') ?></dt>
                    <dd><?php echo myTools::format_text($faq->getClob(FaqItemI18nPeer::ANSWER)) ?></dd>
                <?php endforeach ?>
                </dl>
            </div>

        </div>
    </div>

</div>

<?php echo javascript_tag("
$(function(){

    $('dl.faq-list a').click(function(){ $(this).closest('dt').next('dd').toggleClass('view'); });

});

") ?>