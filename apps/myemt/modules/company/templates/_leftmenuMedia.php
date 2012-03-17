<ol class="leftactions">
<li<?php echo $sf_context->getActionName()=='media'?' class="selected"':'' ?>><?php echo link_to(__('Media Overview'), "@company-media?hash={$company->getHash()}") ?></li>
<li<?php echo $sf_context->getActionName()=='logo'?' class="selected"':'' ?>><?php echo link_to(__('Company Logo'), "@upload-company-logo?hash={$company->getHash()}") ?></li>
<li<?php echo $sf_context->getActionName()=='productphotos'?' class="selected"':'' ?>><?php echo link_to(__('Product Photos'), "@company-media?hash={$company->getHash()}") ?></li>
<li<?php echo $sf_context->getActionName()=='documents'?' class="selected"':'' ?>><?php echo link_to(__('Documents'), "@company-media?hash={$company->getHash()}") ?></li>  
<li<?php echo $sf_context->getActionName()=='videos'?' class="selected"':'' ?>><?php echo link_to(__('Videos'), "@company-media?hash={$company->getHash()}") ?></li>  
</ol>