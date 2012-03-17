<?php use_helper('Date') ?>
<table class="data-table extended">
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $company): ?>
    <tr>
        <td><?php echo link_to(image_tag($company->getProfilePictureUri()), $company->getProfileUrl()) ?></td>
        <td><strong><?php echo link_to($company->getName(), $company->getProfileUrl()) ?></strong>
            <em><?php echo $company->getBusinessSector() ?></em>
            <em><?php echo $company->getBusinessType() ?></em>
            </td>
        <td></td>
        <td><?php echo $company->getContact()->getWorkAddress()->getGeonameCity(). ', ' . format_country($company->getContact()->getWorkAddress()->getCountry()) . '' ?>
        <div>
        <?php if (isset($company->relevel)): ?><span class="relevel margin-t2">
        <?php if (isset($company->role_id)): ?><span class="role"><?php echo RolePeer::retrieveByPK($company->role_id)->getRoleRelatedByOppositeRoleId() ?></span><?php endif ?>
        </span>
        <?php endif ?></div></td>
    </tr>
<?php endforeach ?>
<?php else: ?>
    <tr class="no-items"><td colspan="4"><?php echo __('No items') ?></td></tr>
<?php endif ?>
</table>