<div class="column span-198">
<ol class="column mappath">
<li><?php echo link_to(__('MyEMT'), '@homepage') ?></li>
<li><?php echo link_to(__('Tools'), 'tools/index') ?></li>
<li><?php echo link_to(__('Networking'), '@network-tools') ?></li>
<li class="last"><?php echo __('Invite Friends') ?></li>
</ol>
<ol class="column" style="margin: 0px;">
</ol>
</div>
<div class="hrsplit-1"></div>
<div class="column span-198">
<div class="column span-105 prepend-5">
<h1><?php echo __('Invite Friends') ?></h1>
<?php echo format_number_choice('[0]No friends were invited|[1]1 friend was invited|(1,+Inf]%1% friends were invited', array('%1%' => count($sent)), count($sent)) ?>
</div>
<div class="column span-79 prepend-3" style="text-align: center;">
<?php echo image_tag('content/invite/template-1/network.png') ?>
</div>
</div>
