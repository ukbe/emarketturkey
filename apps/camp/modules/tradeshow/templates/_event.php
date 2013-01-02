<?php use_helper('Date') ?>
<table class="sticker">
<tr><td><?php echo $event->getLogo() ? image_tag($event->getLogo()->getThumbnailUri()) : "" ?></td>
<td><b><?php echo $event ?></b> <span style="white-space: nowrap;">(<?php echo format_datetime($event->getTimeScheme()->getStartDate('U'), 'f') ?>)</span><br />
<?php $line = array($event->getOrganiserName(), $event->getLocationName()) ?>
<?php echo implode(', ', array_filter($line)) ?><br />
<?php $line = array($event->getGeonameCity(), $event->getLocationCountry() ? format_country($event->getLocationCountry()) : null) ?>
<?php echo implode(', ', array_filter($line)) ?><br />
<?php echo link_to(__('Go to Event Page'), $event->getUrl()) ?>
<?php echo $sf_user->getUser()->isOwnerOf($event) ?  sepdot() . link_to(__('Manage Event'), $event->getManageUrl()) : '' ?></td></tr>
</table>