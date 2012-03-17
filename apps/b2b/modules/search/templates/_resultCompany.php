<td class="piccol">
    <?php echo link_to(image_tag($result->getProfilePictureUri()), $result->getProfileUrl()) ?></td>
<td>
<?php $contact = $result->getContact();
      $work_address = ($contact?$contact->getWorkAddress():new ContactAddress()); ?>
    <span style="float: right;"><?php echo $work_address->getCountry()!=''?format_country($work_address->getCountry()).'&nbsp;'.image_tag('layout/flag/'.$work_address->getCountry().'.png', 'style=margin-right:5px;width:20px;'):'' ?></span>
    <?php echo link_to($result->getName(), $result->getProfileUrl()) ?><br />
    <b><?php echo $result->getBusinessType() ?></b><br />
    <em><?php echo $result->getBusinessSector() ?></em></td>