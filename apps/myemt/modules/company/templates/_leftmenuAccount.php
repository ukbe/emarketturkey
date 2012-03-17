<ol class="leftactions">
<li<?php echo $sf_context->getActionName()=='request'?' class="selected"':'' ?>><?php echo link_to(__('Request New Service'), 'service/request') ?></li>
<li<?php echo $sf_context->getActionName()=='list'?' class="selected"':'' ?>><?php echo link_to(__('Active Services'), 'service/list') ?></li>
<li<?php echo $sf_context->getActionName()=='pendingList'?' class="selected"':'' ?>><?php echo link_to(__('Pending Requests'), 'service/pendingList') ?></li>
<li<?php echo $sf_context->getActionName()=='paymentHistory'?' class="selected"':'' ?>><?php echo link_to(__('Payment History'), 'service/paymentHistory') ?></li>  
</ol>