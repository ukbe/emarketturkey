<ol class="homemenu">
    <li><?php echo link_to(__('Account Settings'), '@account', ($sf_context->getModuleName()=='account' && ($sf_context->getActionName()=='edit' || $sf_context->getActionName()=='index' || $sf_context->getActionName()=='changePassword') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Privacy Settings'), '@setup-privacy', ($sf_context->getRouting()->getCurrentRouteName()=='setup-privacy' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to_function(__('Notifications'), '#', ($sf_context->getRouting()->getCurrentRouteName()=='notification-set' ? 'class=selected' : '')) ?></li>
</ol>