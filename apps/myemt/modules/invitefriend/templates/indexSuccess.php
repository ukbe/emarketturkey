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
<?php echo __('Invite Friends Tool, lets you invite your friends to join eMarketTurkey.') ?>
<div class="hrsplit-2"></div>
<?php echo form_errors() ?>
<div class="hrsplit-1"></div>
<?php echo form_tag('invitefriend/index') ?>
<ol class="column span-95">
<li class="column span-24 right append-1"><?php echo emt_label_for('emaillist', __('E-mail List')) ?></li>
<li class="column span-70"><?php echo textarea_tag('emaillist', $sf_params->get('emaillist'), 'cols=50 rows=5') ?><br /><em><?php echo __('please enter only one email address per line') ?></em></li>
<li class="column span-24 right append-1"><?php echo emt_label_for('message', __('Invite Message').'<br /><em>('.__('optional').')</em>') ?></li>
<li class="column span-70"><?php echo textarea_tag('message', $sf_params->get('message'), 'cols=50 rows=5') ?></li>
<li class="column span-24 right append-1"><?php echo emt_label_for('cult', __('Invitation Language')) ?></li>
<li class="column span-70"><?php echo select_tag('cult', options_for_select(array('tr' => 'Türkçe', 'en' => 'English'), $sf_params->get('cult'))) ?></li>
<li class="column span-24 append-1"></li>
<li class="column span-70"><?php echo submit_tag(__('Send Invitation')) ?></li>
</ol>
</form>
</div>
<div class="column span-79 prepend-3" style="text-align: center;">
<?php echo image_tag('content/invite/template-1/network.png') ?>
</div>
</div>
