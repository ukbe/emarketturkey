<table class="sticker">
<tr><td><?php echo $place->getLogo() ? image_tag($place->getLogo()->getThumbnailUri()) : "" ?></td>
<td><strong><?php echo $place->getName() ?></strong><br />
<?php echo $place->getGeonameCity() . ', ' . format_country($place->getCountry()) ?><br />
<small><?php echo $place->getPlaceType() ?></small></td></tr>
</table>