<ol class="leftactions">
<li<?php echo $sf_context->getActionName()=='media'?' class="selected"':'' ?>><?php echo link_to(__('Media Overview'), '@group-manage?action=media&stripped_name='.$group->getStrippedName()) ?></li>
<li<?php echo $sf_context->getActionName()=='logo'?' class="selected"':'' ?>><?php echo link_to(__('Group Logo'), '@group-manage?action=logo&stripped_name='.$group->getStrippedName()) ?></li>
<li<?php echo $sf_context->getActionName()=='photos'?' class="selected"':'' ?>><?php echo link_to(__('Group Photos'), '@group-manage?action=photos&stripped_name='.$group->getStrippedName()) ?></li>
<li<?php echo $sf_context->getActionName()=='documents'?' class="selected"':'' ?>><?php echo link_to(__('Documents'), '@group-manage?action=documents&stripped_name='.$group->getStrippedName()) ?></li>
<li<?php echo $sf_context->getActionName()=='videos'?' class="selected"':'' ?>><?php echo link_to(__('Videos'), '@group-manage?action=videos&stripped_name='.$group->getStrippedName()) ?></li>
</ol>