<dl class="_table">
<dt><?php echo $item->getMediaItem() ? link_to(image_tag($item->getMediaItem()->getThumbnailUri()), $item->getUrl()) : '' ?></dt>
<dd><?php echo link_to($item->getTitle(), $item->getUrl()) ?>
    <div><?php echo $item->getMessage() ?></div>
</dd>
</dl>