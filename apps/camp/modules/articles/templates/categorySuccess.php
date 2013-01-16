<?php slot('subNav') ?>
<?php include_partial('global/subNav_ac') ?>
<?php end_slot() ?>

<div class="col_948">

<div class="col_630">
    <div class="breadcrumb">
        <ul>
            <li><?php echo link_to(__('Articles Home'), "@articles") ?></li>
            <?php $parent = $category;
                  $html = "";
                  while ($parent = $parent->getParent())
                    {
                        $html = "<li>".link_to($parent->__toString(), "@articles-category?stripped_category={$parent->getStrippedCategory()}")."</li>". $html;
                    }
                  echo $html ? $html : ''; ?>
            <li><span><?php echo $category->__toString() ?></span></li>
        </ul>
    </div>

    <?php if (count($banner_articles)): ?>
    <div class="box_630 spot_pubs">
        <div class="_noBorder">
            <?php foreach ($banner_articles as $pub): ?>
            <div class="item">
                <?php echo $pub->getPicture() ? link_to(image_tag($pub->getPicture()->getUri(MediaItemPeer::LOGO_TYPE_MEDIUM)), $pub->getUrl()) : '' ?>
                <h2><?php echo link_to($pub->getShortTitleVsTitle(), $pub->getUrl()) ?></h2>
                <p><?php echo $pub->getSummary() ?><?php echo link_to(__('Read More'), $pub->getUrl(), 'class=readmore')?></p>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>

    <div class="box_630 _other_pubs">
        <h4><?php echo __('Articles on %cat', array('%cat' => $category->__toString())) ?></h4>
        <div class="_noBorder">
            <?php if (count($results = $pager->getResults())): ?>
            <?php foreach ($results as $pub): ?>
            <div class="item">
                <?php echo $pub->getPicture() ? link_to(image_tag($pub->getPicture()->getUri(MediaItemPeer::LOGO_TYP_SMALL)), $pub->getUrl()) : ($pub->getAuthor() && $pub->getAuthor()->getPicture() ? link_to(image_tag($pub->getAuthor()->getPicture()->getUri(MediaItemPeer::LOGO_TYP_SMALL)), $pub->getUrl()) : '') ?>
                <h2><?php echo link_to($pub->getShortTitleVsTitle(), $pub->getUrl()) ?></h2>
                <p><?php echo $pub->getSummary() ?></p>
            </div>
            <?php endforeach ?>
            <?php endif ?>
            <?php if ($pager->haveToPaginate()): ?>
            <div class="_right">
            <?php echo pager_links($pager, array('pname' => 'page')) ?>
            </div>
            <?php endif ?>
        </div>
    </div>

    <div class="box_630">
        <hr class="split-line" />
        <h4><?php echo __('Article Categories') ?></h4>
        <div class="_noBorder pad-0">
            <ul class="categories">
                <?php foreach ($categories as $cat): ?>
                <?php if ($cat->getId() != $kb_category->getId()): ?>
                <li>
                <strong><?php echo link_to($cat->__toString(), "@articles-category?stripped_category={$cat->getStrippedCategory()}") ?></strong>
                <ul>
                <?php foreach ($cat->getSubCategories() as $sub): ?>
                <li><?php echo link_to($sub->__toString(), "@articles-category?stripped_category={$sub->getStrippedCategory()}") ?></li>
                <?php endforeach ?></ul></li>
                <?php endif ?>
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
                <dd><strong><?php echo link_to($article->__toString(), $article->getUrl()) ?></strong>
                    <?php echo $article->getPublicationSource() ? $article->getPublicationSource()->__toString() : '' ?></dd>
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
                    <dt><?php echo count($article->getAuthor()->getPhotos()) ? link_to(image_tag($article->getAuthor()->getPictureUri(), array('title' => $article->getAuthor()->__toString())), $article->getUrl()) : '' ?></dt>
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