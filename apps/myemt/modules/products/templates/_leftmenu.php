<ol class="leftactions">
<li<?php echo ($sf_context->getActionName()=='new' && $sf_params->get('id')===null)?' class="selected"':'' ?>><?php echo link_to(__('Add New Product'), "@add-product?hash={$company->getHash()}") ?></li>
<li<?php echo $sf_context->getActionName()=='list'?' class="selected"':'' ?>><?php echo link_to(__('List Products'), "@manage-products?hash={$company->getHash()}") ?></li>
</ol>