<table class="sticker">
<tr><td><?php echo ($photo = $product->getPhotos(1)) ? link_to(image_tag($photo->getThumbnailUri()), $product->getUrl()) : "" ?></td>
<td><b><?php echo link_to($product->__toString(), $product->getUrl()) ?></b>
<div class="t_grey margin-t1"><?php echo $product->getProductCategory()->__toString() ?>
    <?php if (isset($product->relevel)): ?><span class="relevel margin-l2"><?php echo $product->relevel ?></span><?php endif ?>
    </div>
<div class="margin-t1"><?php echo $product->getCompany()->__toString() ?></div>
</td></tr>
</table>