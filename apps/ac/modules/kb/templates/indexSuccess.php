<div class="col_948">

<div class="col_630">
    <?php if (count($banner_articles) || count($sectarticles)): ?>
    <div class="box_630 spot_pubs">
        <div class="_noBorder">
            <?php foreach ($banner_articles as $pub): ?>
            <div class="item">
                <?php echo $pub->getPicture() ? link_to(image_tag($pub->getPicture()->getUri(MediaItemPeer::LOGO_TYPE_MEDIUM)), $pub->getUrl()) : '' ?>
                <h2><?php echo link_to($pub->getShortTitleVsTitle(), $pub->getUrl()) ?></h2>
                <p><?php echo $pub->getSummary()?><?php echo link_to(__('Read More'), $pub->getUrl(), 'class=readmore')?></p>
            </div>
            <?php endforeach ?>
        </div>
    </div>

    <div class="box_630">
        <div class="_noBorder pad-0">
            <ul class="pub_boxes">
                <?php foreach ($sectarticles as $sect): ?>
                <?php if (!count($sect)) continue;?>
                <li>
                    <h4><?php echo link_to($sect[0]->getPublicationCategory()->__toString(), "@news-category?stripped_category={$sect[0]->getPublicationCategory()->getStrippedCategory()}") ?></h4>
                    <ul>
                    <?php foreach ($sect as $key  => $article): ?>
                        <li><?php echo link_to($article->getShortTitleVsTitle(), $article->getUrl()) ?></li>
                    <?php endforeach ?>
                    </ul>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="box_630">
    <hr class="split-line" />
    <?php else: ?>
    <div class="box_630">
    <?php endif ?>
        <h4><?php echo __('Knowledgebase Categories') ?></h4>
        <div class="_noBorder pad-0">
            <ul class="categories">
                <?php foreach ($categories as $cat): ?>
                <li>
                <strong><?php echo link_to($cat->__toString(), "@kb-category?stripped_category={$cat->getStrippedCategory()}") ?></strong>
                <ul>
                <?php foreach ($cat->getSubCategories() as $sub): ?>
                <li><?php echo link_to($sub->__toString(), "@kb-category?stripped_category={$sub->getStrippedCategory()}") ?></li>
                <?php endforeach ?></ul></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>

</div>

<div class="col_312">

    <?php if (count($top_articles)): ?>
    <div class="box_312">
        <h4><?php echo __('Most Read Articles') ?></h4>
        <div class="_noBorder">
            <dl class="rating-list">
            <?php foreach ($top_articles as $article): ?>
                <dt<?php echo strlen($article->getRating()) > 3 ? ' class="t_smaller"' : '' ?>><?php echo $article->getRating() ?></dt>
                <dd><strong><?php echo link_to($article, $article->getUrl()) ?></strong>
                    <?php echo $article->getPublicationSource() ?></dd>
            <?php endforeach ?>
            </dl>
        </div>
    </div>
    <?php endif ?>

    <div class="box_312 _border_Shadowed">
        <div>
            <div class="adbox">
<script type="text/javascript"><!--
    google_ad_client = "ca-pub-1242349477299469";
    /* Publication Category Page */
    google_ad_slot = "0735217610";
    google_ad_width = 300;
    google_ad_height = 250;
//-->
</script><script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
            </div>
            <div>
                <span class="grey small"><?php echo __('Advertisement') ?></span>
                <div class="ghost">
                    <span class="grey">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <?php echo link_to(__('Create Ad'), '@homepage', 'class=blue small')?>
                </div>
            </div>
        </div>
    </div>

    <div class="box_312 _border_Shadowed">
        <h3><?php echo link_to_function(__('Authors'), '', 'class=blue') ?></h3>
        <div>
            <div class="col_authors margin-t2">
                <dl>
                <?php foreach ($colarticles as $article): ?>
                    <dt><?php echo count($article->getAuthor()->getPhotos()) ? link_to(image_tag($article->getAuthor()->getPictureUri(), array('title' => $article->getAuthor())), $article->getUrl()) : '' ?></dt>
                    <dd>
                        <?php echo link_to($article, $article->getUrl()) ?>
                        <div class="author-name"><?php echo link_to($article->getAuthor(), $article->getUrl()) ?>
                        <?php echo $article->getAuthor()->getTitle() ?></div>
                        </dd>
                <?php endforeach ?>
                </dl>
            </div>
            <div>
            <?php echo link_to(__('See All Authors'), '@authors', 'class=blue small')?>
            </div>
        </div>
    </div>

</div>
<br class="clear" />

</div>
<?php use_javascript('emt-slider-1.0.js') ?>
<?php echo javascript_tag("
    $('.slider').emtslider({nav: '.navi', parallelPack: '.panes'});
")?>