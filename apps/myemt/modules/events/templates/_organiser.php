<table class="sticker">
<tr><td><?php echo link_to(image_tag($organiser->getProfilePictureUri()), $organiser->getProfileUrl()) ?></td>
<td><b><?php echo $organiser->getName() ?></b><br />
<?php echo $organiser instanceof Company ? $organiser->getBusinessSector() : $organiser->getGroupType() ?></td></tr>
</table>