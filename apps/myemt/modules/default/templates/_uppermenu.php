<ol class="homemenu">
    <li><?php echo link_to(__('Network Activity'), '@homepage', (($sf_context->getRouting()->getCurrentRouteName()=='homepage' || $sf_context->getRouting()->getCurrentRouteName()=='homepage1') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Manage'), '@manage', ($sf_context->getRouting()->getCurrentRouteName()=='manage' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to_function(__('Statistics'), '#', ($sf_context->getRouting()->getCurrentRouteName()=='statistics' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Find Friends').'<em class="new-tag">'.__('New!').'</em>', '@camp.friendfinder') ?></li>
</ol>