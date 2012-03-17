<ol class="homemenu">
    <li><?php echo link_to(__('Contacts'), '@network', ($sf_context->getRouting()->getCurrentRouteName()=='network' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Requests') . (($reqcnt = $sf_user->getUser()->getRequestCount()) ? "<span class=\"attention\">$reqcnt</span>" : ''), '@requests', ($sf_context->getRouting()->getCurrentRouteName()=='requests' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('Notifications'), '@notifications', ($sf_context->getRouting()->getCurrentRouteName()=='notifications' ? 'class=selected' : '')) ?></li>
    <li><?php echo link_to(__('People You May Know'), '@pymk', ($sf_context->getRouting()->getCurrentRouteName()=='pymk' ? 'class=selected' : '')) ?></li>
</ol>