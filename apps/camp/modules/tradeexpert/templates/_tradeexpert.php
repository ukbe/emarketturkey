<table class="sticker">
<tr><td><?php echo $tradeexpert->getProfilePicture() ? link_to(image_tag($tradeexpert->getProfilePictureUri()), $tradeexpert->getProfileUrl()) : "" ?></td>
<td><b><?php echo link_to($tradeexpert->__toString(), $tradeexpert->getProfileUrl()) ?></b>
<div class="t_grey margin-t1"><?php echo $tradeexpert->getIndustriesText() ?>
    <?php if (isset($tradeexpert->relevel)): ?><span class="relevel margin-l2"><?php echo $tradeexpert->relevel ?></span><?php endif ?>
    </div></td></tr>
</table>