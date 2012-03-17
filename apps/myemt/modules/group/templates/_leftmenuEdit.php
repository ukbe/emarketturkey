<ol class="leftactions">
<li<?php echo $sf_context->getActionName()=='basic'?' class="selected"':'' ?>><?php echo link_to(__('Basic Information'), '@group-manage?action=basic&stripped_name='.$group->getStrippedName()) ?></li>
<li<?php echo $sf_context->getActionName()=='contact'?' class="selected"':'' ?>><?php echo link_to(__('Contact Information'), '@group-manage?action=contact&stripped_name='.$group->getStrippedName()) ?></li>
</ol>