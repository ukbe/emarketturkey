<?php if ($sf_user->hasFlash('message_header') || $sf_user->hasFlash('message')): ?>
<div id="message-bar">
<span class="action"><?php echo link_to_function('X', visual_effect('fade', 'message-bar')) ?></span>
<h2><?php echo $sf_user->getFlash('message_header') ?></h2>
<p><?php echo $sf_user->getFlash('message') ?></p>
</div>
<?php // echo javascript_tag("new PeriodicalExecuter(function(p) {".visual_effect('fade', 'message-bar').";p.stop();}, 10)") ?>
<div class="hrsplit-1"></div>
<?php endif ?>