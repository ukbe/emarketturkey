<?php use_helper('Date', 'I18N') ?>
<?php slot('uppermenu') ?>
<?php include_partial('default/uppermenu') ?>
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('search/filter', array('filtercats' => $filtercats, 'criterias' => $criterias, 'searchroute' => $searchroute)) ?>
<?php end_slot() ?>
<h2><?php echo __('Search Results') ?></h2>
<div id="ress">
<?php if (count($results)): ?>
<table width="100%" class="searchresults">
<?php foreach ($results as $result): ?>
<tr>
<td class="piccol">
    <?php echo link_to(image_tag($result->getOwner()->getHrProfile()->getLogo()), $result->getOwner()->getProfileUrl()) ?>
<td>
    <?php echo link_to($result->getName()!=''?$result->getDisplayName():$result->getName(), $result->getUrl()) ?><br />
    <em><?php echo $result->getProductCategory() ?></em>
    </td>
<td width="300">
<?php $owner = $result->getOwner();
      $contact = $owner->getContact();
      $work_address = ($contact?$contact->getWorkAddress():new ContactAddress()); ?>
    <span style="float: right;"><?php echo $work_address->getCountry()!=''?format_country($work_address->getCountry()).'&nbsp;'.image_tag('layout/flag/'.$work_address->getCountry().'.png', 'style=margin-right:5px;width:20px;'):'' ?></span>
    <?php echo link_to($owner, $owner->getProfileUrl()) ?><br />
    <?php if (PrivacyNodeTypePeer::getTypeFromClassname($owner)==PrivacyNodeTypePeer::PR_NTYP_COMPANY): ?>
    <em><b><?php echo $owner->getBusinessType() ?></b></em><br />
    <em><?php echo $owner->getBusinessSector() ?></em><br />
    <?php endif ?>
    </td>
</tr>
<?php endforeach ?>
</table>
<?php else: ?>
<span style="font-size: 14px;"><?php echo __('No results found for keyword "%1"', array('%1' => $criterias['keyword'])) ?></span>
<?php endif ?>
</div>