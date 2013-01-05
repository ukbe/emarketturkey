<div class="column span-145 append-2">
<?php if (count($articles)): ?>
<h2><?php echo __('Articles') ?></h2>
<h3><?php echo $author ?></h3>
<?php foreach ($articles as $article): ?>
<div class="post-12507 post hentry post_box" id="post-12507">
    <div class="headline_area">
        <h2 class="entry-title">
            <?php echo link_to($article->getTitle(), '@article?stripped_title='.$article->getStrippedTitle(), array('rel' => 'bookmark', 'title' => __('Permanent link to %1', array('%1' => $article->getTitle())))) ?></h2>
        <p class="headline_meta">
            <abbr class="published" title="<?php echo $article->getCreatedAt('Y-m-d') ?>"><?php echo $article->getCreatedAt('F d, Y') ?></abbr> by&nbsp;
            <span class="author"><?php echo link_to($article->getAuthor(), '@articles-by-author?stripped_display_name='.$article->getAuthor()->getStrippedDisplayName(), array('title' => __('Articles by %1', array('%1' => $article->getAuthor())))) ?></span>
            </p>
        </div>
    <div class="format_text entry-content">
        <p>
            <?php echo $article->getPicture()?image_tag($article->getPictureUri(), 'class=left'):'' ?>
            <?php echo $article->getIntroduction() ?><br /> 
            <?php echo link_to(__('Read Full Article by %1', array('%1' => $article->getAuthor())), '@article?stripped_title='.$article->getStrippedTitle()) ?>
            </p>
        <p class="to_comments">
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=emarketturkey" class="addthis_button_compact">Bookmark/Share</a>
</div> | <?php echo link_to(__('Comments (%1)', array('%1' => CommentPeer::countCommentsFor($article))), '@article?stripped_title='.$article->getStrippedTitle().'#comments') ?>
<?php echo link_to(image_tag('layout/icon/rss.gif'), '@article-feed?stripped_title='.$article->getStrippedTitle(), 'class=comments_rss') ?>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=emarketturkey"></script>
<!-- AddThis Button END -->
            </p> 
        <div class="post_divider"></div>
        <div class="clear"></div>
    </div>
</div>
<?php endforeach ?>

<?php endif ?>
</div>
