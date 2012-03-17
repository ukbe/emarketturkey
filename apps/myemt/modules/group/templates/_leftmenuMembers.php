<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='members' && $sf_params->get('typ')=='')?' class="selected"':'' ?>><?php echo link_to(__('List Members'), '@group-manage?action=members&stripped_name='.$group->getStrippedName()) ?></li>
<li<?php echo ($sf_context->getActionName()=='members' && $sf_params->get('typ')=='pending')?' class="selected"':'' ?>><?php echo link_to(__('Pending Members'), '@group-manage?action=members&stripped_name='.$group->getStrippedName().'&typ=pending') ?></li>
<li<?php echo $sf_context->getActionName()=='invite'?' class="selected"':'' ?>><?php echo link_to(__('Invite People'), '@group-manage?action=invite&stripped_name='.$group->getStrippedName()) ?></li>
<?php if ($sf_context->getActionName()=='invite' || $sf_context->getActionName()=='sendMail' || $sf_context->getActionName()=='search'): ?>
<li class="sub<?php echo $sf_context->getActionName()=='sendMail'?' selected':'' ?>"><?php echo link_to(__('Send Email'), '@group-manage?action=sendMail&stripped_name='.$group->getStrippedName()) ?></li>
<li class="sub<?php echo $sf_context->getActionName()=='search'?' selected':'' ?>"><?php echo link_to(__('Perform Search'), '@group-manage?action=search&stripped_name='.$group->getStrippedName()) ?></li>
<?php endif ?>
</ol>