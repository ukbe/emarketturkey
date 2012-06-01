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
                    <?php $hash = myTools::flipHash($faq->getId()) ?>
                    <dt><?php echo link_to($faq->getQuestion(), "@faq#q$hash", "class=inherit-font id=q$hash onclick=return false;") ?></dt>
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
    
    if (window.location.hash!='') {
        $(window.location.hash).click();
        $('html, body').animate({scrollTop: $(window.location.hash).offset().top-100}, 500);
    };
    

});

") ?>