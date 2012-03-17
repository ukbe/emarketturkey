<?php foreach ($selected_sectors as $selected_sector): ?>
<li class="column span-30 sector" id="s_<?php echo $selected_sector->getId() ?>">
<?php if_javascript(); ?>
<?php echo link_to_function(image_tag('layout/icon/delete-13x14.png'), '') ?>
<?php end_if_javascript(); ?>
<noscript><?php echo link_to(image_tag('layout/icon/delete-13x14.png'), 'default/removeSector', array('query_string' => "sector_id={$selected_sector->getId()}")) ?></noscript>
<?php echo $selected_sector->getName() ?></li>
<li class="column span-8 sector right" id="t_<?php echo $selected_sector->getId() ?>"><?php echo link_to($selected_sector->countJobApplications(), 'jobs/list') ?></li>
<?php endforeach ?>
<?php echo javascript_tag('window.initsects();') ?>
