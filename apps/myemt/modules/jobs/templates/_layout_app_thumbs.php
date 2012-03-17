<div class="thumbs-view">
<?php $i = 0; ?>
<?php if (count($results = $pager->getResults())): ?>
<?php foreach ($results as $app): ?>
    <?php $i++; ?>
    <div class="item"<?php echo $i % 5 == 0 ? ' style="margin-right: 0x;"' : '' ?>>
        <?php echo link_to(image_tag($app->getUser()->getResume()->getPhotoUri()), $url = $job->getApplicantUrl($app->getId())) ?><br />
        <?php echo link_to($app->getUser(), $url) ?>
    </div>
<?php endforeach ?>
<?php else: ?>
    <div class="no-items"><?php echo __('No items') ?></div>
<?php endif ?>
</div>