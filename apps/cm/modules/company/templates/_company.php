<table class="sticker">
<tr><td><?php echo $company->getLogo() ? link_to(image_tag($company->getLogo()->getThumbnailUri()), $company->getProfileUrl()) : "" ?></td>
<td><b><?php echo link_to($company->getName(), $company->getProfileUrl()) ?></b>
<div class="t_grey margin-t1"><?php echo $company->getBusinessSector() ?>
    <?php if (isset($company->relevel)): ?><span class="relevel margin-l2"><?php echo $company->relevel ?></span><?php endif ?>
    </div></td></tr>
</table>