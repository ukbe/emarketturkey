<td class="piccol">
    <?php echo link_to(image_tag($result->getThumbUri()), $result->getUrl()) ?>
<td>
    <?php echo link_to($result->getDisplayName()!=''?$result->getDisplayName():$result->getName(), $result->getUrl()) ?><br />
    <em><?php echo $result->getProductCategory() ?></em>
    </td>
<td width="300">
<?php $company = $result->getCompany();
      $contact = $company->getContact();
      $work_address = ($contact?$contact->getWorkAddress():new ContactAddress()); ?>
    <span style="float: right;"><?php echo $work_address->getCountry()!=''?format_country($work_address->getCountry()).'&nbsp;'.image_tag('layout/flag/'.$work_address->getCountry().'.png', 'style=margin-right:5px;width:20px;'):'' ?></span>
    <?php echo link_to($company, $company->getProfileUrl()) ?><br />
    <em><b><?php echo $company->getBusinessType() ?></b></em><br />
    <em><?php echo $company->getBusinessSector() ?></em><br />
    </td>