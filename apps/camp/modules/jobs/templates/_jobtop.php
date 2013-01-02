<div class="parentlink">
<?php echo link_to(__('Jobs'), '@homepage') . image_tag('layout/icon/bullet2.png') . '<span>' . __('<b>%1jp</b> at <b>%2c</b>', array('%1jp' => $job->getDisplayTitle() ? $job->getDisplayTitle() : $job->getTitle(), '%2c' => $job->getOwner())) . '</span>' ?>
</div>