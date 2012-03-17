<ol class="homemenu">
    <li><?php echo link_to(__('Find Friends'), '@friendfinder', ($sf_context->getRouting()->getCurrentRouteName()=='friendfinder' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Windows Live Contacts'), '@livecontacts', (strpos($sf_context->getRouting()->getCurrentRouteName(), 'consent-')===0 ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Invite Friends'), '@invite-friends', ($sf_context->getRouting()->getCurrentRouteName() == 'invite-friends' ? 'class=selected' : '')) ?></li>
</ol>