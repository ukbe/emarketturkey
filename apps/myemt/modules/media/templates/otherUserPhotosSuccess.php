<div class="column span-198">
<div class="column">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to($user, $user->getProfileUrl()) ?></li>
<li class="last"><?php echo __('Photos') ?></li>
</ol>
</div>
<ol class="column command-menu">
<li></li>
</ol>
<ol class="inline-form">
<li></li></ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-146 last">
<div class="column span-100 pad-1 append-1">
<h2>Photos</h2>
<?php if (count($photos)): ?>
<?php $i = 0 ?>
<table class="column photo-album span-140">
<?php foreach ($photos as $photo): ?>
<?php $i++; ?>
<?php if (($i % 4) == 1 ): ?>
<tr>
<?php endif ?>
<td><?php echo link_to(image_tag($photo->getMediumUri()), 'media/photos', array('query_string' => 'mod=display&id='.$user->getId().'&pid='.$photo->getId())) ?></td>
<?php if (($i % 4) == 0 ): ?>
</tr>
<?php endif ?>
<?php endforeach ?>
<?php if (($i % 4) != 0 ): ?>
</tr>
<?php endif ?>
</table>
<?php else: ?>
<p><?php echo __('%1 does not have any photos, yet.', array('%1' => link_to($user, $user->getProfileUrl()))) ?></p>
<?php endif ?>
</div>
</div>
<div class="column span-49 pad-1 divbox">
<h3><?php echo __('Media Tools') ?></h3>
</div>
