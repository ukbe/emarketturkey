<?php slot('mappath') ?>
<?php include_partial('group/group_pagetop', array('map' => array(__('Manage Group') => '@group-manage?action=manage&stripped_name='.$group->getStrippedName(),
                                                                  __('Invite People') => null),
                                                   'group' => $group
                                                   )) ?> 
<?php end_slot() ?>
<?php slot('leftcolumn') ?>
<?php include_partial('leftmenuMembers', array('group' => $group)) ?>
<?php end_slot() ?>
<?php echo form_tag('@group-manage?action=sendMail&stripped_name='.$group->getStrippedName()) ?>
<div class="column span-110">
<h1><?php echo __('Invite People') ?></h1>
<?php echo __('Invite People Tool, lets you invite people to join your group on eMarketTurkey.') ?>
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

    <?php slot('rightcolumn') ?>
<div style="text-align: center;"><?php echo image_tag('content/invite/template-1/network.png', 'width=150') ?></div>
    <?php end_slot() ?>
