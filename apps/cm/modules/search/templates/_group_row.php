<?php 
switch ($column)
{
    case 'id': echo link_to(image_tag($row->getProfilePictureUri()), $row->getProfileUrl()); break;
    case 'name': $contact = $row->getContact();
      $work_address = ($contact?$contact->getWorkAddress():new ContactAddress()); ?>
    <span style="float: right;"><?php echo $work_address->getCountry()!=''?format_country($work_address->getCountry()).'&nbsp;'.image_tag('layout/flag/'.$work_address->getCountry().'.png', 'style=margin-right:5px;width:20px;'):'' ?></span>
    <?php echo link_to($row->getDisplayName(), $row->getProfileUrl()) ?><br />
    <span class="column span-35"><b><?php echo $row->getGroupType() ?></b></span><span class="hint"><?php echo format_number_choice('[0]No members|[1]1 member|(1,+Inf]%1 members', array('%1' => ($cnt = $row->countMembers())), $cnt) ?></span>
     <?php break;
    default: break;
}
?>