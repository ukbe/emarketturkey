<div class="post-item-video">
<dl class="_table">
<dt><?php echo $item->getMediaItem() ? link_to_function(image_tag($item->getMediaItem()->getThumbnailUri()), '') : '' ?></dt>
<dd><?php echo link_to($item->getTitle(), $item->getUrl()) ?>
    <div><?php echo $item->getMessage() ?></div>
</dd>
</dl>
</div>