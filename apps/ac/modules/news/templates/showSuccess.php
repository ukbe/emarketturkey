<?php use_helper('Date') ?>
<div class="col_948">

<div class="col_630">
    <div class="box_630">
        <div class="_noBorder">
            <h2 class="pub-title"><?php echo $news->getTitle() ?></h2>
            <p class="headline_meta">
                <abbr class="published" title="<?php echo $news->getCreatedAt('Y-m-d') ?>"><?php echo format_datetime($news->getCreatedAt('U'), 'f') ?></abbr>
                <span class="author"><?php echo __('Source:') . link_to($news->getPublicationSource(), '@news-source?stripped_display_name='.$news->getPublicationSource()->getStrippedDisplayName(), array('title' => __('News by %1', array('%1' => $news->getPublicationSource())))) ?></span>
            </p>
            <div class="pub-content">
                <?php echo $news->getPicture() ? image_tag($news->getPicture()->getUri()) : '' ?>
                <div class="hrsplit-2"></div>
                <?php echo "<p>".str_replace(chr(13), '</p><p>', $news->getBody())."</p>" ?>
            </div>
            <div class="pad-2">
                <ul class="_horizontal">
                    <li><?php echo like_button($news) ?></li>
                    <li style="margin-left: 20px; padding: 1px 0px;"><!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style">
                            <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=emarketturkey" class="addthis_button_compact"><?php echo __('Bookmark/Share')?></a>
                        </div>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=emarketturkey"></script>
                        <!-- AddThis Button END --></li>
                </ul>
                <div class="hrsplit-1"></div>
            </div>
            <div class="comments-box">
            <h3><?php echo __('Comments') ?></h3>
            <?php include_partial('profile/comment_box', array('item' => $news)) ?>
            </div>
        </div>
    </div>

    <?php if (count($top_news)): ?>
    <div class="box_312">
        <h4><?php echo __('Most Read News on %1category', array('%1category' => $news->getPublicationCategory())) ?></h4>
        <div class="_noBorder">
            <dl class="rating-list">
            <?php foreach ($top_news as $tnews): ?>
                <dt<?php echo strlen($news->getRating()) > 3 ? ' class="t_smaller"' : '' ?>><?php echo $tnews->getRating() ?></dt>
                <dd><strong><?php echo link_to($tnews, $tnews->getUrl()) ?></strong>
                    <?php echo $tnews->getPublicationSource() ?></dd>
            <?php endforeach ?>
            </dl>
        </div>
    </div>
    <?php endif ?>
    
    <?php if (count($other_news)): ?>
    <div class="box_312">
        <h4><?php echo __('Other News from %1source', array('%1source' => $source->getName())) ?></h4>
        <div class="_noBorder">
            <dl class="rating-list">
            <?php foreach ($other_news as $tnews): ?>
                <dt<?php echo strlen($tnews->getRating()) > 3 ? ' class="t_smaller"' : '' ?>><?php echo $tnews->getRating() ?></dt>
                <dd><strong><?php echo link_to($tnews, $tnews->getUrl()) ?></strong>
                    <?php echo time_ago_in_words($tnews->getCreatedAt('U'), false) ?></dd>
            <?php endforeach ?>
            </dl>
        </div>
    </div>
    <?php endif ?>

</div>

<div class="col_312">

    <div class="box_312 _border_Shadowed">
        <h3><?php echo __('News') ?></h3>
        <div>
            <?php if ($source): ?>
            <div class="col_authors margin-t2">
                <dl>
                    <dt><?php echo $source->getPicture() ? link_to(image_tag($source->getPictureUri(), array('title' => $source)), "@news-source?stripped_display_name={$source->getStrippedDisplayName()}") : '' ?></dt>
                    <dd><?php echo $source ?>
                            <?php echo link_to(__('News by %1source', array('%1source' => $source)), "@news-source?stripped_display_name={$source->getStrippedDisplayName()}") ?>
                        </dd>
                </dl>
            </div>
            <?php endif ?>
            <div class="pad-1">
                <ul class="sepdot">
                    <li><?php echo link_to(__('News Home'), '@news-home', 'class=blue small')?></li>
                    <li><?php echo link_to($news->getPublicationCategory(), "@news-category?stripped_category={$news->getPublicationCategory()->getStrippedCategory()}", 'class=blue small')?></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="box_312 _border_Shadowed">
        <h3><?php echo __('Share') ?></h3>
        <div class="pad-2">
            <ul class="_horizontal">
                <li><?php echo like_button($news) ?></li>
                <li style="margin-left: 20px; padding: 1px 0px;"><!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style">
                        <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=emarketturkey" class="addthis_button_compact"><?php echo __('Bookmark/Share')?></a>
                    </div>
                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=emarketturkey"></script>
                    <!-- AddThis Button END --></li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>

    <div class="box_312 _border_Shadowed">
        <div>
            <div class="adbox">
<script type="text/javascript"><!--
    google_ad_client = "ca-pub-1242349477299469";
    /* Academy Publication Content */
    google_ad_slot = "3763057883";
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