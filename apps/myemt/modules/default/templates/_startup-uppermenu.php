<ol class="homemenu">
    <li><?php echo link_to(__('Setup Your Profile'), 'default/setupProfile', (($sf_context->getActionName()=='setupProfile') ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Find Friends').'<em class="new-tag">'.__('New!').'</em>', '@cm.friendfinder') ?></li>
</ol>