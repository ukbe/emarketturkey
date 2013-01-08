<div class="post-item-video">
<dl class="_table">
<dt><?php echo $item->getImage() ? link_to_function(image_tag($item->getImage()->getThumbnailUri()), '') : '' ?></dt>
<dd><?php echo link_to($item->getTitle(), $item->getUrl(), 'target=blank') ?>
    <div><?php echo $item->getMessage() ?></div>
</dd>
</dl>
</div>