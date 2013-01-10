<?php slot('subNav') ?>
<?php include_partial('global/subNav_ac') ?>
<?php end_slot() ?>

<div class="col_948">

<div class="col_630">
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

</div>

<div class="col_312">

    <div class="box_312 _border_Shadowed">
        <h3><?php echo __('Author') ?></h3>
        <div>
            <?php if ($author): ?>
            <div class="col_authors margin-t2">
                <dl>
                    <dt><?php echo count($author->getPhotos()) ? link_to(image_tag($author->getPictureUri(), array('title' => $author)), $author->getUrl('posts')) : '' ?></dt>
                    <dd>
                        <div class="author-name"><?php echo link_to($author->__toString(), $author->getUrl('posts')) ?>
                        <?php echo $author->getTitle() ?></div>
                        <div class="fgeorgia margin-t2">
                            <?php echo $author->getIntroduction() ?>
                        </div></dd>
                </dl>
            </div>
            <div class="clear hrsplit-1"></div>
            <?php endif ?>
            
            <div class="pad-1">
                <?php echo link_to(__('All Authors'), '@authors', 'class=blue small')?>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <?php if (count($top_posts)): ?>
    <div class="box_312">
        <h4><?php echo __('Most Read Posts') ?></h4>
        <div class="_noBorder">
            <dl class="rating-list">
            <?php foreach ($top_posts as $post): ?>
                <dt<?php echo strlen($post->getRating()) > 3 ? ' class="t_smaller"' : '' ?>><?php echo $post->getRating() ?></dt>
                <dd><strong><?php echo link_to($post->__toString(), $post->getUrl()) ?></strong>
                    <?php echo $post->getPublicationSource() ? $post->getPublicationSource()->__toString() : '' ?></dd>
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
                        <?php echo link_to($article->__toString(), $article->getUrl()) ?>
                        <div class="author-name"><?php echo link_to($article->getAuthor()->__toString(), $article->getUrl()) ?>
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