<table class="sticker">
<tr><td><?php echo ($photo = $lead->getPhotos(1)) ? link_to(image_tag($photo->getThumbnailUri()), $lead->getUrl()) : "" ?></td>
<td><b><?php echo link_to($lead, $lead->getUrl()) ?></b>
<div class="t_grey margin-t1"><?php echo $lead->getProductCategory() ?>
    <?php if (isset($lead->relevel)): ?><span class="relevel margin-l2"><?php echo $lead->relevel ?></span><?php endif ?>
    </div>
<div class="margin-t1"><?php echo $lead->getCompany() ?></div>
</td></tr>
</table>