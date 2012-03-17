<div class="thumbs-view">
<?php $i = 0; ?>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $job): ?>
    <?php $i++; ?>
    <div class="item<?php echo $job->getNewApplicants(true) ? ' hasnew' : '' ?>"<?php echo $i % 5 == 0 ? ' style="margin-right: 0x;"' : '' ?>>
        <?php echo link_to(image_tag($job->getLogoUri()), $url = $job->getManageUrl()) ?><br />
        <?php echo link_to($job, $url) ?>
    </div>
<?php endforeach ?>
<?php else: ?>
    <div class="no-items"><?php echo __('No items') ?></div>
<?php endif ?>
</div>