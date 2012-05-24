<?php use_helper('Number') ?>
<div class="col_948">

<div class="col_630">
    <div class="box_630 _border_Shadowed spot_banner">
        <div>
            <div class="slider">
                <div class="items">
            <?php foreach ($banner_pubs as $pub): ?>
                <?php echo $pub->getPicture() ? link_to(image_tag($pub->getPicture()->getUri(MediaItemPeer::LOGO_TYPE_LARGE)), $pub->getUrl()) : '' ?>
            <?php endforeach ?>
                </div>
                <div class="nav_placer"><div class="navi"></div></div>
            </div>
            <div class="panes">
            <?php foreach ($banner_pubs as $pub): ?>
                <div>
                <h2><?php echo link_to($pub->getShortTitleVsTitle(), $pub->getUrl()) ?></h2>
                <p><?php echo $pub->getSummary()?><?php echo link_to(__('Read More'), $pub->getUrl(), 'class=readmore')?></p>
                </div>
            <?php endforeach ?>
            </div>
        </div>
    </div>

    <div class="box_630">
        <div class="_noBorder pad-0" style="width: 630px;">
            <ul class="vertical_pubs">
                <?php foreach ($sectnews as $sect): ?>
                <?php if (!count($sect)) continue;?>
                <li>
                    <h4><?php echo link_to($sect[0]->getPublicationCategory()->__toString(), "@news-category?stripped_category={$sect[0]->getPublicationCategory()->getStrippedCategory()}") ?></h4>
                    <ul>
                    <?php foreach ($sect as $key  => $news): ?>
                        <li><?php echo link_to(($key == 0 ? image_tag($news->getPictureUri()) : '') . $news->getShortTitleVsTitle(), $news->getUrl()) ?>
                            <?php echo $key == 0 ? '<p>'.$news->getSummary().'</p>' : '' ?></li>
                    <?php endforeach ?>
                    </ul>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>

    <?php if (count($top_news)): ?>
    <div class="box_312">
        <h4><?php echo __('Most Read News') ?></h4>
        <div class="_noBorder">
            <dl class="rating-list">
            <?php foreach ($top_news as $news): ?>
                <dt<?php echo strlen($news->getRating()) > 3 ? ' class="t_smaller"' : '' ?>><?php echo $news->getRating() ?></dt>
                <dd><strong><?php echo link_to($news->__toString(), $news->getUrl()) ?></strong>
                    <?php echo $news->getPublicationSource()->__toString() ?></dd>
            <?php endforeach ?>
            </dl>
        </div>
    </div>
    <?php endif ?>
    
    <?php if (count($top_articles)): ?>
    <div class="box_312">
        <h4><?php echo __('Most Read Articles') ?></h4>
        <div class="_noBorder">
            <dl class="rating-list">
            <?php foreach ($top_articles as $article): ?>
                <dt<?php echo strlen($news->getRating()) > 3 ? ' class="t_smaller"' : '' ?>><?php echo $article->getRating() ?></dt>
                <dd><strong><?php echo link_to($article->__toString(), $article->getUrl()) ?></strong>
                    <?php echo $article->getAuthor()->__toString() ?></dd>
            <?php endforeach ?>
            </dl>
        </div>
    </div>
    <?php endif ?>

</div>

<div class="col_312">

    <div class="box_312 _border_Shadowed market_ticker world">
        <h3><?php echo link_to_function(__('World Markets'), "$('.market_ticker div.currency').fadeOut('fast', function(){ $('.market_ticker div.world').fadeIn('normal'); $('.market_ticker').removeClass('currency'); });", 'class=world') ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo link_to_function(__('Currencies'), "$('.market_ticker div.world').fadeOut('fast', function(){ $('.market_ticker div.currency').fadeIn('normal'); $('.market_ticker').addClass('currency'); });", 'class=currency') ?></h3>
        <div>
            <div class="world">
                <?php $data = FinanceTickerDataPeer::getTickerData(FinanceTickerDataPeer::FTD_TYPE_INDEX); ?>
                <table class="finance_ticker">
                <tr><th></th><th><?php echo __('<span class="ac">Level</span>') ?></th><th><?php echo __('<span class="ac">Change</span>') ?></th><th><?php echo '% ' . __('<span class="ac">Change</span>') ?></th></tr>
                <?php foreach ($data as $datum): ?>
                <tr><td class="symbol"><?php echo $datum->getFinanceTickerItem()->getName() ?></th>
                    <td><?php echo format_number($datum->getData()) ?></td>
                    <td class="colored<?php echo $datum->getChange() > 0 ? ' green' : ($datum->getChange() < 0 ? ' red' : '') ?>"><?php echo ($datum->getChange() > 0 ? '+' : '') . format_number($datum->getChange()) ?></td>
                    <td class="colored<?php echo $datum->getChange() > 0 ? ' green' : ($datum->getChange() < 0 ? ' red' : '') ?>"><?php echo ($datum->getChange() > 0 ? '+' : '') . format_number($datum->getChangePercent()) ?></td>
                    </tr>
                <?php endforeach ?>
                </table>
            </div>
            <div class="currency">
                <?php $data = FinanceTickerDataPeer::getTickerData(FinanceTickerDataPeer::FTD_TYPE_CURRENCY); ?>
                <table class="finance_ticker">
                <tr><th></th><th><?php echo __('<span class="ac">Price</span>') ?></th><th><?php echo __('<span class="ac">Change</span>') ?></th><th><?php echo '% ' . __('<span class="ac">Change</span>') ?></th></tr>
                <?php foreach ($data as $datum): ?>
                <tr><td class="symbol"><?php echo $datum->getFinanceTickerItem()->getName() ?></th>
                    <td><?php echo format_number($datum->getData()) ?></td>
                    <td class="colored<?php echo $datum->getChange() > 0 ? ' green' : ($datum->getChange() < 0 ? ' red' : '') ?>"><?php echo ($datum->getChange() > 0 ? '+' : '') . format_number($datum->getChange()) ?></td>
                    <td class="colored<?php echo $datum->getChange() > 0 ? ' green' : ($datum->getChange() < 0 ? ' red' : '') ?>"><?php echo ($datum->getChange() > 0 ? '+' : '') . format_number($datum->getChangePercent()) ?></td>
                    </tr>
                <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>

    <div class="box_312 _border_Shadowed">
        <div>
            <div class="adbox">
<script type="text/javascript"><!--
    google_ad_client = "ca-pub-1242349477299469";
    /* Academy Homepage */
    google_ad_slot = "5223952591";
    google_ad_width = 300;
    google_ad_height = 250;
//--></script><script type="text/javascript"src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
            </div>
            <div>
            <span class="grey small"><?php echo __('Advertisement') ?></span>
            <div class="ghost">
            <span class="grey">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
            <?php echo link_to(__('Create Ad'), '@homepage', 'class=blue small')?></div>
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
                        <?php echo link_to($article, $article->getUrl()) ?>
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