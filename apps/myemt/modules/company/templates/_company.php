<table class="sticker">
<tr><td><?php echo $company->getLogo() ? link_to(image_tag($company->getLogo()->getThumbnailUri()), $company->getProfileUrl()) : "" ?></td>
<td><b><?php echo link_to($company->getName(), $company->getProfileUrl()) ?></b>
<div class="t_grey"><?php echo $company->getBusinessSector() ?></div></td></tr>
</table>